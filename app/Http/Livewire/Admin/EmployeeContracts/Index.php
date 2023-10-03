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

    protected $paginationTheme = 'bootstrap';

    public function makeInactive($id)
    {
        $contract = EmployeeContract::find($id);

        $contract->end_date = Carbon::now()->toDateString();

        $contract->save();

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
                $employee->where('end_date', '>=', Carbon::now()->toDateString());
            });
        } elseif ($this->type == 'inactive') {
            $contracts = EmployeeContract::orderBy('employees_detail_id', 'DESC')->where(function ($employee) {
                $employee->where('end_date', '<', Carbon::now()->toDateString());
            });
        } else {
            $contracts = EmployeeContract::orderBy('employees_detail_id', 'DESC');
        }
        return view('livewire.admin.employee-contracts.index', [
            'contracts' => $contracts->paginate(10),
        ]);
    }
}
