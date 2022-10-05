<?php

namespace App\Http\Livewire\Admin\EmployeeContracts;

use App\Models\EmployeeContract;
use App\Models\EmployeesDetail;
use Carbon\Carbon;
use Livewire\Component;

class Edit extends Component
{
    public EmployeeContract $contract;
    public $months;

    protected $rules = [
        'contract.employees_detail_id'=>'required',
        'contract.start_date'=>'required',
        'months'=>'required',
        'contract.employment_type_id'=>'required',
        'contract.salary_kes'=>'required',
    ];

    public function mount($id)
    {
        $this->contract = EmployeeContract::find($id);
        $this->months = Carbon::parse($this->contract->start_date)->diffInMonths($this->contract->end_date);
    }


    public function save()
    {
        $this->validate();

        $this->contract->end_date = Carbon::parse($this->contract->start_date)->addMonths($this->months)->toDateString();
        $employee = EmployeesDetail::find($this->contract->employees_detail_id);
        if ($employee->has_active_contract) {
            foreach ($employee->contracts as $cont) {
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
