<?php

namespace App\Http\Livewire\Employee;

use App\Models\EmployeesDetail;
use Carbon\Carbon;
use Livewire\Component;

class Dashboard extends Component
{
    public $total_fines = 0;
    public $total_bonuses = 0;
    public $attendance_percentage = 60;
    public $currentMonth, $currentMonthName, $currentYear, $today, $days, $instance, $employee;
    public $estimated;

    public function mount()
    {
        // $this->month = Carbon::now()->format('Y-m');
        $this->instance = $this->instance ?? Carbon::now();
        $this->employee = EmployeesDetail::where('user_id', auth()->user()->id)->first();
        $this->instance = $this->instance ?? Carbon::now();
        $this->currentMonthName = $this->instance->format('F');
        $this->today = $this->today ?? $this->instance->format('d');
        $this->currentMonth = $this->instance->format('m');
        $this->days = $this->instance->daysInMonth;
        $this->currentYear = $this->instance->format('Y');
    }

    function estimated_earnings()
    {
        $days = auth()->user()->employee->daysWorked($this->instance->format('Y-m'));
        $leaveDays = $this->employee->daysOnLeave($this->instance->format('Y-m'));
        $rate = 0;
        $daysMissed = $this->instance->daysInMonth - $days - $leaveDays;
        $basic_salary_kes = 0;

        if (auth()->user()->employee->ActiveContractDuring($this->instance->format('Y-m'))) {
            if ($this->employee->isCasualBetween($this->instance->firstOfMonth(), $this->instance->lastOfMonth()) || $this->employee->isInternBetween($this->instance->firstOfMonth(), $this->instance->lastOfMonth())) {
                $rate = $this->employee->ActiveContractDuring($this->instance->format('Y-m'))->salary_kes;
            } else {
                $rate = $this->employee->ActiveContractDuring($this->instance->format('Y-m'))->salary_kes / $this->instance->daysInMonth;
            }
        }
        $contract = $this->employee->ActiveContractDuring($this->instance->format('Y-m'));
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
        if ($this->employee && $this->employee->isFullTimeBetween($this->instance->firstOfMonth(), $this->instance->lastOfMonth())) {
            if ($this->employee->isFullTimeBetween($this->instance->firstOfMonth(), $this->instance->lastOfMonth()) && $this->employee->designation->is_penalizable) {
                if ($daysMissed > 6) {
                    $penalty = $this->daily_rate * ($daysMissed - 6);
                }
            } else {
                $penalty = 0;
            }
        }

        return $gross - $penalty;
    }

    public function getPreviousMonth()
    {
        $this->instance = $this->instance->subMonth();
        $this->today += $this->instance->daysInMonth;
        $this->emit('done', [
            'success' => 'Successfully Moved to the Previous Month'
        ]);
    }
    public function getNextMonth()
    {
        $this->today -= $this->instance->daysInMonth;
        $this->instance = $this->instance->addMonth();
        $this->emit('done', [
            'success' => 'Successfully Moved to the Next Month'
        ]);
    }
    public function render()
    {


        $this->total_fines = 0;
        foreach (auth()->user()->employee->fines as $fine) {
            if ($fine->year == $this->instance->format('Y') && $fine->month == $this->instance->format('m')) {
                $this->total_fines += $fine->amount_kes;
            }
        }
        $this->total_bonuses = 0;
        foreach (auth()->user()->employee->bonuses as $bonus) {
            if ($bonus->year == $this->instance->format('Y') && $bonus->month == $this->instance->format('m')) {
                $this->total_bonuses += $bonus->amount_kes;
            }
        }


        return view('livewire.employee.dashboard');
    }
}
