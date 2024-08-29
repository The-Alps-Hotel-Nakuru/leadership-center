<?php

namespace App\Http\Livewire\Employee;

use App\Models\EmployeeAccount;
use App\Models\EmployeesDetail;
use App\Models\Log;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class Profile extends Component
{
    use WithFileUploads;
    public EmployeesDetail $employee;
    public User $user;
    public EmployeeAccount $account;
    public $profile_photo;

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
        'profile_photo' => 'required'

    ];

    function mount()
    {
        $this->user = User::find(auth()->user()->id);
        $this->employee = EmployeesDetail::where('user_id', $this->user->id)->first();
        $this->account = EmployeeAccount::where('employees_detail_id', $this->employee->id)->first() ?? new EmployeeAccount();
    }

    function saveProfilePhoto()
    {
        $this->validate([
            'profile_photo' => 'required|image|max:5120'
        ]);

        $fileName = Str::slug($this->user->name) . '-profile_photo.' . $this->profile_photo->extension();

        $this->profile_photo->storeAs('employees/' . Str::slug($this->user->name) . '/profile_photos', $fileName, 'public');

        $this->user->profile_photo_path = 'employees/' . Str::slug($this->user->name) . '/profile_photos/' . $fileName;
        $this->user->update();

        $this->emit('done', [
            'success'=>'Successfully Saved your Profile Photo'
        ]);
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

        // Fetch the current details from the database
        $existingUser = User::find($this->user->id);
        $existingEmployee = EmployeesDetail::find($this->employee->id);

        // Prepare the log message with the old and new values
        $logMessage = "<strong>" . auth()->user()->name . "</strong> has edited their Basic Details at "
        . Carbon::now()->format('h:i A') . " in the system.";

        if ($existingUser) {
            if ($existingUser->first_name != $this->user->first_name) {
                $logMessage .= " First Name changed from <strong>" . $existingUser->first_name
                    . "</strong> to <strong>" . $this->user->first_name . "</strong>.";
            }
            if ($existingUser->last_name != $this->user->last_name) {
                $logMessage .= " Last Name changed from <strong>" . $existingUser->last_name
                    . "</strong> to <strong>" . $this->user->last_name . "</strong>.";
            }
            if ($existingUser->email != $this->user->email) {
                $logMessage .= " Email changed from <strong>" . $existingUser->email
                    . "</strong> to <strong>" . $this->user->email . "</strong>.";
            }
        }

        if ($existingEmployee) {
            if ($existingEmployee->birth_date != $this->employee->birth_date) {
                $logMessage .= " Birth Date changed from <strong>" . $existingEmployee->birth_date
                    . "</strong> to <strong>" . $this->employee->birth_date . "</strong>.";
            }
            if ($existingEmployee->national_id != $this->employee->national_id) {
                $logMessage .= " National ID changed from <strong>" . $existingEmployee->national_id
                    . "</strong> to <strong>" . $this->employee->national_id . "</strong>.";
            }
            if ($existingEmployee->phone_number != $this->employee->phone_number) {
                $logMessage .= " Phone Number changed from <strong>" . $existingEmployee->phone_number
                    . "</strong> to <strong>" . $this->employee->phone_number . "</strong>.";
            }
            if ($existingEmployee->gender != $this->employee->gender) {
                $logMessage .= " Gender changed from <strong>" . $existingEmployee->gender
                    . "</strong> to <strong>" . $this->employee->gender . "</strong>.";
            }
        }

        // Update user and employee details
        $this->user->update();
        $this->employee->update();

        // Emit success message
        $this->emit('done', [
            'success' => 'Successfully Saved Your Details'
        ]);

        // Save the log entry
        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\EmployeesDetail';
        $log->payload = $logMessage;
        $log->save();
    }

    function saveMoreDetails()
    {
        $this->validate([
            'employee.kra_pin' => 'required',
            'employee.nssf' => 'required',
            'employee.nhif' => 'required',
        ]);

        // Fetch the current details from the database
        $existingDetails = EmployeesDetail::find($this->employee->id);

        // Prepare the log message with the old and new values
        $logMessage = "<strong>" . auth()->user()->name . "</strong> has edited their Govt. Details at "
        . Carbon::now()->format('h:i A') . " in the system.";

        if ($existingDetails) {
            if ($existingDetails->kra_pin != $this->employee->kra_pin) {
                $logMessage .= " KRA PIN changed from <strong>" . $existingDetails->kra_pin
                    . "</strong> to <strong>" . $this->employee->kra_pin . "</strong>.";
            }
            if ($existingDetails->nssf != $this->employee->nssf) {
                $logMessage .= " NSSF changed from <strong>" . $existingDetails->nssf
                    . "</strong> to <strong>" . $this->employee->nssf . "</strong>.";
            }
            if ($existingDetails->nhif != $this->employee->nhif) {
                $logMessage .= " NHIF changed from <strong>" . $existingDetails->nhif
                    . "</strong> to <strong>" . $this->employee->nhif . "</strong>.";
            }
        } else {
            $logMessage .= " Initial details set as KRA PIN: <strong>" . $this->employee->kra_pin
                . "</strong>, NSSF: <strong>" . $this->employee->nssf . "</strong>, NHIF: <strong>"
                . $this->employee->nhif . "</strong>.";
        }

        // Update user and employee details
        $this->user->update();
        $this->employee->update();

        // Emit success message
        $this->emit('done', [
            'success' => 'Successfully Saved Your Details'
        ]);

        // Save the log entry
        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\EmployeesDetail';
        $log->payload = $logMessage;
        $log->save();
    }
    function saveAccountDetails()
    {
        $this->validate([
            'account.bank_id' => 'required',
            'account.account_number' => 'required',
        ]);
        $existingAccount = $this->account->exists ? EmployeeAccount::find($this->account->id) : null;

        if (!$this->account->employees_detail_id) {
            $this->account->employees_detail_id = auth()->user()->employee->id;
        }

        $logMessage = "<strong>" . auth()->user()->name . "</strong> has edited their Payment Details at "
        . Carbon::now()->format('h:i A') . " in the system.";

        if ($existingAccount) {
            if ($existingAccount->bank_id != $this->account->bank_id) {
                $logMessage .= " Bank changed from <strong>" . $existingAccount->bank->name
                    . "</strong> to <strong>" . $this->account->bank->name . "</strong>.";
            }
            if ($existingAccount->account_number != $this->account->account_number) {
                $logMessage .= " Account Number changed from <strong>" . $existingAccount->account_number
                    . "</strong> to <strong>" . $this->account->account_number . "</strong>.";
            }
        } else {
            $logMessage .= " Initial details set as Bank: <strong>" . $this->account->bank->name
                . "</strong>, Account Number: <strong>" . $this->account->account_number . "</strong>.";
        }
        $this->account->save();

        $this->emit('done', [
            'success' => 'Successfully Saved Your Account Details'
        ]);

        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\EmployeeAccount';
        $log->payload = $logMessage;
        $log->save();
    }

    public function render()
    {
        return view('livewire.employee.profile');
    }
}
