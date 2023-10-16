<?php

namespace App\Http\Livewire\Admin;

use App\Exports\EmployeesDataExport;
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
    public $month;
    protected $paginationTheme = 'bootstrap';
    public $total_fines = 0;
    public $total_bonuses = 0;


    // for Payroll Graph
    public $monthsRange = [];
    public $labels = [];
    public $datasets = [];
    public $data = [];

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
        for ($i = 0; $i < 7; $i++) {
            array_push($range, $this->instance->copy()->subMonthsNoOverflow(6 - $i));
        }
        foreach ($range as $month) {
            array_push($labels, $month->format('F, Y'));
            $payroll = Payroll::where('month', $month->format('m'))->where('year', $month->format('m'));
            if ($payroll->exists()) {
                array_push($data, $payroll->total);
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
        $this->estimated = $this->estimated_earnings();
        $this->loadPayrollGraph();
    }

    function estimated_earnings()
    {
        $earning = 0;
        foreach ($this->employees as $key => $employee) {
            $days = $employee->daysWorked($this->instance->format('Y-m'));
            $leaveDays = $employee->daysOnLeave($this->instance->format('Y-m'));
            $rate = 0;
            $daysMissed = $this->instance->daysInMonth - $days - $leaveDays;
            $basic_salary_kes = 0;

            if ($employee->ActiveContractDuring($this->instance->format('Y-m'))) {
                if ($employee->isCasualBetween($this->instance->firstOfMonth(), $this->instance->lastOfMonth()) || $employee->isInternBetween($this->instance->firstOfMonth(), $this->instance->lastOfMonth())) {
                    $rate = $employee->ActiveContractDuring($this->instance->format('Y-m'))->salary_kes;
                } else {
                    $rate = $employee->ActiveContractDuring($this->instance->format('Y-m'))->salary_kes / $this->instance->daysInMonth;
                }
            }
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
            $penalty = 0;
            if ($employee && $employee->isFullTimeBetween($this->instance->firstOfMonth(), $this->instance->lastOfMonth())) {
                if ($employee->isFullTimeBetween($this->instance->firstOfMonth(), $this->instance->lastOfMonth()) && $employee->designation->is_penalizable) {
                    if ($daysMissed > 6) {
                        $penalty = $rate * ($daysMissed - 6);
                    }
                } else {
                    $penalty = 0;
                }
            }

            $earning += ($gross - $penalty);
        }

        return $earning;
    }

    public function render()
    {
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
        $this->total_bonuses = 0;
        foreach (Bonus::all() as $bonus) {
            if ($bonus->year == $this->instance->format('Y') && $bonus->month == $this->instance->format('m')) {
                $this->total_bonuses += $bonus->amount_kes;
            }
        }

        $this->estimated = $this->estimated_earnings() + ($this->total_bonuses - $this->total_fines);

        return view('livewire.admin.dashboard', [
            'logs' => Log::orderBy('id', 'DESC')->paginate(10)
        ]);
    }
}
