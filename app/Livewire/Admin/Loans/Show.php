<?php

namespace App\Livewire\Admin\Loans;

use App\Models\Loan;
use App\Models\LoanDeduction;
use Livewire\Component;

class Show extends Component
{
    public Loan $loan;

    public function mount($id)
    {
        $this->loan = Loan::find($id);
    }

    public function delete($id)
    {
        $deduction = LoanDeduction::find($id);
        if (!$deduction->loan->hasBeganSettlement()) {
            $deduction->delete();
            $this->dispatch(
                'done',
                success: "Loan Deduction successfully Deleted"
            );
        }
        $this->dispatch(
            'done',
            warning: "This Loan has already started the settlement process"
        );
    }


    public function render()
    {
        return view('livewire.admin.loans.show');
    }
}
