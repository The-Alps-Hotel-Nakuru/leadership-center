<?php

namespace App\Http\Livewire\Admin\Loans;

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
            $this->emit('done', [
                'success' => "Loan Deduction successfully Deleted"
            ]);
        }
        $this->emit('done', [
            'warning' => "This Loan has already started the settlement process"
        ]);

    }


    public function render()
    {
        return view('livewire.admin.loans.show');
    }
}
