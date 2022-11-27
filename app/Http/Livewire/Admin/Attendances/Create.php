<?php

namespace App\Http\Livewire\Admin\Attendances;

use App\Models\Attendance;
use App\Models\EmployeesDetail;
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
        'attendance.sign_in' => 'required'
    ];

    public function mount()
    {
        $this->employees = EmployeesDetail::all();
        $this->attendance = new Attendance();
        $this->attendance->sign_in = Carbon::now()->toTimeString();
    }

    public function save()
    {
        $this->validate();
        $this->attendance->date = Carbon::now()->toDateString();

        $this->attendance->save();

        $this->emit('done', [
            'success' => 'Successfully Signed in ' . $this->attendance->employee->user->name . ' at ' . Carbon::parse($this->attendance->sign_in)->format('h:i A'),
        ]);
    }
    public function render()
    {
        return view('livewire.admin.attendances.create');
    }
}
