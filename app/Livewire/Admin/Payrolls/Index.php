<?php

namespace App\Livewire\Admin\Payrolls;

use App\Exports\AbsaBankingGuideExport;
use App\Exports\BankingGuideExport;
use App\Exports\HousingLevyExport;
use App\Exports\NssfExport;
use App\Exports\PayeExport;
use App\Exports\PayrollExport;
use App\Exports\ShifExport;
use App\Exports\StatutoriesExport;
use App\Models\EmployeeContract;
use App\Models\EmployeesDetail;
use App\Models\Log;
use App\Models\MonthlySalary;
use App\Models\Payroll;
use App\Models\PayrollPayment;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Lazy;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

#[Lazy]
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

    public function downloadPayrollBreakdown($id)
    {
        try {
            return Excel::download(new PayrollExport($id), env('COMPANY_NAME') . "- Payroll for " . Payroll::find($id)->yearmonth . '.xlsx');
        } catch (\Throwable $th) {
            //throw $th;
            $this->dispatch(
                'done',
                error: "Something went wrong: " . $th->getMessage()
            );
        }
        // dd(Payroll::find($id));
    }

    public function downloadStatutoriesBreakdown($id)
    {
        try {
            return Excel::download(new StatutoriesExport($id), env('COMPANY_NAME') . "- Statutories for " . Payroll::find($id)->yearmonth . '.xlsx');
        } catch (\Throwable $th) {
            //throw $th;
            $this->dispatch(
                'done',
                error: "Something went wrong: " . $th->getMessage()
            );
        }
    }

    public function downloadBankSlip($id)
    {
        try {
            switch (env('BANK_NAME')) {
                case 'KCB':
                    return Excel::download(new BankingGuideExport($id), env('COMPANY_NAME') . " - KCB Banking Advice for " . Payroll::find($id)->yearmonth . '.xlsx')->deleteFileAfterSend();
                case 'ABSA':
                    return Excel::download(new AbsaBankingGuideExport($id), env('COMPANY_NAME') . " - ABSA Banking Advice for " . Payroll::find($id)->yearmonth . '.xlsx')->deleteFileAfterSend();

                default:
                    $this->dispatch(
                        'done',
                        warning: "You need to set up a legible bank account"
                    );
                    break;
            }
        } catch (\Throwable $th) {
            $this->dispatch(
                'done',
                error: "Something went wrong: " . $th->getMessage()
            );
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
            $count = 0;
            $testarray = [];
            $payroll = new Payroll();
            $payroll->year = $year;
            $payroll->month = $month;
            $payroll->save();
            foreach (EmployeesDetail::all() as $employee) {
                $contracts = $employee->ActiveContractsDuring($payroll->year . '-' . $payroll->month);

                $salary = new MonthlySalary();
                $salary->payroll_id = $payroll->id;
                $salary->employees_detail_id = $employee->id;
                $salary->basic_salary_kes = 0;

                foreach ($contracts as $contract) {
                    $salary->basic_salary_kes += $contract->EarnedSalaryKes($payroll->year . '-' . $payroll->month);
                    $salary->is_taxable = $contract->is_taxable;
                }

                if ($salary->net_pay <= 0.1) {
                    continue;
                }
                $salary->save();
                $count++;
            }
            $log = new Log();
            $log->user_id = auth()->user()->id;
            $log->model = 'App\Models\Payroll';
            $log->payload = "<strong>" . auth()->user()->name . "</strong> has generated the payroll for  <strong> " . Carbon::parse($payroll->year . '-' . $payroll->month)->format('F, Y') . "</strong> in the system";
            $log->save();

            $this->dispatch(
                'done',
                success: 'Successfully Generated Payroll for ' . $count . ' employees'
            );
        }
    }

    public function makePayment($id)
    {
        $payroll = Payroll::find($id);

        if (count($payroll->payments) > 0) {
            $this->dispatch(
                'done',
                warning: 'Payment already Made'
            );
        }
        foreach ($payroll->monthlySalaries as $salary) {
            if (!$salary->employee->bankAccount) {
                $this->dispatch(
                    'done',
                    warning: $salary->employee->user->name . ' has not set a bank account'
                );
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
                $payment->shif = $salary->shif;
                $payment->paye = $salary->paye;
                $payment->nita = $salary->nita;
                $payment->housing_levy = $salary->housing_levy;
                $payment->total_fines = $salary->fines;
                $payment->total_bonuses = $salary->bonuses;
                $payment->total_advances = $salary->advances;
                $payment->total_overtimes = $salary->overtimes;
                $payment->total_loans = $salary->loans;
                $payment->total_welfare_contributions = $salary->welfare_contributions;
                $payment->bank_id = $salary->employee->bankAccount->bank_id;
                $payment->account_number = $salary->employee->bankAccount->account_number;
                $payment->save();
                $this->dispatch(
                    'done',
                    success: "Successfully Generated Payment Slips for KCB Banking"
                );
            } catch (\Throwable $th) {
                $this->dispatch(
                    'done',
                    warning: $th->getMessage()
                );
            }
        }
    }

    public function update($id)
    {
        $payroll = Payroll::find($id);

        if ($payroll->is_paid) {
            $this->dispatch(
                'done',
                warning: "You can't update a Payroll that's already Paid"

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

            $salary = new MonthlySalary();
            $salary->payroll_id = $payroll->id;
            $salary->employees_detail_id = $employee->id;
            $salary->basic_salary_kes = 0;

            foreach ($contracts as $contract) {
                $salary->basic_salary_kes += $contract->EarnedSalaryKes($payroll->year . '-' . $payroll->month);
                $salary->is_taxable = $contract->is_taxable;
            }

            if ($salary->net_pay <= 0.1) {
                continue;
            }

            $salary->save();
        }

        // if (count($payroll->payments) > 0) {

        //     $payroll->payments()->delete();
        // }

        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\Payroll';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has updated the payroll for  <strong> " . Carbon::parse($payroll->year . '-' . $payroll->month)->format('F, Y') . "</strong> in the system";
        $log->save();

        $this->dispatch(
            'done',
            success: 'Successfully Updated Payroll No. ' . $id
        );
    }

    public function delete($id)
    {
        $payroll = Payroll::find($id);
        if (count($payroll->payments) > 0) {
            $this->dispatch(
                'done',
                warning: 'Payment for this Payroll Has Already been Made'
            );

            return;
        }

        if ($payroll->is_paid) {
            $this->dispatch(
                'done',
                warning: "Payment for this Payroll Has Already been Made"
            );
            return;
        }

        $payroll->delete();

        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\Payroll';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has deleted the payroll for  <strong> " . Carbon::parse($payroll->year . '-' . $payroll->month)->format('F, Y') . "</strong> from the system";
        $log->save();


        $this->dispatch(
            'done',
            success: 'Successfully Deleted Payroll of' . Carbon::parse($payroll->year . '-' . $payroll->month)->format('M, Y')
        );
    }


    public function placeholder()
    {
        return view('livewire.placeholders.payroll.index');
    }


    public function render()
    {
        return view('livewire.admin.payrolls.index', [
            'payrolls' => $this->readyToLoad ? Payroll::orderBy('year', 'DESC')->orderBy('month', 'DESC')->paginate(5) : []
        ]);
    }
}
