<?php

namespace App\Http\Livewire\Admin\Payrolls;

use App\Models\Log;
use App\Models\MonthlySalary;
use App\Models\Payroll;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Livewire\Component;

class Show extends Component
{
    public $payroll;

    public function mount($id)
    {
        $this->payroll = Payroll::find($id);
    }

    public function render()
    {
        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\Responsibility';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has viewed the payroll of <strong>" . Carbon::parse($this->payroll->year . '-' . $this->payroll->month)->format('F, Y') . "</strong> on " . Carbon::now()->format('l jS F,Y') . " at " . Carbon::now()->format('h:i A') . "  in the system";
        $log->save();

        return view('livewire.admin.payrolls.show');
    }
}
