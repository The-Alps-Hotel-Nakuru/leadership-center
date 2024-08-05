<?php

namespace App\Http\Livewire\Admin\LoanDeductions;

use App\Models\Loan;
use App\Models\LoanDeduction;
use Livewire\Component;

class Edit extends Component
{
    public Loan $loan;
    public LoanDeduction $loanDeduction;

    public function mount($loan_id, $id)
    {
        $this->loan = Loan::find($loan_id);
        $this->loanDeduction = LoanDeduction::find($id);
    }
    public function render()
    {
        return view('livewire.admin.loan-deductions.edit');
    }
}
