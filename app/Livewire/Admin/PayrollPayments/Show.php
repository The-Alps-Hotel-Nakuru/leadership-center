<?php

namespace App\Livewire\Admin\PayrollPayments;

use App\Models\Payroll;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;
    public Payroll $payroll;

    function mount($id)
    {
        $this->payroll = Payroll::find($id);
    }

    public function render()
    {
        $payments = $this->payroll->payments()->orderBy('gross_salary', 'DESC')->get();
        return view('livewire.admin.payroll-payments.show', [
            'payments' => $payments
        ]);
    }
}
