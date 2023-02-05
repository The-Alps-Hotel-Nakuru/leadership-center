<?php

namespace App\Http\Livewire\Admin\ConferenceHalls;

use App\Models\ConferenceHall;
use App\Models\Log;
use Livewire\Component;

class Edit extends Component
{
    public ConferenceHall $hall;

    protected $rules = [
        'hall.location_id'=>'required',
        'hall.name'=>'required'
    ];


    public function mount($id)
    {
        $this->hall = ConferenceHall::find($id);
    }

    public function save()
    {
        $this->validate();
        $this->hall->save();

        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\ConferenceHall';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has edited Conference Hall <strong>No. " . $this->hall->id . "</strong> in the system";
        $log->save();

        return redirect()->route('admin.conference-halls.index');
    }
    public function render()
    {
        return view('livewire.admin.conference-halls.edit');
    }
}
