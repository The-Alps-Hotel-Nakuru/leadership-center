<?php

namespace App\Http\Livewire\Admin\Payrolls;

use App\Models\Payroll;
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
        return view('livewire.admin.payrolls.show');
    }
}
