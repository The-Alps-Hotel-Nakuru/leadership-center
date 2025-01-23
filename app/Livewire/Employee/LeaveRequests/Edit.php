<?php

namespace App\Livewire\Employee\LeaveRequests;

use App\Jobs\SendEditedLeaveRequestEmailJob;
use App\Mail\LeaveRequest as MailLeaveRequest;
use App\Mail\LeaveRequestEdited;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Edit extends Component
{
    public LeaveRequest $leaveRequest;

    protected $rules = [
        'leaveRequest.leave_type_id' => 'required',
        'leaveRequest.start_date' => 'required',
        'leaveRequest.end_date' => 'required',
        'leaveRequest.reason' => 'required',
    ];
    protected $messages = [
        'leaveRequest.leave_type_id.required' => "This Field is required",
        'leaveRequest.start_date.required' => "This Field is required",
        'leaveRequest.end_date.required' => "This Field is required",
        'leaveRequest.reason.required' => "This Field is required",
    ];

    public function mount($id)
    {
        $this->leaveRequest = LeaveRequest::find($id);
    }

    public function save()
    {
        $this->validate();
        try {
            $this->leaveRequest->employees_detail_id = auth()->user()->employee->id;
            $this->leaveRequest->update();
            // Mail::to(env('COMPANY_EMAIL'))->send(new LeaveRequestEdited($this->leaveRequest));
            SendEditedLeaveRequestEmailJob::dispatch($this->leaveRequest);

            $this->dispatch(
                'done',
                success: "Successfully made your Leave Request"
            );
        } catch (\Throwable $th) {
            //throw $th;
            $this->dispatch(
                'done',
                warning: $th->getMessage()
            );
        }
    }
    public function render()
    {
        return view('livewire.employee.leave-requests.edit', [
            'leaveTypes' => LeaveType::all()
        ]);
    }
}
