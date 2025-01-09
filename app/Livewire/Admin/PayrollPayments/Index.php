<?php

namespace App\Livewire\Admin\PayrollPayments;

use App\Models\Payroll;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.admin.payroll-payments.index', [
            'payrolls' => Payroll::all(),
        ]);
    }
}
