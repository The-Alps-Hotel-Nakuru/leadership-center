<?php

namespace App\Livewire\Admin\Attendances;

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
        $this->instance = Carbon::parse(session('yearmonth', now()->format('Y-m')));
        $this->month = $this->instance->format('Y-m');
        $this->currentMonthName = $this->instance->format('F');
        $this->today = $this->today ?? $this->instance->format('Y-m-d');
        $this->currentMonth = $this->instance->format('m');
        $this->days = $this->instance->daysInMonth;
        $this->currentYear = $this->instance->format('Y');
        // $this->employees = EmployeesDetail::all();

        $this->employees = EmployeesDetail::withCount(
            [
                'attendances' => function ($query) {
                    $query->where('date', ">=", $this->instance->firstOfMonth()->toDateString())
                        ->where('date', '<=', $this->instance->lastOfMonth()->toDateString());
                }
            ]
        )
            ->orderBy('attendances_count', 'desc') // Order by the count of attendances
            ->get();
        $this->shifts = Shift::all();
    }


    public function render()
    {
        $this->instance = Carbon::parse(session('yearmonth', now()->format('Y-m')));
        $this->employees = EmployeesDetail::withCount(
            [
                'attendances' => function ($query) {
                    $query->where('date', ">=", $this->instance->firstOfMonth()->toDateString())
                        ->where('date', '<=', $this->instance->lastOfMonth()->toDateString());
                }
            ]
        )
            ->where('exit_date', '=', null)
            ->orderBy('attendances_count', 'desc') // Order by the count of attendances
            ->get();

        $this->days = $this->instance->daysInMonth;
        $this->currentMonthName = $this->instance->format('F');
        $this->currentMonth = $this->instance->format('m');
        $this->currentYear = $this->instance->format('Y');

        return view('livewire.admin.attendances.index');
    }
}
