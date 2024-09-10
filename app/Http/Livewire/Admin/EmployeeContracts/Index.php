<?php

namespace App\Http\Livewire\Admin\EmployeeContracts;

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
            $this->emit('done', [
                'warning' => "You Cannot Delete this Contract since it has already been used for Payroll Payments"
            ]);
            return;
        } else {
            if (Carbon::now()->isBefore($contract->end_date)) {
                $contract->end_date = Carbon::now()->toDateString();
                $contract->save();
            } else {
                $this->emit('done', [
                    'warning' => "The Contract was Already Terminated"
                ]);
                return;
            }
        }



        $this->emit('done', [
            'success' => 'Successfully terminated this Contract'
        ]);
    }

    // public function makeAllInactive()
    // {
    //     $this->validate([
    //         'date' => 'date'
    //     ]);

    //     $contracts = EmployeeContract::all();

    //     foreach ($contracts as $key => $contract) {
    //         if (Carbon::parse($this->date)->isBefore($contract->end_date)) {
    //             $contract->end_date = Carbon::parse($this->date)->toDateString();
    //             $contract->save();
    //         } else {
    //             continue;
    //         }
    //     }

    //     $this->emit('done', [
    //         'success' => 'All active contacts are now inactive'
    //     ]);
    // }

    public function delete($id)
    {
        $contract = EmployeeContract::find($id);

        if (count($contract->payrolls()) > 0) {
            $this->emit('done', [
                'warning' => "You Cannot Delete this Contract since it has already been used for Payroll Payments"
            ]);
            return;
        } else {

            $contract->delete();

            $this->emit('done', [
                'success' => 'Successfully Deleted this Contract from the System'
            ]);
        }
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
