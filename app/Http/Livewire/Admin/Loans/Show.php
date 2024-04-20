<?php

namespace App\Http\Livewire\Admin\Loans;

use App\Models\Loan;
use Livewire\Component;

class Show extends Component
{
    public Loan $loan;

    public function mount($id)
    {
        $this->loan = Loan::find($id);
    }


    public function render()
    {
        return view('livewire.admin.loans.show');
    }
}
