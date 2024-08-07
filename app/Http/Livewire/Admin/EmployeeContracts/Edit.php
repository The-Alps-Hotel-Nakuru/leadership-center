<?php

namespace App\Http\Livewire\Admin\EmployeeContracts;

use App\Models\EmployeeContract;
use App\Models\EmployeesDetail;
use App\Models\Log;
use Carbon\Carbon;
use Livewire\Component;

class Edit extends Component
{
    public EmployeeContract $contract;
    public $months;

    protected $rules = [
        'contract.employees_detail_id' => 'required',
        'contract.designation_id' => 'required',
        'contract.start_date' => 'required',
        'contract.end_date' => 'required',
        'contract.employment_type_id' => 'required',
        'contract.salary_kes' => 'required',
    ];

    protected $messages = [
        'contract.employees_detail_id.required' => 'Please select the Employee',
        'contract.designation_id.required' => 'Please select the Designation',
        'contract.start_date.required' => 'The Start Date is Required',
        'contract.end_date.required' => 'The End Date is Required',
        'contract.employment_type_id.required' => 'Please select the Employment Type',
        'contract.salary_kes.required' => 'Please enter the Salary (KES)',
    ];

    public function mount($id)
    {
        $this->contract = EmployeeContract::find($id);
        $this->months = Carbon::parse($this->contract->start_date)->diffInMonths($this->contract->end_date);
    }


    public function save()
    {
        $this->validate();
        // $this->contract->end_date = Carbon::parse($this->contract->start_date)->addMonths($this->months)->toDateString();
        $employee = EmployeesDetail::find($this->contract->employees_detail_id);
        foreach ($employee->contracts as $cont) {
            if ($cont->isActiveDuring($this->contract->start_date, $this->contract->end_date) && $cont->id != $this->contract->id) {
                $cont->terminateOn($this->contract->start_date);
            }
        }
        $this->contract->save();

        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\EmployeeContract';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has Edited Employee's Contract No." . $this->contract->id .  "for <strong> " . $this->contract->employee->user->name . "</strong> in the system";
        $log->save();

        return redirect()->route('admin.employee_contracts.index');
    }
    public function render()
    {
        $this->contract->designation_id = $this->contract->employee->designation_id ?? null;
        return view('livewire.admin.employee-contracts.edit');
    }
}
