<?php

namespace App\Http\Livewire\Admin\EmployeeContracts;

use App\Models\EmployeeContract;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function makeInactive($id)
    {
        $contract = EmployeeContract::find($id);

        $contract->end_date = Carbon::now()->toDateString();

        $contract->save();

        $this->emit('done',[
            'success'=>'Successfully terminated this Contract'
        ]);
    }

    public function delete($id)
    {
        $contract = EmployeeContract::find($id);

        $contract->delete();

        $this->emit('done',[
            'success'=>'Successfully Deleted this Contract from the System'
        ]);
    }


    public function render()
    {
        return view('livewire.admin.employee-contracts.index', [
            'contracts'=>EmployeeContract::orderBy('id', 'DESC')->paginate(10),
        ]);
    }
}
