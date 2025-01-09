<?php

namespace App\Livewire\Admin\LoanDeductions;

use App\Models\Loan;
use Livewire\Component;

class Create extends Component
{

    public Loan $loan;
    public function mount($loan_id)
    {
        $this->loan = Loan::find($loan_id);
    }
    public function render()
    {
        return view('livewire.admin.loan-deductions.create');
    }
}
