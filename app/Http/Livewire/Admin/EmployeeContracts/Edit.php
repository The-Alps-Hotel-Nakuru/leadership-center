<?php

namespace App\Http\Livewire\Admin\EmployeeContracts;

use App\Models\EmployeeContract;
use App\Models\EmployeesDetail;
use Livewire\Component;

class Edit extends Component
{
    public EmployeeContract $contract;

    protected $rules = [
        'contract.employees_detail_id'=>'required',
        'contract.start_date'=>'required',
        'contract.end_date'=>'required',
        'contract.employment_type_id'=>'required',
        'contract.salary_kes'=>'required',
    ];

    public function mount($id)
    {
        $this->contract = EmployeeContract::find($id);
    }


    public function save()
    {
        $this->validate();

        if (EmployeesDetail::find($this->contract->employees_detail_id)->has_active_contract) {
            foreach ($this->contract->employee->contracts as $cont) {
                $cont->terminate();
            }
        }
        $this->contract->save();

        return redirect()->route('admin.employee_contracts.index');
    }
    public function render()
    {
        return view('livewire.admin.employee-contracts.edit');
    }
}
