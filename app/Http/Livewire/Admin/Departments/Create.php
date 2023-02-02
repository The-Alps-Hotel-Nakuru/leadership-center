<?php

namespace App\Http\Livewire\Admin\Departments;

use App\Models\Department;
use Livewire\Component;

class Create extends Component
{
    public Department $department;

    protected $rules = [
        'department.title'=>'required|unique:departments,title'
    ];

    public function mount()
    {
        $this->department = new Department();
    }


    public function save()
    {
        $this->validate();
        $this->department->save();

        return redirect()->route('admin.departments.index');

    }
    public function render()
    {
        return view('livewire.admin.departments.create');
    }
}
