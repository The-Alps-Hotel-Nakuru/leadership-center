<?php

namespace App\Models;

use App\Services\PaymentsCalculationsService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MonthlySalary extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $appends = [
        'gross_salary',
        'paye',
        'nhif',
        'nssf',
        'nita',
        'total_deductions',
        'total_relief',
        'daily_rate',
        'days_missed',

    ];
    public function employee()
    {
        return $this->hasOne(EmployeesDetail::class, 'id', 'employees_detail_id');
    }
    public function payroll()
    {
        return $this->hasOne(Payroll::class, 'id', 'payroll_id');
    }
    function contracts()
    {
        return $this->employee->ActiveContractsDuring($this->getMonth()->format("Y-m"));
    }
    public function getDailyRateAttribute()
    {
        $rate = 0;
        $period = Carbon::parse($this->payroll->year . '-' . $this->payroll->month);
        $monthdays = $period->daysInMonth;
        // if ($this->employee && $this->employee->ActiveContractDuring($this->payroll->year . '-' . $this->payroll->month)) {
        //     if ($this->employee->isCasualBetween($period->firstOfMonth(), $period->lastOfMonth())) {
        //         $rate = $this->employee->ActiveContractDuring($this->payroll->year . '-' . $this->payroll->month)->salary_kes;
        //     } else {
        //         $rate = $this->employee->ActiveContractDuring($this->payroll->year . '-' . $this->payroll->month)->salary_kes / $monthdays;
        //     }
        // }

        // return $rate;

        $multiplier = $this->days_worked + $this->leave_days + $this->earned_off_days;

        return $multiplier ? ($this->gross_salary / $multiplier) : 0;
    }
    public function welfareContributions()
    {
        $contributions = $this->employee->welfareContributions()->where('year', $this->payroll->year)->where('month', $this->payroll->month)->get();

        return $contributions;
    }
    function getDaysWorkedAttribute()
    {
        return $this->employee->daysWorked($this->payroll->year . '-' . $this->payroll->month);
    }
    function getLeaveDaysAttribute()
    {
        return $this->employee->daysOnLeave($this->payroll->year . '-' . $this->payroll->month);
    }
    public function getDaysMissedAttribute()
    {
        $days = $this->getMonth()->daysInMonth - $this->days_worked;

        if ($this->leave_days >= $days) {
            return 0;
        } else {
            return $days - $this->leave_days;
        }
    }
    public function getEarnedOffDaysAttribute()
    {
        $offdays = 0;

        foreach ($this->employee->ActiveContractsDuring($this->getMonth()->format("Y-m")) as $key => $contract) {
            $offdays += $contract->EarnedOffDays($this->getMonth()->format("Y-m"));
        }

        return $offdays;
    }
    public function getGrossSalaryAttribute()
    {
        return ($this->basic_salary_kes ?? 0) + ($this->house_allowance_kes ?? 0) + ($this->transport_allowance_kes ?? 0);
    }
    public function getNssfAttribute()
    {
        $calculations = new PaymentsCalculationsService($this->gross_salary, $this->getMonth()->firstOfMonth()->toDateTimeString());
        return $this->is_taxable && $this->gross_salary > 0 ? $calculations->getNssf() : 0;
    }
    public function getNitaAttribute()
    {
        $nita = 0;

        $contract = $this->employee->ActiveContractBetween(Carbon::parse($this->payroll->year . '-' . $this->payroll->month)->firstOfMonth(), Carbon::parse($this->payroll->year . '-' . $this->payroll->month)->lastOfMonth());
        $count = count(EmployeesDetail::all());

        if ($count > 20 && config('app.nita')) {
            if (Carbon::parse($this->payroll->year . '-' . $this->payroll->month . '-01')->isBefore('2024-05-31')) {
                $nita = 0;
            } else {
                if ($this->employee && $contract  && $contract->is_taxable) {
                    $nita = 50;
                }
            }
        }

        // return $nita;
        return $nita;
    }
    public function getTaxableIncomeAttribute()
    {
        return $this->gross_salary - $this->nssf;
    }
    public function getIncomeTaxAttribute()
    {

        $calculations = new PaymentsCalculationsService($this->gross_salary, $this->getMonth()->firstOfMonth()->toDateTimeString());


        return $this->is_taxable ? $calculations->getIncomeTax() : 0;
    }
    public function getNhifAttribute()
    {
        $calculations = new PaymentsCalculationsService($this->gross_salary, $this->getMonth()->firstOfMonth()->toDateTimeString());


        return $calculations->getNhif() ?? 0;
    }
    function getHousingLevyAttribute()
    {
        $calculations = new PaymentsCalculationsService($this->gross_salary, $this->getMonth()->firstOfMonth()->toDateTimeString());

        // return $levy;
        return $this->is_taxable ? $calculations->getHousingLevy() : 0;
    }
    public function getGeneralReliefAttribute()
    {
        $calculations = new PaymentsCalculationsService($this->gross_salary, $this->getMonth()->firstOfMonth()->toDateTimeString());
        return $this->is_taxable ? $calculations->getGeneralRelief() : 0;
    }
    public function getAdvancesAttribute()
    {
        $a = 0;
        foreach ($this->employee->advances as $advance) {
            if ($advance->year == $this->payroll->year && $advance->month == $this->payroll->month) {
                $a += $advance->amount_kes; //check the month
            }
        }


        return $a;
    }
    public function getBonusesAttribute()
    {
        $b = 0;
        foreach ($this->employee->bonuses as $bonus) {
            if ($bonus->year == $this->payroll->year && $bonus->month == $this->payroll->month) {
                $b += $bonus->amount_kes; //check the month
            }
        }


        return $b;
    }
    public function getFinesAttribute()
    {
        $f = 0;
        foreach ($this->employee->fines as $fine) {
            if ($fine->year == $this->payroll->year && $fine->month == $this->payroll->month) {
                $f += $fine->amount_kes; //check the month
            }
        }


        return $f;
    }
    function getOvertimesAttribute()
    {
        $o = 0;

        foreach ($this->employee->ActiveContractsDuring($this->getMonth()->format('Y-m')) as $contract) {
            $o += $contract->EarnedOvertimeKes($this->getMonth()->format('Y-m'));
        }

        return $o;
    }
    public function getLoansAttribute()
    {
        $l = 0;
        foreach ($this->employee->loans as $loan) {
            if ($loan->year == $this->payroll->year && $loan->month == $this->payroll->month) {
                $l += $loan->amount; //check the month
            }
        }


        return $l;
    }
    public function getTaxReliefAttribute()
    {
        $relief = 0;
        if (($this->income_tax - $this->general_relief) > 2400) {
            $relief = 2400;
        } else {
            $relief = $this->income_tax - $this->general_relief;
        }

        // return $relief;
        return $this->is_taxable ? $relief : 0;
    }
    public function getTotalReliefAttribute()
    {
        return $this->tax_relief + $this->general_relief;
    }
    public function getWelfareContributionsAttribute()
    {
        $total = 0;
        foreach ($this->welfareContributions() as $contribution) {
            $total += $contribution->amount_kes;
        }

        return $total;
    }
    public function getPayeAttribute()
    {
        $paye = $this->income_tax > $this->total_relief ? $this->income_tax - $this->total_relief : 0;

        return $paye;
    }
    public function getTotalDeductionsAttribute()
    {
        return $this->nhif + $this->nssf + $this->housing_levy + $this->paye + $this->fines + $this->advances + $this->welfare_contributions + $this->loans;
    }
    public function getTotalAdditionsAttribute()
    {
        return $this->bonuses + $this->overtimes;
    }
    public function getNetPayAttribute()
    {
        return max(($this->gross_salary + $this->total_additions) - $this->total_deductions, 0);
    }
    public function getMonthStringAttribute()
    {
        return Carbon::parse($this->payroll->year . '-' . $this->payroll->month)->format('F \of Y');
    }
    public function getMonth()
    {
        return Carbon::parse($this->payroll->year . '-' . $this->payroll->month);
    }
}
