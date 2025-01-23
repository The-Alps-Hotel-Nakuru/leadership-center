<?php

namespace App\Livewire\Employee\LeaveRequests;

use App\Models\LeaveRequest;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{

    use WithPagination;

    function delete($id)
    {
        $leaveRequest = LeaveRequest::find($id);

        try {
            if (!$leaveRequest->is_pending) {
                throw ValidationException::withMessages([
                    "leaveRequest" => "You Cannot Delete a Request that has already been responded to"
                ]);
            }

            $leaveRequest->delete();

            $this->dispatch(
                'done',
                success: "Successfully Deleted the Leave Request"
            );
        } catch (\Throwable $th) {
            $this->dispatch(
                'done',
                warning: "Something went Wrong: " . $th->getMessage()
            );
            //throw $th;
        }
    }

    public function render()
    {
        return view('livewire.employee.leave-requests.index', [
            'leaveRequests' => auth()->user()->employee->leaveRequests()->orderBy('id', 'desc')->paginate(10)
        ]);
    }
}
