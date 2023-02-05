<?php

namespace App\Http\Livewire\Admin\EmployeeContracts;

use App\Models\EmployeeContract;
use App\Models\EmployeesDetail;
use App\Models\Log;
use Carbon\Carbon;
use Livewire\Component;

class Create extends Component
{

    public EmployeeContract $contract;
    public $months;

    protected $rules = [
        'contract.employees_detail_id' => 'required',
        'contract.start_date' => 'required',
        'months' => 'required',
        'contract.employment_type_id' => 'required',
        'contract.salary_kes' => 'required',
    ];

    public function mount()
    {
        $this->contract = new EmployeeContract();
    }


    public function save()
    {
        $this->validate();

        $this->contract->end_date = Carbon::parse($this->contract->start_date)->addMonths($this->months)->toDateString();
        $employee = EmployeesDetail::find($this->contract->employees_detail_id);
        foreach ($employee->contracts as $cont) {
            if ($cont->isActiveDuring($this->contract->start_date, $this->contract->end_date)) {
                $cont->terminateOn($this->contract->start_date);
            }
        }
        $this->contract->save();

        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\EmployeeContract';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has created a new Employee's Contract for <strong> " . $employee->user->name . "</strong> in the system";
        $log->save();

        return redirect()->route('admin.employee_contracts.index');
    }
    public function render()
    {
        return view('livewire.admin.employee-contracts.create');
    }
}
