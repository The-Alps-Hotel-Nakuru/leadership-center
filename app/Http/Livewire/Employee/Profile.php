<?php

namespace App\Http\Livewire\Employee;

use App\Models\EmployeeAccount;
use App\Models\EmployeesDetail;
use App\Models\Log;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class Profile extends Component
{
    public EmployeesDetail $employee;
    public User $user;
    public EmployeeAccount $account;

    protected $listeners = [
        'done' => 'render'
    ];

    protected $rules = [
        'user.first_name' => 'required',
        'user.last_name' => 'required',
        'user.email' => 'required',
        'employee.national_id' => 'required',
        'employee.phone_number' => 'required',
        'employee.physical_address' => 'nullable',
        'employee.gender' => 'required',
        'employee.kra_pin' => 'nullable',
        'employee.nssf' => 'nullable',
        'employee.nhif' => 'nullable',
        'employee.handicap' => 'nullable',
        'employee.religion' => 'nullable',
        'employee.birth_date' => 'required',
        'account.bank_id' => 'required',
        'account.account_number' => 'required',

    ];

    function mount()
    {
        $this->user = User::find(auth()->user()->id);
        $this->employee = EmployeesDetail::where('user_id', $this->user->id)->first();
        $this->account = EmployeeAccount::where('employees_detail_id', $this->employee->id)->first() ?? new EmployeeAccount();
    }

    function saveBasicDetails()
    {
        $this->validate([
            'user.first_name' => 'required',
            'user.last_name' => 'required',
            'user.email' => 'required',
            'employee.birth_date' => 'required',
            'employee.national_id' => 'required',
            'employee.phone_number' => 'required',
            'employee.gender' => 'required',
        ]);

        $this->user->update();
        $this->employee->update();

        $this->emit('done', [
            'success' => 'Successfully Saved Your Details'
        ]);

        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\EmployeesDetail';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has edited their Basic Details at " . Carbon::parse($this->attendance->created_at)->format('h:i A') . " in the system";
        $log->save();
    }

    function saveMoreDetails()
    {
        $this->validate([
            'employee.kra_pin' => 'required',
            'employee.nssf' => 'required',
            'employee.nhif' => 'required',
        ]);

        $this->user->update();
        $this->employee->update();

        $this->emit('done', [
            'success' => 'Successfully Saved Your Details'
        ]);

        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\EmployeesDetail';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has edited their Govt. Details at " . Carbon::parse($this->attendance->created_at)->format('h:i A') . " in the system";
        $log->save();
    }
    function saveAccountDetails()
    {
        $this->validate([
            'account.bank_id' => 'required',
            'account.account_number' => 'required',
        ]);
        if (!$this->account->employees_detail_id) {
            $this->account->employees_detail_id = auth()->user()->employee->id;
        }
        $this->account->save();

        $this->emit('done', [
            'success' => 'Successfully Saved Your Account Details'
        ]);

        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\EmployeeAccount';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has edited their Payment Details at " . Carbon::parse($this->attendance->created_at)->format('h:i A') . " in the system";
        $log->save();
    }

    public function render()
    {
        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\EmployeesDetail';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> is viewing their profile";
        $log->save();
        return view('livewire.employee.profile');
    }
}
