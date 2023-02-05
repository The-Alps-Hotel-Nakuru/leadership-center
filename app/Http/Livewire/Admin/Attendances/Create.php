<?php

namespace App\Http\Livewire\Admin\Attendances;

use App\Models\Attendance;
use App\Models\EmployeesDetail;
use App\Models\Log;
use Carbon\Carbon;
use Livewire\Component;

class Create extends Component
{
    public Attendance $attendance;

    public $employees;

    protected $listeners = [
        'done' => 'mount'
    ];

    protected $rules = [
        'attendance.employees_detail_id' => 'required',
        'attendance.date' => 'required',
        'attendance.sign_in' => 'required'
    ];

    public function mount()
    {
        $this->employees = EmployeesDetail::all();
        $this->attendance = new Attendance();
        $this->attendance->sign_in = Carbon::now()->toTimeString();
        $this->attendance->date = Carbon::now()->toDateString();
    }

    public function save()
    {
        $this->validate();

        $this->attendance->save();

        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\Attendance';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has signed in <strong>" . $this->attendance->employee->user->name . ' at ' . Carbon::parse($this->attendance->created_at)->format('h:i A') . "</strong> from the system";
        $log->save();

        $this->emit('done', [
            'success' => 'Successfully Signed in ' . $this->attendance->employee->user->name . ' at ' . Carbon::parse($this->attendance->created_at)->format('h:i A'),
        ]);
    }
    public function render()
    {
        return view('livewire.admin.attendances.create');
    }
}
