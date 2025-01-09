<?php

namespace App\Livewire\Employee;

use App\Models\EmployeesDetail;
use App\Services\P9FormGeneratorService;
use Barryvdh\DomPDF\Facade\Pdf;
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
        $pdf = Pdf::setPaper('a4', 'landscape')->setOptions(['defaultFont' => 'sans-serif', 'isRemoteEnabled' => true, 'isHTML5ParserEnabled' => false, 'debugPng' => true]);
        $pdf->loadView('doc.p9', ["p9Data" => $p9Data]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, $p9Data['employee_main_name'] . ' ' . $p9Data['employee_other_names'] . '-P9Form-' . $p9Data['year'] . '.pdf');
    }
    public function render()
    {
        return view('livewire.employee.p9-forms');
    }
}
