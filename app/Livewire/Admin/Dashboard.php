<?php

namespace App\Livewire\Admin;

use App\Exports\EmployeesDataExport;
use App\Models\Advance;
use App\Models\Bonus;
use App\Models\EmployeesDetail;
use App\Models\Fine;
use App\Models\Log;
use App\Models\Payroll;
use App\Services\PaymentsCalculationsService;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Carbon\Carbon;
use Livewire\Attributes\Lazy;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Dashboard extends Component
{

    public $instance;
    public $employees;
    public $estimated = null;
    public $month = null;
    public $total_fines = null;
    public $total_bonuses = null;
    public $total_advances = null;
    public $incompleteEmployees;
    public $total_overtimes = null;


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
        $this->dispatch(
            'done',
            success: 'Employees data exported successfully'
        );
        return Excel::download(new EmployeesDataExport, env('COMPANY_NAME') . ' - Employees Data - ' . Carbon::now()->getTimestamp() . '.xlsx')->deleteFileAfterSend();
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
            $payroll = Payroll::where('month', $month->format('m'))->where('year', $month->format('Y'));
            $data[] = $payroll->first()->full_gross ?? 0;
            $labels[] = $month->format('F, Y');
        }


        $chartModel = LivewireCharts::multiLineChartModel();
        $chartModel->setTitle("Total Amount");
        $chartModel->setAnimated('ease-in');
        $chartModel->setSmoothCurve();
        $chartModel->setDataLabelsEnabled(true);
        foreach ($data as $key => $value) {
            $chartModel->addSeriesPoint( "Payroll Amount",$labels[$key], $value);
        }

        $chartModel->setJsonConfig([
            'tooltip.y.formatter' => '(val) => `KES ${val.toLocaleString()}`',
            'dataLabels.formatter' => '(val) => `KES ${val.toLocaleString()}`',
            'yaxis.labels.formatter' => '(val) => `KES ${val.toLocaleString()}`',
        ]);

        return $chartModel;
    }

    function mount()
    {
        $this->instance = Carbon::now();
        $this->employees = EmployeesDetail::all();
        $this->month = $this->instance->format('Y-m');

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

        $this->total_overtimes = 0;
        foreach ($this->employees as $employee) {
            $this->total_overtimes += $employee->EarnedOvertimeKes($this->instance->format('Y-m'));
        }
    }

    function incompleteEmployees()
    {

        $employees = EmployeesDetail::where('kra_pin', null)->orWhere('nssf', null)->orWhere('nhif', null)->get();
        $collect = [];
        foreach ($employees as $employee) {
            if ($employee->ActiveContractBetween('01/01/1970', 'now')) {
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
            $nssf += $employee->EarnedSalaryKes($this->instance->format('Y-m')) > 0 ? $calculations->getNssf() : 0;
            $nhif += $calculations->getNhif();
            $ahl += $calculations->getHousingLevy();
        }

        return $earning + $nssf + $ahl;
    }
    function placeholder()
    {
        return view('livewire.placeholders.dashboard');
    }


    public function render()
    {

        $this->instance = Carbon::parse($this->month);
        $this->estimated = $this->estimated_earnings();
        $this->incompleteEmployees = $this->incompleteEmployees();
        $chartModel = $this->loadPayrollGraph();


        return view('livewire.admin.dashboard', [
            'chartModel' => $chartModel,
        ]);
    }
}
