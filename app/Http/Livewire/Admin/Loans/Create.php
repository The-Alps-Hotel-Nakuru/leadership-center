<?php

namespace App\Http\Livewire\Admin\Loans;

use App\Models\EmployeesDetail;
use App\Models\Loan;
use App\Models\LoanDeduction;
use App\Models\Log;
use Carbon\Carbon;
use Livewire\Component;

class Create extends Component
{
    public $search = "";
    public $selectedEmployee;
    public $repaymentmonths;
    public $yearmonth;
    public Loan $loan;

    protected $rules = [
        'selectedEmployee' => 'required',
        'loan.reason' => 'required',
        'loan.amount' => 'required',
        'loan.transaction' => 'required',
        'yearmonth' => 'required',
        'repaymentmonths' => 'required',
    ];

    function mount()
    {
        $this->loan = new Loan();
    }

    public function selectEmployee($id)
    {
        $this->selectedEmployee = $id;
    }

    function save()
    {
        $this->validate();

        $employee = EmployeesDetail::find($this->selectedEmployee);


        $this->loan->employees_detail_id = $employee->id;

        // if (!($this->loan->employee->netSalary($this->yearmonth) > ($this->loan->amount / $this->repaymentmonths))) {
        //     $max = ($this->loan->employee->netSalary($this->yearmonth) * $this->repaymentmonths) - 0.001;
        //     $this->emit('done', [
        //         'warning' => "This Employee has not earned enough for a Loan this size. The Maximum allowed is KES " . \number_format($max, 2) . " for " . $this->repaymentmonths . " months"
        //     ]);
        //     return;
        // }

        $this->loan->year = Carbon::parse($this->yearmonth)->year;
        $this->loan->month = Carbon::parse($this->yearmonth)->month;
        $this->loan->save();
        $yearmonth = Carbon::parse($this->loan->year . '-' . $this->loan->month);
        $amount = $this->loan->amount / $this->repaymentmonths;
        $left = $this->loan->amount;
        $yearmonth = Carbon::parse($this->loan->year . '-' . $this->loan->month);
        for ($i = 0; $i < $this->repaymentmonths; $i++) {
            $deduction = new LoanDeduction();
            if ($i > 0) {
                $yearmonth = $yearmonth->addMonth();
            }
            $deduction->loan_id = $this->loan->id;
            $deduction->year = $yearmonth->year;
            $deduction->month = $yearmonth->month;
            $deduction->amount = $amount < $left ? $amount : $left;
            $deduction->save();

            $left = $left - $amount;
        }

        $this->emit('done', [
            'success' => 'Successfully Added a Loan Record for ' . $employee->user->name
        ]);

        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\Loan';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has recorded a loan for <strong> " . $employee->user->name . "</strong> in the system";
        $log->save();

        $this->reset([
            'search', 'selectedEmployee'
        ]);
        $this->loan = new Loan();
    }

    public function render()
    {
        $employees = EmployeesDetail::whereHas('user', function ($query) {
            $query->where('first_name', 'like', '%' . $this->search . '%')
                ->orWhere('last_name', 'like', '%' . $this->search . '%');
        })->get();

        return view('livewire.admin.loans.create', [
            'employees' => $employees,
        ]);
    }
}
