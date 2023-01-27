<?php

namespace App\Http\Livewire\Admin\ConferenceHalls;

use App\Models\ConferenceHall;
use Livewire\Component;

class Create extends Component
{
    public ConferenceHall $hall;

    protected $rules = [
        'hall.location_id'=>'required',
        'hall.name'=>'required|unique:conference_halls,name'
    ];


    public function mount()
    {
        $this->hall = new ConferenceHall();
    }

    public function save()
    {
        $this->validate();
        $this->hall->save();

        return redirect()->route('admin.conference-halls.index');
    }
    public function render()
    {
        return view('livewire.admin.conference-halls.create');
    }
}
