<?php

namespace App\Http\Livewire\Admin\Payrolls;

use App\Exports\PayrollExport;
use App\Models\EmployeesDetail;
use App\Models\Log;
use App\Models\MonthlySalary;
use App\Models\Payroll;
use App\Models\PayrollPayment;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Component
{
    public $yearmonth;


    protected $rules = [
        'yearmonth' => 'required'
    ];

    public function mount()
    {
        $this->yearmonth = Carbon::now()->year . '-' . Carbon::now()->month;
    }

    function downloadPayrollBreakdown($id)
    {
        return Excel::download(new PayrollExport($id), "Payroll for " . Payroll::find($id)->yearmonth . '.xlsx');
        // dd(Payroll::find($id));
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
                if ($employee->ActiveContractDuring($payroll->year . '-' . $payroll->month)) {
                    // array_push($testarray, $employee);
                    $salary = new MonthlySalary();
                    $salary->payroll_id = $payroll->id;
                    $salary->employees_detail_id = $employee->id;
                    $contract = $employee->ActiveContractDuring($payroll->year . '-' . $payroll->month);
                    if ($contract) {
                        if ($contract->is_full_time()) {
                            $salary->basic_salary_kes = $contract->salary_kes - $contract->house_allowance;
                            $salary->house_allowance_kes = $contract->house_allowance;
                        } else if ($contract->is_casual()) {
                            $salary->basic_salary_kes = $contract->salary_kes * $employee->daysWorked($year . '-' . $month);
                        }else if ($contract->is_intern()){
                            $salary->basic_salary_kes = $contract->salary_kes;
                        }
                    } else {
                        $salary->basic_salary_kes = 0;
                    }

                    $salary->save();
                    $count++;
                }

                // dd($testarray);
            }

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

    function makePayment($id){
        $payroll = Payroll::find($id);

        foreach ($payroll->monthlySalaries as $key => $salary) {
            $payment = new PayrollPayment();
            $payment->payroll_id = $payroll->id;
            $payment->employees_detail_id = $salary->employee->id;
            $payment->gross_salary = $salary->gross_salary;
            $payment->nssf = $salary->nssf;
            $payment->nhif = $salary->nhif;
            $payment->paye = $salary->paye;
            $payment->housing_levy = $salary->housing_levy;
            $payment->total_fines = $salary->fines;
            $payment->total_bonuses = $salary->bonuses;
            $payment->total_advances = $salary->advances;
            $payment->total_welfare_contributions = $salary->welfare_contributions;
            $payment->save();
            $this->emit('done', [
                'success'=>"Successfully Generated Payment Slips for KCB Banking"
            ]);

        }


    }

    public function update($id)
    {
        $payroll = Payroll::find($id);
        foreach ($payroll->monthlySalaries as $salary) {
            $view = MonthlySalary::find($salary->id);
            $contract = $salary->employee->ActiveContractDuring($payroll->year . '-' . $payroll->month);
            if ($contract) {
                if ($contract->is_full_time()) {
                    $view->basic_salary_kes = $contract->salary_kes - $contract->house_allowance;
                    $view->house_allowance_kes = $contract->house_allowance;
                } else if ($contract->is_casual()) {
                    $view->basic_salary_kes = $contract->salary_kes * $salary->employee->daysWorked($payroll->year . '-' . $payroll->month);
                }
            } else {
                $view->basic_salary_kes = 0;
            }

            $view->save();
        }

        $payroll->save();

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
            'payrolls' => Payroll::all()
        ]);
    }
}
