<?php

namespace App\Livewire\Admin\EmployeeContracts;

use App\Models\EmployeeContract;
use Carbon\Carbon;
use Laravel\Jetstream\ConfirmsPasswords;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{

    use WithPagination;
    use ConfirmsPasswords;

    public $type = 'all';

    public $date;

    public $searchEmployee = "";

    protected $paginationTheme = 'bootstrap';

    public function makeInactive($id)
    {
        $contract = EmployeeContract::find($id);

        if (count($contract->payrolls()) > 0) {
            $this->dispatch(
                'done',
                warning: "You Cannot Delete this Contract since it has already been used for Payroll Payments"
            );
            return;
        } else {
            if (Carbon::now()->isBefore($contract->end_date)) {
                $contract->end_date = Carbon::now()->toDateString();
                $contract->save();
            } else {
                $this->dispatch(
                    'done',
                    warning: "The Contract was Already Terminated"
                );
                return;
            }
        }



        $this->dispatch(
            'done',
            success: 'Successfully terminated this Contract'
        );
    }


    public function delete($id)
    {
        $contract = EmployeeContract::find($id);

        if (count($contract->payrolls()) > 0) {
            $this->dispatch(
                'done',
                warning: "You Cannot Delete this Contract since it has already been used for Payroll Payments"
            );
            return;
        } else {
            $contract->delete();
        }

        $this->dispatch(
            'done',
            success: 'Successfully deleted this Contract'
        );
    }

    public function render()
    {
        if ($this->type == 'active') {
            $contracts = EmployeeContract::orderBy('employees_detail_id', 'DESC')->where(function ($employee) {
                $employee->where('end_date', '>=', Carbon::now()->toDateString())->whereHas('user', function ($query) {
                    $query->whereRaw("CONCAT(first_name, ' ', last_name) like ?", ['%' . $this->searchEmployee . '%']);
                });
            });
        } elseif ($this->type == 'inactive') {
            $contracts = EmployeeContract::orderBy('employees_detail_id', 'DESC')->where(function ($employee) {
                $employee->where('end_date', '<', Carbon::now()->toDateString())->whereHas('user', function ($query) {
                    $query->whereRaw("CONCAT(first_name, ' ', last_name) like ?", ['%' . $this->searchEmployee . '%']);
                });
            });
        } else {
            $contracts = EmployeeContract::orderBy('employees_detail_id', 'DESC')->whereHas('user', function ($query) {
                $query->whereRaw("CONCAT(first_name, ' ', last_name) like ?", ['%' . $this->searchEmployee . '%']);
            });
        }
        return view('livewire.admin.employee-contracts.index', [
            'contracts' => $contracts->paginate(10),
        ]);
    }
}
