<?php

namespace App\Http\Livewire\Admin\Departments;

use App\Models\Department;
use App\Models\Log;
use Livewire\Component;

class Edit extends Component
{
    public Department $department;

    protected $rules = [
        'department.title'=>'required|unique:departments,title'
    ];

    public function mount($id)
    {
        $this->department = Department::find($id);
    }


    public function save()
    {
        $this->validate();
        $this->department->save();

        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\Department';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has Edited Department <strong>No. " . $this->department->id . "</strong> in the system";
        $log->save();

        return redirect()->route('admin.departments.index');

    }
    public function render()
    {
        return view('livewire.admin.departments.edit');
    }
}
