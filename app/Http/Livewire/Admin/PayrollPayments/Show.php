<?php

namespace App\Http\Livewire\Admin\PayrollPayments;

use App\Models\Payroll;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;
    public Payroll $payroll;

    function mount($id) {
        $this->payroll = Payroll::find($id);
    }

    public function render()
    {
        return view('livewire.admin.payroll-payments.show',[
            'payments'=>collect($this->payroll->payments)->sortByDesc('gross_salary')
        ]);
    }
}
