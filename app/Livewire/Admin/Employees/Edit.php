<?php

namespace App\Livewire\Admin\Employees;

use App\Models\EmployeeAccount;
use App\Models\EmployeesDetail;
use App\Models\Log;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class Edit extends Component
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
        'employee.email' => 'required|email',
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
        'kra_file' => 'nullable|mimes:png,jpg,pdf|max:4096',
        'nssf_file' => 'nullable|mimes:png,jpg,pdf|max:4096',
        'nhif_file' => 'nullable|mimes:png,jpg,pdf|max:4096',
        'account.bank_id' => 'required',
        'account.account_number' => 'required',

    ];

    protected $messages = [
        'photo.image' => "This file has to be in an image format",
        'employee.email.required' => "The Employees Email is required",
        'employee.email.email' => "The format is not an email format",
        'detail.designation_id.required' => "The Designation is Required",
    ];


    public function mount($id)
    {
        $this->detail = EmployeesDetail::find($id);
        $this->employee = User::find($this->detail->user_id);
        $this->dpt_id = $this->detail->designation->department_id;
        $this->account = EmployeeAccount::where('employees_detail_id', $this->detail->id)->first() ?? new EmployeeAccount();
    }


    public function save()
    {
        $this->validate();
        $this->account->employees_detail_id = $this->detail->id;


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
        $this->detail->save();
        $this->account->save();

        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\EmployeesDetail';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has Edited Details of <strong> " . $this->detail->user->name . "</strong> in the system";
        $log->save();


        return redirect()->route('admin.employees.index');
    }
    public function render()
    {
        return view('livewire.admin.employees.edit');
    }
}
