<?php

namespace App\Http\Livewire\Admin\EmployeeContracts;

use App\Models\EmployeeContract;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{

    use WithPagination;

    public $type = 'all';

    public $searchEmployee = "";

    protected $paginationTheme = 'bootstrap';

    public function makeInactive($id)
    {
        $contract = EmployeeContract::find($id);

        if (Carbon::now()->isBefore($contract->end_date)) {
            $contract->end_date = Carbon::now()->toDateString();
            $contract->save();
        } else {
            $this->emit('done', [
                'warning' => "The Contract was Already Terminated"
            ]);
            return;
        }



        $this->emit('done', [
            'success' => 'Successfully terminated this Contract'
        ]);
    }

    public function delete($id)
    {
        $contract = EmployeeContract::find($id);

        $contract->delete();

        $this->emit('done', [
            'success' => 'Successfully Deleted this Contract from the System'
        ]);
    }


    public function render()
    {
        if ($this->type == 'active') {
            $contracts = EmployeeContract::orderBy('employees_detail_id', 'DESC')->where(function ($employee) {
                $employee->where('end_date', '>=', Carbon::now()->toDateString())->whereHas('user', function ($query) {
                    $query->where('first_name', 'like', '%' . $this->searchEmployee . '%')
                        ->orWhere('last_name', 'like', '%' . $this->searchEmployee . '%');
                });
            });
        } elseif ($this->type == 'inactive') {
            $contracts = EmployeeContract::orderBy('employees_detail_id', 'DESC')->where(function ($employee) {
                $employee->where('end_date', '<', Carbon::now()->toDateString())->whereHas('user', function ($query) {
                    $query->where('first_name', 'like', '%' . $this->searchEmployee . '%')
                        ->orWhere('last_name', 'like', '%' . $this->searchEmployee . '%');
                });
            });
        } else {
            $contracts = EmployeeContract::orderBy('employees_detail_id', 'DESC')->whereHas('user', function ($query) {
                $query->where('first_name', 'like', '%' . $this->searchEmployee . '%')
                    ->orWhere('last_name', 'like', '%' . $this->searchEmployee . '%');
            });
        }
        return view('livewire.admin.employee-contracts.index', [
            'contracts' => $contracts->paginate(10),
        ]);
    }
}
