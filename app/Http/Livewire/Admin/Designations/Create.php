<?php

namespace App\Http\Livewire\Admin\Designations;

use App\Models\Department;
use App\Models\Designation;
use App\Models\Log;
use Livewire\Component;

class Create extends Component
{
    public Designation $designation;
    public $departments;

    protected $rules = [
        'designation.department_id' => 'required',
        'designation.title' => 'required|unique:designations,title',
        'designation.is_penalizable' => 'required',
        'designation.off_days' => 'nullable'
    ];

    protected $messages = [
        'designation.department_id.required' => "Please select your Department",
        'designation.title.required' => "The Designation Title is Required",
        'designation.title.unique' => "This Designation Already Exists",
        'designation.is_penalizable.required' => "Please Choose if this Designation will attract Attendance Penalties",
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
        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\Designation';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has created a Designation <strong>No. " . $this->designation->id . "</strong> in the system";
        $log->save();

        return redirect()->route('admin.designations.index');
    }
    public function render()
    {
        return view('livewire.admin.designations.create');
    }
}
