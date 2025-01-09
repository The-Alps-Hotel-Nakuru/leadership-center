<?php

namespace App\Livewire\Admin\LoanDeductions;

use App\Models\Loan;
use App\Models\LoanDeduction;
use Livewire\Component;

class Edit extends Component
{
    public Loan $loan;
    public LoanDeduction $loanDeduction;

    protected $rules = [
        'loanDeduction.amount' => 'required'
    ];

    public function mount($loan_id, $id)
    {
        $this->loan = Loan::find($loan_id);
        $this->loanDeduction = LoanDeduction::find($id);
    }

    public function save()
    {
        $this->validate();
        $this->loanDeduction->update();

        $this->dispatch(
            'done',
            success: "Successfully updated the Loan Deduction "
        );
    }
    public function render()
    {
        return view('livewire.admin.loan-deductions.edit');
    }
}
