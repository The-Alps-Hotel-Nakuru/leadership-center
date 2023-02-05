<?php

namespace App\Http\Livewire\Admin\Fines;

use App\Models\Fine;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.admin.fines.index',[
            'fines'=>Fine::all()
        ]);
    }
}
