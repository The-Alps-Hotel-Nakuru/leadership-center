<?php

namespace App\Http\Livewire\Employee;

use App\Models\Log;
use Livewire\Component;

class Payslips extends Component
{
    public function render()
    {
        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\EmployeesDetail';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has gone to the payslips page";
        $log->save();
        // return view('livewire.employee.payslips', [
        //     'payslips' => auth()->user()->employee->monthlySalaries()->with('payroll')->get()
        // ]);
        return view('livewire.employee.payslips', [
            'payslips' => auth()->user()->employee->monthlySalaries()
                ->with('payroll')
                ->join('payrolls', 'monthly_salaries.payroll_id', '=', 'payrolls.id') // Joining payroll table
                ->orderBy('payrolls.year', 'desc') // Order by year in descending order
                ->orderBy('payrolls.month', 'desc') // Order by month in descending order
                ->get()
        ]);
    }
}
