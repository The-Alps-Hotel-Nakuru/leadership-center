<?php

namespace App\Http\Livewire\Employee\LeaveRequests;

use App\Models\LeaveRequest;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{

    use WithPagination;

    public function render()
    {
        return view('livewire.employee.leave-requests.index', [
            'leaveRequests'=>auth()->user()->employee->leaveRequests()->orderBy('id', 'desc')->paginate(10)
        ]);
    }
}
