<?php

namespace App\Http\Livewire\Admin\LeaveRequests;

use App\Jobs\SendLeaveApprovalEmailJob;
use App\Models\Leave;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Approve extends Component
{

    public Leave $leave;
    public LeaveRequest $leave_request;

    protected $rules = [
        'leave.employees_detail_id' => "required",
        'leave.leave_type_id' => "required",
        'leave.start_date' => "required",
        'leave.end_date' => "required"
    ];
    function mount($id)
    {
        $this->leave_request = LeaveRequest::find($id);

        $this->leave = new Leave();
        $this->leave->employees_detail_id = $this->leave_request->employees_detail_id;
        $this->leave->leave_type_id = $this->leave_request->leave_type_id;
        $this->leave->start_date = $this->leave_request->start_date;
        $this->leave->end_date = $this->leave_request->end_date;
    }

    function save()
    {
        try {
            $this->validate();

            $this->leave->created_by = auth()->user()->id;

            if ($this->leave->employee->onLeaveBetween($this->leave->start_date, $this->leave->end_date)) {
                throw ValidationException::withMessages([
                    "leave.employees_detail_id" => "This Employee is already on Leave during this time"
                ]);
            }

            $this->leave->save();
            $this->leave_request->leaves()->attach($this->leave->id);

            SendLeaveApprovalEmailJob::dispatch($this->leave_request);

            return redirect()->route('admin.leave-requests.index');
        } catch (\Throwable $th) {
            //throw $th;
            $this->emit('done', [
                'warning' => $th->getMessage()
            ]);
        }
    }
    public function render()
    {
        return view('livewire.admin.leave-requests.approve', [
            'leave_types' => LeaveType::all()
        ]);
    }
}
