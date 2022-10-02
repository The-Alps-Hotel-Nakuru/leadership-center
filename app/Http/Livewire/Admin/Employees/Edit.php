<?php

namespace App\Http\Livewire\Admin\Employees;

use App\Models\EmployeesDetail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class Edit extends Component
{
    use WithFileUploads;
    public $kra_file, $nssf_file, $nhif_file;
    public $dpt_id;
    public User $employee;
    public EmployeesDetail $detail;

    protected $rules = [
        'employee.first_name' => 'required',
        'employee.last_name' => 'required',
        'employee.email' => 'required|email',
        'detail.designation_id' => 'required',
        'detail.phone_number' => 'required',
        'detail.physical_address' => 'required',
        'detail.marital_status' => 'required',
        'detail.gender' => 'required',
        'detail.children' => 'required',
        'detail.birth_date' => 'required',
        'detail.kra_pin' => 'required',
        'detail.nssf' => 'required',
        'detail.nhif' => 'required',
        'detail.kra_pin_path' => 'nullable',
        'detail.nssf_path' => 'nullable',
        'detail.nhif_path' => 'nullable',
        'detail.handicap' => 'nullable',
        'detail.religion' => 'nullable',
        'kra_file'=>'nullable|mimes:png,jpg,pdf|max:4096',
        'nssf_file'=>'nullable|mimes:png,jpg,pdf|max:4096',
        'nhif_file'=>'nullable|mimes:png,jpg,pdf|max:4096',

    ];


    public function mount($id)
    {
        $this->detail = EmployeesDetail::find($id);
        $this->employee = User::find($this->detail->user_id);
        $this->dpt_id = $this->detail->designation->department_id;
    }


    public function save()
    {
        $this->validate();
        if (isset($this->kra_file)) {
            if (file_exists($this->detail->kra_pin_path)) {
                unlink($this->detail->kra_pin_path);
            }
            $this->kra_file->storeAs('public/'.Str::slug($this->employee->name).'-'.$this->detail->id, 'kra_pin.'.$this->kra_file->extension());
            $this->detail->kra_pin_path = '/storage/'.Str::slug($this->employee->name).'-'.$this->detail->id.'/kra_pin.'.$this->kra_file->extension();
        }
        if (isset($this->nssf_file)) {
            if (file_exists($this->detail->nssf_path)) {
                unlink($this->detail->nssf_path);
            }
            $this->kra_file->storeAs('public/'.Str::slug($this->employee->name).'-'.$this->detail->id, 'nssf.'.$this->nssf_file->extension());
            $this->detail->nssf_path = '/storage/'.Str::slug($this->employee->name).'-'.$this->detail->id.'/nssf.'.$this->nssf_file->extension();
        }
        if (isset($this->nhif_file)) {
            if (file_exists($this->detail->nhif_path)) {
                unlink($this->detail->nhif_path);
            }
            $this->kra_file->storeAs('public/'.Str::slug($this->employee->name).'-'.$this->detail->id, 'nhif.'.$this->nhif_file->extension());
            $this->detail->nhif_path = '/storage/'.Str::slug($this->employee->name).'-'.$this->detail->id.'/nhif.'.$this->nhif_file->extension();
        }
        $this->employee->save();
        $this->detail->save();

        return redirect()->route('admin.employees.index');
    }
    public function render()
    {
        return view('livewire.admin.employees.edit');
    }
}
