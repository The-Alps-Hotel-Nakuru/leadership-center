<?php

namespace App\Livewire\Admin\LeaveTypes;

use App\Models\LeaveType;
use Livewire\Component;

class Index extends Component
{
    public function delete($id)
    {
        $leaveType = LeaveType::find($id);
        try {

            if ($leaveType->leaves->count() > 0) {
                throw new \Exception("Can't Delete Leave Type that has leaves attached");
            }
            $leaveType->delete();
            $this->dispatch("done", success: "Leave Type Deleted");
        } catch (\Throwable $th) {
            $this->dispatch("done", error: "Something went wrong: " . $th->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.leave-types.index', [
            'leaveTypes' => LeaveType::orderBy('created_at', 'desc')->paginate(10),
        ]);
    }
}
