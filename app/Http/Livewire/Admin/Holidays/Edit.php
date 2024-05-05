<?php

namespace App\Http\Livewire\Admin\Holidays;

use App\Models\Holiday;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Edit extends Component
{
    public Holiday $holiday;

    public function rules()
    {
        return [
            "holiday.name" => ["required", "string"],
            "holiday.date" => ["required", Rule::unique("holidays", 'date')->ignore($this->holiday->id)],
        ];
    }

    protected $messages = [
        "holiday.name.required" => "This Holiday's Name is Required",
        "holiday.date.required" => "This Holiday's Date is Required",
        "holiday.date.unique" => "You can not create more than one holiday on the same day",
    ];
    protected $listeners = [
        "done" => "render",
    ];


    public function mount($id)
    {
        $this->holiday = Holiday::find($id);
    }

    public function save()
    {
        $this->validate();
        $this->holiday->update();
        $this->emit("done", [
            "success" => $this->holiday->name . ' of ' . Carbon::parse($this->holiday->date)->format('jS F, Y') . ' has been saved'
        ]);
    }
    public function render()
    {
        return view('livewire.admin.holidays.edit');
    }
}
