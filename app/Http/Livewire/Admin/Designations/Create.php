<?php

namespace App\Http\Livewire\Admin\Designations;

use App\Models\Department;
use App\Models\Designation;
use Livewire\Component;

class Create extends Component
{
    public Designation $designation;
    public $departments;

    protected $rules = [
        'designation.department_id'=>'required',
        'designation.title'=>'required|unique:designations,title'
    ];

    public function mount()
    {
        $this->departments = Department::all();
        $this->designation = new Designation();
    }


    public function save()
    {
        $this->validate();
        $this->designation->save();

        return redirect()->route('admin.designations.index');

    }
    public function render()
    {
        return view('livewire.admin.designations.create');
    }
}
