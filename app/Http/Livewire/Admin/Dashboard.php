<?php

namespace App\Http\Livewire\Admin;

use App\Exports\EmployeesDataExport;
use App\Models\Advance;
use App\Models\Bonus;
use App\Models\EmployeesDetail;
use App\Models\EventOrder;
use App\Models\Fine;
use App\Models\Log;
use App\Models\Payroll;
use App\Services\PaymentsCalculationsService;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Dashboard extends Component

{
    use WithPagination;

    public $currentMonth, $currentMonthName, $currentYear, $today, $days, $instance, $employees;
    public $estimated = null;
    public $month;
    protected $paginationTheme = 'bootstrap';
    public $total_fines = null;
    public $total_bonuses = null;
    public $total_advances = null;
    public $incompleteEmployees;
    public $total_overtimes;


    // private $columnChartModel;


    // for Payroll Graph
    public $monthsRange = [];
    public $labels = [];
    public $datasets = [];
    public $data = [];

    public $readyToLoad = false;


    public function loadItems()
    {
        $this->readyToLoad = true;
    }

    function totalOvertime()
    {
        $total = 0;
        foreach ($this->employees as $employee) {
            $total += $employee->EarnedOvertimeKes($this->instance->format('Y-m'));
        }

        return $total;
    }


    function downloadEmployeesData()
    {

        $this->emit('done', [
            'success' => 'Employees data exported successfully'
        ]);
        return Excel::download(new EmployeesDataExport, 'employees data.xlsx')->deleteFileAfterSend();
    }
    function loadPayrollGraph()
    {

        $range = [];
        $labels = [];
        $data = [];
        for ($i = 0; $i <= 7; $i++) {
            array_push($range, $this->instance->copy()->subMonthsNoOverflow(7 - $i));
        }
        foreach ($range as $month) {
            array_push($labels, $month->format('F, Y'));
            $payroll = Payroll::where('month', $month->format('m'))->where('year', $month->format('Y'));
            if ($payroll->exists()) {
                array_push($data, $payroll->first()->full_gross);
            } else {
                array_push($data, 0);
            }
        }


        $this->monthsRange = $range;
        $this->labels = $labels;
        $this->data = $data;
    }

    function mount()
    {
        $this->instance = Carbon::now();
        $this->employees = EmployeesDetail::all();
        $this->today = $this->instance->format('Y-m-d');
        $this->month = $this->instance->format('Y-m');
        $this->total_overtimes = $this->totalOvertime();
        // $this->estimated = $this->estimated_earnings();
        // $this->loadPayrollGraph();
        // $this->incompleteEmployees = $this->incompleteEmployees();
    }

    function incompleteEmployees()
    {

        $employees = EmployeesDetail::where('kra_pin', null)->orWhere('nssf', null)->orWhere('nhif', null)->get();
        $collect = [];
        foreach ($employees as $employee) {
            if ($employee->isFullTimeBetween('01/01/1970', 'now')) {
                array_push($collect, $employee);
            }
        }
        return collect($collect);
    }




    function estimated_earnings()
    {
        $earning = 0;
        $nssf = 0;
        $nhif = 0;
        $ahl = 0;
        foreach ($this->employees as $key => $employee) {
            $calculations = new PaymentsCalculationsService($employee->EarnedSalaryKes($this->instance->format('Y-m')), $this->instance->toDateTimeString());
            $earning += $employee->EarnedSalaryKes($this->instance->format('Y-m'));
            $nssf += $employee->EarnedSalaryKes($this->instance->format('Y-m')) > 0 ? $calculations->nssf() : 0;
            $nhif += $calculations->nhif();
            $ahl += $calculations->ahl();
        }

        return $earning + $nssf + $ahl;
    }

    public function render()
    {
        $columnChartModel =
            (new ColumnChartModel())
            ->setTitle("Payroll Graph");
        if ($this->readyToLoad) {
            # code...
            $this->instance = Carbon::parse($this->month);

            $this->days = $this->instance->daysInMonth;
            $this->currentMonthName = $this->instance->format('F');
            $this->currentMonth = $this->instance->format('m');
            $this->currentYear = $this->instance->format('Y');

            $this->total_fines = 0;
            foreach (Fine::all() as $fine) {
                if ($fine->year == $this->instance->format('Y') && $fine->month == $this->instance->format('m')) {
                    $this->total_fines += $fine->amount_kes;
                }
            }
            $this->total_advances = 0;
            foreach (Advance::all() as $advance) {
                if ($advance->year == $this->instance->format('Y') && $advance->month == $this->instance->format('m')) {
                    $this->total_advances += $advance->amount_kes;
                }
            }
            $this->total_bonuses = 0;
            foreach (Bonus::all() as $bonus) {
                if ($bonus->year == $this->instance->format('Y') && $bonus->month == $this->instance->format('m')) {
                    $this->total_bonuses += $bonus->amount_kes;
                }
            }

            $this->estimated = $this->estimated_earnings();
            $this->loadPayrollGraph();
            $this->incompleteEmployees = $this->incompleteEmployees();

            foreach ($this->labels as $key => $label) {
                $columnChartModel->addColumn($label, $this->data[$key], "#242464");
            }
        }

        // $this->emit('loadedAll');


        return view('livewire.admin.dashboard', [
            'logs' => $this->readyToLoad ? Log::orderBy('id', 'DESC')->paginate(10) : [],
            'columnChartModel' => $this->readyToLoad ? $columnChartModel : new ColumnChartModel(),
        ]);
    }
}
