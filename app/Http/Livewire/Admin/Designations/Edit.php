<?php

namespace App\Http\Livewire\Admin\Designations;

use App\Models\Department;
use App\Models\Designation;
use App\Models\Log;
use Livewire\Component;

class Edit extends Component
{
    public Designation $designation;
    public $departments;

    protected $rules = [
        'designation.department_id'=>'required',
        'designation.title'=>'required|unique:designations,title'
    ];

    public function mount($id)
    {
        $this->departments = Department::all();
        $this->designation = Designation::find($id);
    }


    public function save()
    {
        $this->validate();
        $this->designation->save();

        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\Designation';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has Edited Designation <strong>No. " . $this->designation->id . "</strong> in the system";
        $log->save();

        return redirect()->route('admin.designations.index');

    }
    public function render()
    {
        return view('livewire.admin.designations.edit');
    }
}
