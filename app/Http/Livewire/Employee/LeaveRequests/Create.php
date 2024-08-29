<?php

namespace App\Http\Livewire\Employee\LeaveRequests;

use App\Jobs\SendNewLeaveRequestEmailJob;
use App\Mail\LeaveRequest as MailLeaveRequest;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Create extends Component
{
    public LeaveRequest $leaveRequest;

    protected $rules = [
        'leaveRequest.leave_type_id'=>'required',
        'leaveRequest.start_date'=>'required',
        'leaveRequest.end_date'=>'required',
        'leaveRequest.reason'=>'required',
    ];
    protected $messages = [
        'leaveRequest.leave_type_id.required'=>"This Field is required",
        'leaveRequest.start_date.required'=>"This Field is required",
        'leaveRequest.end_date.required'=>"This Field is required",
        'leaveRequest.reason.required'=>"This Field is required",
    ];

    public function mount(){
        $this->leaveRequest = new LeaveRequest();
    }

    public function save()
    {
        $this->validate();
        try {
            $this->leaveRequest->employees_detail_id = auth()->user()->employee->id;
            $this->leaveRequest->save();
            // Mail::to(env('COMPANY_EMAIL'))->send(new MailLeaveRequest($this->leaveRequest));
            SendNewLeaveRequestEmailJob::dispatch($this->leaveRequest);

            $this->emit('done', [
                'success' => "Successfully made your Leave Request"
            ]);
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
            'leaveTypes'=>LeaveType::all()
        ]);
    }
}
