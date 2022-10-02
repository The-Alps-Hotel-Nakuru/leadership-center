<?php

namespace App\Http\Livewire\Admin\EmployeeContracts;

use App\Models\EmployeeContract;
use Carbon\Carbon;
use Livewire\Component;

class Index extends Component
{
    public $contracts;


    public function mount()
    {
        $this->contracts = EmployeeContract::orderBy('id', 'DESC')->get();
    }

    public function makeInactive($id)
    {
        $contract = EmployeeContract::find($id);

        $contract->end_date = Carbon::now()->toDateString();

        $contract->save();

        $this->emit('done',[
            'success'=>'Successfully terminated this Contract'
        ]);
    }


    public function render()
    {
        return view('livewire.admin.employee-contracts.index');
    }
}
