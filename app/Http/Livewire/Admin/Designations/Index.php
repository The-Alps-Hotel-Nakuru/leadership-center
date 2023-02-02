<?php

namespace App\Http\Livewire\Admin\Designations;

use App\Models\Designation;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.admin.designations.index', [
            'designations'=>Designation::all()
        ]);
    }
}
