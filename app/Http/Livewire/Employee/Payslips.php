<?php

namespace App\Http\Livewire\Employee;

use Livewire\Component;

class Payslips extends Component
{
    public function render()
    {
        return view('livewire.employee.payslips', [
            'payslips' => auth()->user()->employee->monthlySalaries
        ]);
    }
}
