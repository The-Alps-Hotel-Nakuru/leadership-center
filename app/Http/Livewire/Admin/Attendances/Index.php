<?php

namespace App\Http\Livewire\Admin\Attendances;

use App\Models\Attendance;
use App\Models\EmployeesDetail;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    public $currentMonth, $currentMonthName, $currentYear, $today, $days, $instance, $employees;

    public $sign_out;

    protected $listeners = [
        'done' => 'mount'
    ];

    protected $rules = [
        'sign_out' => 'required'
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
        $this->sign_out = Carbon::now()->toTimeString();
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

    public function signOut($employee_id, $date)
    {

        $this->validate();
        $attendance = Attendance::where('employees_detail_id', $employee_id)->where('date', Carbon::parse($date)->toDateString())->first();

        dd($attendance);
    }

    public function render()
    {

        return view('livewire.admin.attendances.index');
    }
}
