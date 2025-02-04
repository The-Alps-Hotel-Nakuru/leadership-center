<?php

namespace App\Livewire\Admin\Loans;

use App\Models\Loan;
use App\Models\LoanDeduction;
use Livewire\Component;

class Show extends Component
{
    public Loan $loan;

    protected $listeners = [
        'done' => 'render'
    ];

    public function mount($id)
    {
        $this->loan = Loan::find($id);
    }

    public function delete($id)
    {
        $deduction = LoanDeduction::find($id);
        try {
            if ($deduction->is_settled) {
                throw new \Exception("This Loan Deduction has already been settled. Cannot be deleted");
            }
            $deduction->delete();
            $this->dispatch(
                'done',
                success: "Loan Deduction successfully Deleted"
            );
        } catch (\Exception $e) {
            $this->dispatch(
                'done',
                error: $e->getMessage()
            );
        }
    }


    public function render()
    {
        return view('livewire.admin.loans.show');
    }
}
