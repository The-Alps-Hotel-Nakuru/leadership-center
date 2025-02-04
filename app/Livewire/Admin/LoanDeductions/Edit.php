<?php

namespace App\Livewire\Admin\LoanDeductions;

use App\Models\Loan;
use App\Models\LoanDeduction;
use Carbon\Carbon;
use Livewire\Component;

class Edit extends Component
{
    public Loan $loan;
    public $yearmonth;
    public LoanDeduction $loanDeduction;

    protected $rules = [
        'loanDeduction.amount' => 'required',
        'yearmonth' => 'required|date_format:Y-m',
    ];

    public function mount($loan_id, $id)
    {
        $this->loan = Loan::find($loan_id);
        $this->loanDeduction = LoanDeduction::find($id);
        $this->yearmonth = Carbon::parse($this->loanDeduction->year . '-' . $this->loanDeduction->month)->format('Y-m');
    }

    public function save()
    {
        try {
            $this->validate();
            $this->loanDeduction->year = Carbon::parse($this->yearmonth)->format('Y');
            $this->loanDeduction->month = Carbon::parse($this->yearmonth)->format('m');
            $this->loanDeduction->update();
            return redirect()->route('admin.loans.show', [$this->loan->id]);
        } catch (\Exception $e) {
            $this->dispatch('done', error: $e->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.admin.loan-deductions.edit');
    }
}
