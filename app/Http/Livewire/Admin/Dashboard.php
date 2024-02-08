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
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Dashboard extends Component

{
    use WithPagination;

    public $currentMonth, $currentMonthName, $currentYear, $today, $days, $instance, $employees;
    public $estimated = 0;
    public $total_penalties = 0;
    public $month;
    protected $paginationTheme = 'bootstrap';
    public $total_fines = 0;
    public $total_bonuses = 0;
    public $total_advances = 0;
    public $incompleteEmployees;


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


    function downloadEmployeesData()
    {
        return Excel::download(new EmployeesDataExport, 'employees data.xlsx');

        $this->emit('done', [
            'success' => 'Employees data exported successfully'
        ]);
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
                array_push($data, $payroll->first()->total);
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
        // $this->estimated = $this->estimated_earnings();
        // $this->loadPayrollGraph();
        $this->incompleteEmployees = $this->incompleteEmployees();
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

    function penalties()
    {
        $total_penalties = 0;
        foreach ($this->employees as $key => $employee) {
            $penalty = 0;
            $rate = 0;
            $days = $employee->daysWorked($this->instance->format('Y-m'));
            $leaveDays = $employee->daysOnLeave($this->instance->format('Y-m'));
            $daysMissed = $this->instance->daysInMonth - $days - $leaveDays;
            $contract = $employee->ActiveContractDuring($this->instance->format('Y-m'));

            if ($contract) {
                if ($employee->isCasualBetween($this->instance->firstOfMonth(), $this->instance->lastOfMonth()) || $employee->isInternBetween($this->instance->firstOfMonth(), $this->instance->lastOfMonth())) {
                    $rate = $contract->salary_kes;
                } else {
                    $rate = $contract->salary_kes / $this->instance->daysInMonth;
                }
            }
            if ($employee && $employee->isFullTimeBetween($this->instance->firstOfMonth(), $this->instance->lastOfMonth())) {
                if ($employee->isFullTimeBetween($this->instance->firstOfMonth(), $this->instance->lastOfMonth()) && $employee->designation->is_penalizable) {
                    if ($daysMissed > 6) {
                        $penalty = $rate * ($daysMissed - 6);
                    }
                } else {
                    $penalty = 0;
                }
            }
            $total_penalties += $penalty;
        }

        return $total_penalties;
    }
    function estimated_earnings()
    {
        $earning = 0;
        foreach ($this->employees as $key => $employee) {
            $days = $employee->daysWorked($this->instance->format('Y-m'));
            $basic_salary_kes = 0;
            $contract = $employee->ActiveContractDuring($this->instance->format('Y-m'));
            if ($contract) {
                if ($contract->is_full_time()) {
                    $basic_salary_kes = $contract->salary_kes;
                } else if ($contract->is_casual()) {
                    $basic_salary_kes = $contract->salary_kes * $days;
                } else if ($contract->is_intern()) {
                    $basic_salary_kes = $contract->salary_kes;
                } else if ($contract->is_external()) {
                    $basic_salary_kes = $contract->salary_kes;
                }
            } else {
                $basic_salary_kes = 0;
            }

            $gross = ($basic_salary_kes ?? 0);

            $earning += $gross;
        }

        return $earning;
    }

    public function render()
    {
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
            $this->total_penalties = $this->penalties();
            $this->loadPayrollGraph();
            $this->incompleteEmployees = $this->incompleteEmployees();
        }


        return view('livewire.admin.dashboard', [
            'logs' => $this->readyToLoad ? Log::orderBy('id', 'DESC')->paginate(10) : []
        ]);
    }
}
