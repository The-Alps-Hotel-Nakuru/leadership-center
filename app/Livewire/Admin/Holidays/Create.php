<?php

namespace App\Livewire\Admin\Holidays;

use App\Models\Holiday;
use Carbon\Carbon;
use Livewire\Component;

class Create extends Component
{

    public Holiday $holiday;

    protected $rules = [
        "holiday.name" => "required",
        'holiday.date' => "required|unique:holidays,date"
    ];

    protected $messages = [
        "holiday.name.required" => "This Holiday's Name is Required",
        "holiday.date.required" => "This Holiday's Date is Required",
        "holiday.date.unique" => "You can not create more than one holiday on the same day",
    ];
    protected $listeners = [
        "done" => "render",
    ];


    public function mount()
    {
        $this->holiday = new Holiday();
    }

    public function save()
    {
        $this->validate();
        if ($this->holiday->is_covered) {
            $this->dispatch(
                "done",
                warning: "The Payroll of the month of this date has already been accounted for in a payroll. You may need to refresh Payments"
            );
            return;
        }
        $this->holiday->save();
        $this->dispatch(
            "done",
            success: $this->holiday->name . ' of ' . Carbon::parse($this->holiday->date)->format('jS F, Y') . ' has been saved'
        );
    }
    public function render()
    {
        return view('livewire.admin.holidays.create');
    }
}
