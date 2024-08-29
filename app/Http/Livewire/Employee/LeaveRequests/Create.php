<?php

namespace App\Http\Livewire\Employee\LeaveRequests;

use App\Jobs\SendNewLeaveRequestEmailJob;
use App\Mail\LeaveRequest as MailLeaveRequest;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Create extends Component
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

    public function mount()
    {
        $this->leaveRequest = new LeaveRequest();
    }

    public function save()
    {
        $this->validate();
        try {
            $this->leaveRequest->employees_detail_id = auth()->user()->employee->id;
            if (Carbon::parse($this->leaveRequest->end_date)->isBefore($this->leaveRequest->start_date)) {
                throw ValidationException::withMessages([
                    'leaveRequest.start_date' => "End Date cannot come before Start Date"
                ]);
            }
            foreach ($this->leaveRequest->employee->leaveRequests as $key => $leaverequest) {
                if ($leaverequest->is_pending) {
                    throw ValidationException::withMessages([
                        'leaveRequest.reason' => "You still have a pending Leave Request"
                    ]);
                }
            }
            $this->leaveRequest->save();
            // Mail::to(env('COMPANY_EMAIL'))->send(new MailLeaveRequest($this->leaveRequest));
            SendNewLeaveRequestEmailJob::dispatch($this->leaveRequest);

            $this->emit('done', [
                'success' => "Successfully made your Leave Request"
            ]);
            $this->reset();
        } catch (\Throwable $th) {
            //throw $th;
            $this->emit('done', [
                'warning' => $th->getMessage()
            ]);
        }
    }
    public function render()
    {
        return view('livewire.employee.leave-requests.create', [
            'leaveTypes' => LeaveType::all()
        ]);
    }
}
