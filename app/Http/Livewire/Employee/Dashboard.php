<?php

namespace App\Http\Livewire\Employee;

use App\Models\Advance;
use App\Models\EmployeesDetail;
use App\Models\Log;
use Carbon\Carbon;
use Livewire\Component;

class Dashboard extends Component
{
    public $total_fines = 0;
    public $total_loans = 0;
    public $total_overtimes = 0;
    public $total_bonuses = 0;
    public $total_advances = 0;
    public $attendance_percentage = 0;
    public $currentMonth, $currentMonthName, $currentYear, $today, $days, $instance, $employee;
    public $estimated;
    public $month;

    protected $listeners = [
        'done' => 'render'
    ];

    public function mount()
    {
        $this->instance = Carbon::now();
        $this->employee = EmployeesDetail::where('user_id', auth()->user()->id)->first();
        $this->today = $this->instance->format('Y-m-d');
        $this->total_overtimes = $this->totalOvertime();
        $this->attendance_percentage = $this->attendance_percentage();
        $this->month = $this->instance->format('Y-m');
        $this->estimated = $this->employee->EarnedSalaryKes($this->instance->format('Y-m'));
    }

    public function totalOvertime()
    {
        return $this->employee->EarnedOvertimeKes($this->instance->format('Y-m'));
    }

    function attendance_percentage()
    {
        $days = $this->employee->daysWorked($this->instance->format('Y-m'));
        $daysPassed = 0;
        if (Carbon::now()->format('Y-m') == $this->instance->format('Y-m')) {
            $daysPassed = Carbon::now()->format('d');
        } elseif (Carbon::now()->isAfter($this->instance)) {
            $daysPassed = $this->instance->daysInMonth;
        } else {
            $daysPassed = 0;
        }

        return $daysPassed > 0 ? ($days / $daysPassed) * 100 : 0;
    }

    function estimated_earnings()
    {
        return $this->employee->EarnedSalaryKes($this->instance->format('Y-m'));
    }


    public function render()
    {
        $this->instance = Carbon::parse($this->month);

        $this->days = $this->instance->daysInMonth;
        $this->currentMonthName = $this->instance->format('F');
        $this->currentMonth = $this->instance->format('m');
        $this->currentYear = $this->instance->format('Y');
        $this->attendance_percentage = $this->attendance_percentage();

        $this->total_fines = 0;
        foreach ($this->employee->fines as $fine) {
            if ($fine->year == $this->instance->format('Y') && $fine->month == $this->instance->format('m')) {
                $this->total_fines += $fine->amount_kes;
            }
        }
        $this->total_loans = 0;
        foreach ($this->employee->loans as $loan) {
            if ($loan->year == $this->instance->format('Y') && $loan->month == $this->instance->format('m')) {
                $this->total_loans += $loan->amount;
            }
        }
        $this->total_advances = 0;
        foreach ($this->employee->advances as $advance) {
            if ($advance->year == $this->instance->format('Y') && $advance->month == $this->instance->format('m')) {
                $this->total_advances += $advance->amount_kes;
            }
        }
        $this->total_bonuses = 0;
        foreach ($this->employee->bonuses as $bonus) {
            if ($bonus->year == $this->instance->format('Y') && $bonus->month == $this->instance->format('m')) {
                $this->total_bonuses += $bonus->amount_kes;
            }
        }

        $this->estimated = $this->estimated_earnings() + ($this->total_bonuses - $this->total_fines);

        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\EmployeesDetail';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has Logged in";
        $log->save();

        return view('livewire.employee.dashboard');
    }
}
