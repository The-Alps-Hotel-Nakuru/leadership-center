<?php

namespace App\Http\Livewire\Admin\Employees;

use App\Models\EmployeesDetail;
use Livewire\Component;

class Show extends Component
{
    public EmployeesDetail $employee;

    public function mount($id)
    {
        $this->employee = EmployeesDetail::find($id);
    }
    public function render()
    {
        return view('livewire.admin.employees.show');
    }
}
