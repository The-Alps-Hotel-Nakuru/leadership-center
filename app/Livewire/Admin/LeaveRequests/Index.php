<?php

namespace App\Livewire\Admin\LeaveRequests;

use App\Jobs\SendLeaveRejectionEmailJob;
use App\Models\Leave;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $leave_type_id;
    public $start_date;
    public $end_date;

    function reject($id)
    {
        try {
            $request = LeaveRequest::find($id);

            $request->is_rejected = true;

            $request->update();

            SendLeaveRejectionEmailJob::dispatch($request);

            $this->dispatch(
                'done',
                success: "Successfully Rejected the Leave Request"
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
        return view('livewire.admin.leave-requests.index', [
            'leave_requests' => LeaveRequest::orderBy('id', 'DESC')->paginate(15)
        ]);
    }
}
