<?php

namespace App\Http\Livewire\Admin\Employees;

use App\Jobs\SendWelcomeEmailJob;
use App\Models\EmployeesDetail;
use App\Models\EmployeeAccount;
use App\Models\Log;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class Create extends Component
{
    use WithFileUploads;
    public $kra_file, $nssf_file, $nhif_file;
    public $photo;
    public $dpt_id;
    public User $employee;
    public EmployeesDetail $detail;
    public EmployeeAccount $account;

    protected $rules = [
        'photo' => 'nullable|image|max:2048',
        'employee.first_name' => 'required',
        'employee.last_name' => 'required',
        'employee.email' => 'required|email|unique:users,email',
        'detail.designation_id' => 'required',
        'detail.phone_number' => 'required',
        'detail.national_id' => 'required',
        'detail.physical_address' => 'nullable',
        'detail.marital_status' => 'required',
        'detail.gender' => 'required',
        'detail.birth_date' => 'required',
        'detail.kra_pin' => 'nullable',
        'detail.nssf' => 'nullable',
        'detail.nhif' => 'nullable',
        'detail.kra_pin_path' => 'nullable',
        'detail.nssf_path' => 'nullable',
        'detail.nhif_path' => 'nullable',
        'detail.handicap' => 'nullable',
        'detail.religion' => 'nullable',
        'kra_file' => 'nullable|mimes:jpg,pdf|max:4096',
        'nssf_file' => 'nullable|mimes:jpg,pdf|max:4096',
        'nhif_file' => 'nullable|mimes:jpg,pdf|max:4096',
        'account.bank_id' => 'required',
        'account.account_number' => 'required',
    ];


    public function mount()
    {
        $this->employee = new User();
        $this->detail = new EmployeesDetail();
        $this->account = new EmployeeAccount();
    }


    public function save()
    {
        $this->validate();
        $this->employee->role_id = 3;
        $password = Str::random(8);
        $this->employee->password = Hash::make($password);


        if (isset($this->photo)) {
            $this->employee->updateProfilePhoto($this->photo);
        }

        if (isset($this->kra_file)) {
            $this->kra_file->storeAs('public/' . Str::slug($this->employee->name) . '-' . $this->detail->id, 'kra_pin.' . $this->kra_file->extension());
            $this->detail->kra_pin_path = '/storage/' . Str::slug($this->employee->name) . '-' . $this->detail->id . '/kra_pin.' . $this->kra_file->extension();
        }
        if (isset($this->nssf_file)) {
            $this->kra_file->storeAs('public/' . Str::slug($this->employee->name) . '-' . $this->detail->id, 'nssf.' . $this->nssf_file->extension());
            $this->detail->nssf_path = '/storage/' . Str::slug($this->employee->name) . '-' . $this->detail->id . '/nssf.' . $this->nssf_file->extension();
        }
        if (isset($this->nhif_file)) {
            $this->kra_file->storeAs('public/' . Str::slug($this->employee->name) . '-' . $this->detail->id, 'nhif.' . $this->nhif_file->extension());
            $this->detail->nhif_path = '/storage/' . Str::slug($this->employee->name) . '-' . $this->detail->id . '/nhif.' . $this->nhif_file->extension();
        }

        $this->employee->save();
        $this->detail->user_id = $this->employee->id;
        $this->detail->save();
        $this->account->save();
        SendWelcomeEmailJob::dispatch($this->employee, $this->detail, $password);

        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\EmployeesDetail';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has created a new Employee named <strong> " . $this->detail->user->name . "</strong> in the system";
        $log->save();

        return redirect()->route('admin.employees.index');
    }
    public function render()
    {
        return view('livewire.admin.employees.create');
    }
}
