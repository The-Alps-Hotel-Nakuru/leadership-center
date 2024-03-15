<?php

namespace App\Http\Livewire\Admin\Attendances;

use App\Models\Attendance;
use App\Models\AttendanceClock;
use App\Models\EmployeesDetail;
use App\Models\Log;
use App\Models\Shift;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    public $currentMonth, $currentMonthName, $currentYear, $today, $days, $instance, $employees, $shifts, $month;

    public $shift_id;

    protected $listeners = [
        'done' => 'mount'
    ];

    protected $rules = [
        'shift_id' => 'required'
    ];

    public function mount()
    {
        $this->instance = Carbon::now();
        $this->month = $this->instance->format('Y-m');
        $this->currentMonthName = $this->instance->format('F');
        $this->today = $this->today ?? $this->instance->format('Y-m-d');
        $this->currentMonth = $this->instance->format('m');
        $this->days = $this->instance->daysInMonth;
        $this->currentYear = $this->instance->format('Y');
        $this->employees = EmployeesDetail::all();
        $this->shifts = Shift::all();
    }


    public function render()
    {
        $this->instance = Carbon::parse($this->month);

        $this->days = $this->instance->daysInMonth;
        $this->currentMonthName = $this->instance->format('F');
        $this->currentMonth = $this->instance->format('m');
        $this->currentYear = $this->instance->format('Y');

        return view('livewire.admin.attendances.index');
    }
}
