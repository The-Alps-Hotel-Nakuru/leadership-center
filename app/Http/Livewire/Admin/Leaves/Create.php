<?php

namespace App\Http\Livewire\Admin\Leaves;

use App\Models\EmployeesDetail;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\Log;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Create extends Component
{
    public $search = "";
    public $selectedEmployee;
    public Leave $leave;

    protected $rules = [
        'selectedEmployee' => 'required',
        'leave.leave_type_id' => 'required',
        'leave.start_date' => 'required|date',
        'leave.end_date' => 'required|date',
    ];

    function mount()
    {
        $this->leave = new Leave();
    }

    public function selectEmployee($id)
    {
        $this->selectedEmployee = $id;
    }

    function save()
    {
        $this->validate();

        $employee = EmployeesDetail::find($this->selectedEmployee);

        if (Carbon::parse($this->leave->start_date)->greaterThan($this->leave->end_date)) {
            throw ValidationException::withMessages([
                'leave.start_date' => 'The Start Date is greater than The End Dates',
            ]);
        }
        if (!$employee->isFullTimeBetween($this->leave->start_date, $this->leave->end_date)) {
            throw ValidationException::withMessages([
                'leave.start_date' => 'This Employee is not a full time employee between the dates provided',
            ]);
        }
        if ($employee->onLeaveBetween($this->leave->start_date, $this->leave->end_date)) {
            throw ValidationException::withMessages([
                'leave.start_date' => 'This employee is already on leave between these dates',
            ]);
        }

        $this->leave->employees_detail_id = $employee->id;
        $this->leave->created_by = auth()->user()->id;
        $this->leave->save();

        $this->emit('done', [
            'success' => 'Successfully Created Leave for ' . $employee->user->name
        ]);

        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\EmployeesDetail';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has recorded leave for <strong> " . $employee->user->name . "</strong> in the system";
        $log->save();

        $this->reset([
            'search', 'selectedEmployee'
        ]);
        $this->leave = new Leave();
    }
    public function render()
    {
        $employees = EmployeesDetail::whereHas('user', function ($query) {
            $query->where('first_name', 'like', '%' . $this->search . '%')
                ->orWhere('last_name', 'like', '%' . $this->search . '%');
        })->get();

        return view(
            'livewire.admin.leaves.create',
            [
                'employees' => $employees,
                'leave_types' => LeaveType::all(),
            ]
        );
    }
}
