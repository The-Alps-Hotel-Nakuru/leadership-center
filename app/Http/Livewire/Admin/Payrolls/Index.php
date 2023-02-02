<?php

namespace App\Http\Livewire\Admin\Payrolls;

use App\Models\EmployeesDetail;
use App\Models\MonthlySalary;
use App\Models\Payroll;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

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
                        }
                    } else {
                        $salary->basic_salary_kes = 0;
                    }

                    $salary->save();
                    $count++;
                }

                // dd($testarray);
            }

            $this->emit('done', [
                'success' => 'Successfully Generated Payroll for ' . $count . ' employees'
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
        $this->emit('done', [
            'success' => 'Successfully Updated Payroll No. ' . $id
        ]);
    }

    public function delete($id)
    {
        $payroll = Payroll::find($id);
        $payroll->delete();

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
