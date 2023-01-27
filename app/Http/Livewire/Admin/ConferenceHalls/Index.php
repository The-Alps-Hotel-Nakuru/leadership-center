<?php

namespace App\Http\Livewire\Admin\ConferenceHalls;

use App\Models\ConferenceHall;
use Livewire\Component;

class Index extends Component
{
    public $halls;

    public function mount()
    {
        $this->halls = ConferenceHall::all();
    }
    public function render()
    {
        return view('livewire.admin.conference-halls.index');
    }
}
