<?php

namespace App\Http\Livewire\Admin\Payrolls;

use App\Exports\AbsaBankingGuideExport;
use App\Exports\BankingGuideExport;
use App\Exports\PayrollExport;
use App\Models\EmployeeContract;
use App\Models\EmployeesDetail;
use App\Models\Log;
use App\Models\MonthlySalary;
use App\Models\Payroll;
use App\Models\PayrollPayment;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Component
{

    use WithPagination;
    protected $paginationTheme = "bootstrap";
    public $yearmonth;
    public $readyToLoad = false;


    protected $rules = [
        'yearmonth' => 'required'
    ];

    protected $listeners = [
        'done' => 'render'
    ];

    public function mount()
    {
        $this->yearmonth = Carbon::now()->year . '-' . Carbon::now()->month;
    }

    public function loadItems()
    {
        $this->readyToLoad = true;
    }

    function downloadPayrollBreakdown($id)
    {
        return Excel::download(new PayrollExport($id), env('COMPANY_NAME') . "- Payroll for " . Payroll::find($id)->yearmonth . '.xlsx');
        // dd(Payroll::find($id));
    }

    function downloadBankSlip($id)
    {
        switch (env('BANK_NAME')) {
            case 'KCB':
                return Excel::download(new BankingGuideExport($id), env('COMPANY_NAME') . " - KCB Banking Advice for " . Payroll::find($id)->yearmonth . '.xlsx');
            case 'ABSA':
                return Excel::download(new AbsaBankingGuideExport($id), env('COMPANY_NAME') . " - ABSA Banking Advice for " . Payroll::find($id)->yearmonth . '.xlsx');

            default:
                $this->emit('done', [
                    'warning' => "You need to set up a legible bank account"
                ]);
                break;
        }
    }



    public function generate()
    {
        $this->validate();
        $year = Carbon::parse($this->yearmonth)->year;
        $month = Carbon::parse($this->yearmonth)->month;
        if (Payroll::where([['year', '=', $year], ['month', '=', $month]])->exists()) {
            throw ValidationException::withMessages([
                'yearmonth' => 'The Payroll You are trying to generate already Exists'
            ]);
        } else {
            // if (!Carbon::now()->isAfter(Carbon::parse($year . '-' . $month)->lastOfMonth())) {
            //     throw ValidationException::withMessages([
            //         'yearmonth' => 'The Payroll You are trying to generate cannot be generated now. Wait until after ' . Carbon::parse($year . '-' . $month)->lastOfMonth()->format("jS F, Y")
            //     ]);
            // }
            $count = 0;
            $testarray = [];
            $payroll = new Payroll();
            $payroll->year = $year;
            $payroll->month = $month;
            $payroll->save();
            foreach (EmployeesDetail::all() as $employee) {
                $contracts = $employee->ActiveContractsDuring($payroll->year . '-' . $payroll->month);
                if (count($contracts) > 0) {
                    $salary = new MonthlySalary();
                    $salary->payroll_id = $payroll->id;
                    $salary->employees_detail_id = $employee->id;
                    $salary->basic_salary_kes = 0;

                    foreach ($contracts as $contract) {
                        $salary->basic_salary_kes += $contract->EarnedSalaryKes($payroll->year . '-' . $payroll->month);
                        $salary->is_taxable = $contract->is_taxable;
                    }

                    if ($salary->basic_salary_kes <= 0.1) {
                        continue;
                    }



                    $salary->save();
                    $count++;
                }
            }



            // foreach (EmployeeContract::all() as $key => $contract) {
            //     if ($contract->isActiveDuring(Carbon::parse($payroll->year . '-' . $payroll->month)->firstOfMonth(), Carbon::parse($payroll->year . '-' . $payroll->month)->lastOfMonth())) {
            //         $
            //     }
            // }

            $log = new Log();
            $log->user_id = auth()->user()->id;
            $log->model = 'App\Models\Payroll';
            $log->payload = "<strong>" . auth()->user()->name . "</strong> has generated the payroll for  <strong> " . Carbon::parse($payroll->year . '-' . $payroll->month)->format('F, Y') . "</strong> in the system";
            $log->save();

            $this->emit('done', [
                'success' => 'Successfully Generated Payroll for ' . $count . ' employees'
            ]);
        }
    }

    function makePayment($id)
    {
        $payroll = Payroll::find($id);

        if (count($payroll->payments) > 0) {
            $this->emit('done', [
                'warning' => 'Payment already Made'
            ]);
        }
        foreach ($payroll->monthlySalaries as $salary) {
            if (!$salary->employee->bankAccount) {
                $this->emit('done', [
                    'warning' => $salary->employee->user->name . ' has not set a bank account'
                ]);
                # code...
            }
        }
        foreach ($payroll->monthlySalaries as $salary) {

            try {
                $payment = new PayrollPayment();
                $payment->payroll_id = $payroll->id;
                $payment->employees_detail_id = $salary->employee->id;
                $payment->gross_salary = $salary->gross_salary;
                $payment->nssf = $salary->nssf;
                $payment->nhif = $salary->nhif;
                $payment->paye = $salary->paye;
                $payment->nita = $salary->nita;
                $payment->housing_levy = $salary->housing_levy;
                $payment->total_fines = $salary->fines;
                $payment->total_bonuses = $salary->bonuses;
                $payment->total_advances = $salary->advances;
                $payment->total_loans = $salary->loans;
                $payment->total_welfare_contributions = $salary->welfare_contributions;
                $payment->bank_id = $salary->employee->bankAccount->bank_id;
                $payment->account_number = $salary->employee->bankAccount->account_number;
                $payment->save();
                $this->emit('done', [
                    'success' => "Successfully Generated Payment Slips for KCB Banking"
                ]);
            } catch (\Throwable $th) {
                $this->emit('done', [
                    'warning' => $th->getMessage()
                ]);
            }
        }
    }

    public function update($id)
    {
        $payroll = Payroll::find($id);

        if ($payroll->is_paid) {
            $this->emit(
                'done',
                [
                    'warning' => "You can't update a Payroll that's already Paid"
                ]
            );
            return;
        }

        $month = $payroll->month;
        $year = $payroll->year;

        if (count($payroll->payments) > 0) {

            $payroll->payments()->delete();
        }
        $payroll->monthlySalaries()->delete();

        $payroll->delete();
        $payroll = new Payroll();
        $payroll->id = $id;
        $payroll->month = $month;
        $payroll->year = $year;
        $payroll->save();

        foreach (EmployeesDetail::all() as $employee) {
            $contracts = $employee->ActiveContractsDuring($payroll->year . '-' . $payroll->month);
            if (count($contracts) > 0) {
                $salary = new MonthlySalary();
                $salary->payroll_id = $payroll->id;
                $salary->employees_detail_id = $employee->id;
                $salary->basic_salary_kes = 0;

                foreach ($contracts as $contract) {
                    $salary->basic_salary_kes += $contract->EarnedSalaryKes($payroll->year . '-' . $payroll->month);
                    $salary->is_taxable = $contract->is_taxable;
                }

                if ($salary->basic_salary_kes <= 0.1) {
                    continue;
                }

                $salary->save();
            }
        }

        // if (count($payroll->payments) > 0) {

        //     $payroll->payments()->delete();
        // }

        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\Payroll';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has updated the payroll for  <strong> " . Carbon::parse($payroll->year . '-' . $payroll->month)->format('F, Y') . "</strong> in the system";
        $log->save();

        $this->emit('done', [
            'success' => 'Successfully Updated Payroll No. ' . $id
        ]);
    }

    public function delete($id)
    {
        $payroll = Payroll::find($id);
        if (count($payroll->payments) > 0) {
            $this->emit('done', [
                'warning' => 'Payment for this Payroll Has Already been Made'
            ]);

            return;
        }

        if ($payroll->is_paid) {
            $this->emit('done', [
                'warning' => "Payment for this Payroll Has Already been Made"
            ]);
            return;
        }

        $payroll->delete();

        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\Payroll';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has deleted the payroll for  <strong> " . Carbon::parse($payroll->year . '-' . $payroll->month)->format('F, Y') . "</strong> from the system";
        $log->save();


        $this->emit('done', [
            'success' => 'Successfully Deleted Payroll of' . Carbon::parse($payroll->year . '-' . $payroll->month)->format('M, Y')
        ]);
    }




    public function render()
    {
        return view('livewire.admin.payrolls.index', [
            'payrolls' => $this->readyToLoad ? Payroll::orderBy('year', 'DESC')->orderBy('month', 'DESC')->paginate(5) : []
        ]);
    }
}
