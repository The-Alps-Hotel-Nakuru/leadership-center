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
        'contract.start_date' => 'required',
        'contract.end_date' => 'required',
        // 'months' => 'required',
        'contract.employment_type_id' => 'required',
        'contract.salary_kes' => 'required',
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
        return view('livewire.admin.employee-contracts.edit');
    }
}
