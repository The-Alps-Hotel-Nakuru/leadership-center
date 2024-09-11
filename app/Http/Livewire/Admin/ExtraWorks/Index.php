<?php

namespace App\Http\Livewire\Admin\ExtraWorks;

use App\Models\EmployeesDetail;
use App\Models\Shift;
use Carbon\Carbon;
use Livewire\Component;

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
        $initial = $this->instance;
        $this->employees = EmployeesDetail::withCount(
            [
                'extra_works' => function ($query) {
                    $query->where('date', ">=", $this->instance->firstOfMonth()->toDateString())
                        ->where('date', '<=', $this->instance->lastOfMonth()->toDateString());
                }
            ]
        )
            ->orderBy('extra_works_count', 'desc') // Order by the count of attendances
            ->get();
        $this->shifts = Shift::all();
    }
    public function render()
    {
        $this->instance = Carbon::parse($this->month);
        $this->employees = EmployeesDetail::withCount(
            [
                'extra_works' => function ($query) {
                    $query->where('date', ">=", $this->instance->firstOfMonth()->toDateString())
                        ->where('date', '<=', $this->instance->lastOfMonth()->toDateString());
                }
            ]
        )
            ->orderBy('extra_works_count', 'desc') // Order by the count of attendances
            ->get();

        $this->days = $this->instance->daysInMonth;
        $this->currentMonthName = $this->instance->format('F');
        $this->currentMonth = $this->instance->format('m');
        $this->currentYear = $this->instance->format('Y');

        return view('livewire.admin.extra-works.index');
    }
}
