<?php

namespace App\Http\Livewire\Admin;

use App\Models\Log;
use Livewire\Component;

class Dashboard extends Component
{
    public $logs;


    public function mount()
    {
        $this->logs = Log::orderBy('id', 'DESC')->get();
    }
    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
