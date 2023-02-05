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
    public $currentMonth, $currentMonthName, $currentYear, $today, $days, $instance, $employees, $shifts;

    public $shift_id;

    protected $listeners = [
        'done' => 'mount'
    ];

    protected $rules = [
        'shift_id' => 'required'
    ];

    public function mount()
    {
        $this->instance = $this->instance ?? Carbon::now();
        $this->currentMonthName = $this->instance->format('F');
        $this->today = $this->today ?? $this->instance->format('d');
        $this->currentMonth = $this->instance->format('m');
        $this->days = $this->instance->daysInMonth;
        $this->currentYear = $this->instance->format('Y');
        $this->employees = EmployeesDetail::all();
        $this->shifts = Shift::all();
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



    public function clockIn($employee_id, $date)
    {
        $this->validate();

        $attendance = new Attendance();
        $attendance->date = Carbon::parse($date)->toDateString();
        $attendance->employees_detail_id = $employee_id;
        $attendance->shift_id = $this->shift_id;
        $attendance->created_by = auth()->user()->id;
        $attendance->save();
        $clock = new AttendanceClock();
        $clock->attendance_id = $attendance->id;
        $clock->clock_in = Carbon::parse($attendance->shift->start_time)->toDateString();
        // $clock->clock_out = Carbon::parse($attendance->shift->end_time)->toDateString();
        $clock->save();

        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\Attendance';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has signed in <strong>" . $attendance->employee->user->name . ' at ' . Carbon::parse($attendance->created_at)->format('h:i A') . "</strong> for Date:" . Carbon::parse($attendance->date)->toDateString() . "from the system";
        $log->save();


        $this->emit('done', [
            'success' => 'Successfully Logged ' . $attendance->employee->user->name . ' in'
        ]);
    }

    public function render()
    {
        return view('livewire.admin.attendances.index');
    }
}
