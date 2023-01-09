<?php

namespace App\Http\Livewire\Admin\Payrolls;

use App\Models\MonthlySalary;
use App\Models\Payroll;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;

class Show extends Component
{
    public $payroll;

    public function mount($id)
    {
        $this->payroll = Payroll::find($id);
    }

    public function payslip($id)
    {
        $payslip = MonthlySalary::find($id);
        $pdf = Pdf::loadView('doc.payslip', [
            'salary' => $payslip
        ])->setOptions(['defaultFont' => 'sans-serif']);
        $pdf->download();
    }

    public function render()
    {
        return view('livewire.admin.payrolls.show');
    }
}
