<?php

namespace App\Livewire\Admin\Leaves;

use App\Models\EmployeesDetail;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\Log;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Edit extends Component
{
    public Leave $leave;

    protected $rules = [
        'leave.leave_type_id' => 'required',
        'leave.start_date' => 'required|date',
        'leave.end_date' => 'required|date',
    ];

    function mount($id)
    {
        $this->leave = Leave::find($id);
    }


    function save()
    {
        $this->validate();

        $employee = $this->leave->employee;

        if (Carbon::parse($this->leave->start_date)->greaterThan($this->leave->end_date)) {
            throw ValidationException::withMessages([
                'leave.start_date' => 'The Start Date is greater than The End Dates',
            ]);
        }
        if (!$employee->ActiveContractBetween($this->leave->start_date, $this->leave->end_date)->employment_type->is_penalizable) {
            throw ValidationException::withMessages([
                'leave.start_date' => 'This Employee is not legible to go on leave between the dates provided',
            ]);
        }
        $this->leave->employees_detail_id = $employee->id;
        $this->leave->update();

        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\EmployeesDetail';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has edited leave for <strong> " . $employee->user->name . "</strong> in the system";
        $log->save();

        return redirect()->route('admin.leaves.index');
    }
    public function render()
    {
        return view(
            'livewire.admin.leaves.edit',
            [
                'leave_types' => LeaveType::all(),
            ]
        );
    }
}
