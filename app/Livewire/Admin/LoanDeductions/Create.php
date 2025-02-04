<?php

namespace App\Livewire\Admin\LoanDeductions;

use App\Models\LoanDeduction;
use Carbon\Carbon;
use Livewire\Component;

class Create extends Component
{

    public $deduction;
    public $loan_id;
    public $yearmonth;

    public function rules()
    {
        return [
            'deduction.amount' => 'required|numeric|min:0',
            'yearmonth' => 'required|date_format:Y-m',
        ];
    }
    public function messages()
    {
        return [
            'deduction.amount.required' => 'Amount is required',
            'yearmonth.required' => 'Month is required',
        ];
    }
    public function mount($loan_id)
    {
        $this->loan_id = $loan_id;
        $this->deduction = new LoanDeduction();
    }

    public function save()
    {
        try {
            $this->validate();
            $this->deduction->loan_id = $this->loan_id;
            if ($this->deduction->loan->unsettled_balance < $this->deduction->amount) {
                throw new \Exception('Deduction amount is greater than the recorded unsettled balance');
            }
            $this->deduction->year = Carbon::parse($this->yearmonth)->format('Y');
            $this->deduction->month = Carbon::parse($this->yearmonth)->format('m');
            $this->deduction->save();
            return redirect()->route('admin.loans.show', [$this->loan_id]);
        } catch (\Exception $e) {
            $this->dispatch('done', error: $e->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.admin.loan-deductions.create');
    }
}
