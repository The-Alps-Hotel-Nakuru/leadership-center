<?php

namespace App\Http\Livewire\Admin\Departments;

use App\Models\Department;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.admin.departments.index',[
            'departments'=>Department::all()
        ]);
    }
}
