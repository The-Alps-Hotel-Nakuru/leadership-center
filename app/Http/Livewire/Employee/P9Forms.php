<?php

namespace App\Http\Livewire\Employee;

use App\Models\EmployeesDetail;
use App\Services\P9FormGeneratorService;
use Livewire\Component;

class P9Forms extends Component
{
    public $year;
    protected $rules = [
        "year" => "required"
    ];
    protected $messages = [
        "year.required" => "The Year is Required",
    ];
    public $p9Data = [];
    public function generateP9Form(P9FormGeneratorService $p9FormGenerator)
    {
        $this->validate();
        $employee = EmployeesDetail::find(auth()->user()->employee->id);
        if ($employee) {
            $this->p9Data = $p9FormGenerator->generate($employee, $this->year);
        } else {
            $this->emit('done', [
                'warning' => "Employee Not Found"
            ]);
        }
    }

    public function downloadP9Form($p9Data)
    {

        return redirect()->route(
            'doc.p9',
            $p9Data
        );
    }
    public function render()
    {
        return view('livewire.employee.p9-forms');
    }
}
