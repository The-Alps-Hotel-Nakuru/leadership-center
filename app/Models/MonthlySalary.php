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
        if ($this->employee && $this->employee->ActiveContractDuring($this->payroll->year . '-' . $this->payroll->month)) {
            if ($this->employee->isCasualBetween($period->firstOfMonth(), $period->lastOfMonth())) {
                $rate = $this->employee->ActiveContractDuring($this->payroll->year . '-' . $this->payroll->month)->salary_kes;
            } else {
                $rate = $this->employee->ActiveContractDuring($this->payroll->year . '-' . $this->payroll->month)->salary_kes / $monthdays;
            }
        }

        return $rate;
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
            if ($contract->is_full_time() || $contract->is_intern() || $contract->is_student()) {
                $offdays += $contract->EarnedOffDays($this->getMonth()->format("Y-m"));
            }
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
        return $this->is_taxable && $this->gross_salary > 0 ? $calculations->nssf() : 0;
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
        return $this->is_taxable ? $nita : 0;
    }
    public function getTaxableIncomeAttribute()
    {
        return $this->gross_salary - $this->nssf;
    }
    public function getIncomeTaxAttribute()
    {

        $tax = 0;
        $level1 = (288000 / 12);
        $level2 = (388000 / 12);
        $level3 = (6000000 / 12);
        $level4 = (9600000 / 12);

        if ($this->taxable_income <= $level1) {
            $tax = $this->taxable_income * 0.1;
        } elseif ($this->taxable_income > $level1 && $this->taxable_income <= $level2) {
            $tax = (($this->taxable_income - $level1) * 0.25) + 2400;
        } elseif ($this->taxable_income > $level2 && $this->taxable_income <= $level3) {
            $tax = (($this->taxable_income - $level2) * 0.3) + (($level2 - $level1) * 0.25) + 2400;
        } elseif ($this->taxable_income > $level3 && $this->taxable_income <= $level4) {
            $tax = (($this->taxable_income - $level3) * 0.325) + (($level3 - $level2) * 0.3) + (($level2 - $level1) * 0.25) + 2400;
        } else {
            $tax = (($this->taxable_income - $level4) * 0.35) + (($level4 - $level3) * 0.325) + (($level3 - $level2) * 0.3) + (($level2 - $level1) * 0.25) + 2400;
        }

        // return $tax;
        return $this->is_taxable ? $tax : 0;
    }
    public function getNhifAttribute()
    {
        $nhif = 0;
        if ($this->is_taxable) {
            if ($this->gross_salary >= 1000 && $this->gross_salary < 6000) {
                $nhif = 150;
            } elseif ($this->gross_salary >= 6000 && $this->gross_salary < 8000) {
                $nhif = 300;
            } elseif ($this->gross_salary >= 8000 && $this->gross_salary < 12000) {
                $nhif = 400;
            } elseif ($this->gross_salary >= 12000 && $this->gross_salary < 15000) {
                $nhif = 500;
            } elseif ($this->gross_salary >= 15000 && $this->gross_salary < 20000) {
                $nhif = 600;
            } elseif ($this->gross_salary >= 20000 && $this->gross_salary < 25000) {
                $nhif = 750;
            } elseif ($this->gross_salary >= 25000 && $this->gross_salary < 30000) {
                $nhif = 850;
            } elseif ($this->gross_salary >= 30000 && $this->gross_salary < 35000) {
                $nhif = 900;
            } elseif ($this->gross_salary >= 35000 && $this->gross_salary < 40000) {
                $nhif = 950;
            } elseif ($this->gross_salary >= 40000 && $this->gross_salary < 45000) {
                $nhif = 1000;
            } elseif ($this->gross_salary >= 45000 && $this->gross_salary < 50000) {
                $nhif = 1100;
            } elseif ($this->gross_salary >= 50000 && $this->gross_salary < 60000) {
                $nhif = 1200;
            } elseif ($this->gross_salary >= 60000 && $this->gross_salary < 70000) {
                $nhif = 1300;
            } elseif ($this->gross_salary >= 70000 && $this->gross_salary < 80000) {
                $nhif = 1400;
            } elseif ($this->gross_salary >= 80000 && $this->gross_salary < 90000) {
                $nhif = 1500;
            } elseif ($this->gross_salary >= 90000 && $this->gross_salary < 100000) {
                $nhif = 1600;
            } elseif ($this->gross_salary >= 100000) {
                $nhif = 1700;
            } else {
                $nhif = 0;
            }
        }
        return $nhif;
    }
    function getHousingLevyAttribute()
    {
        $levy = 0;
        $contract = $this->employee->ActiveContractBetween(Carbon::parse($this->payroll->year . '-' . $this->payroll->month)->firstOfMonth(), Carbon::parse($this->payroll->year . '-' . $this->payroll->month)->lastOfMonth());
        if (Carbon::parse($this->payroll->year . '-' . $this->payroll->month . '-01')->isBefore('2024-01-31')) {
            if ($this->employee && $contract && $contract->is_taxable) {
                $levy = 0.015 * $this->gross_salary;
            }
        } else {
            if (Carbon::parse($this->payroll->year . '-' . $this->payroll->month . '-01')->isBefore('2024-02-29')) {
                $levy = 0;
            } else {
                if (Carbon::parse($this->payroll->year . '-' . $this->payroll->month . '-01')->isBefore('2024-05-31')) {
                    if ($this->employee && $contract && $contract->is_taxable) {
                        $levy = 0.015 * $this->gross_salary;
                    }
                } else {
                    if ($this->employee && $contract && $contract->is_taxable) {
                        $levy = 0.015 * $this->gross_salary;
                    }
                }
            }
        }

        // return $levy;
        return $this->is_taxable ? $levy : 0;
    }
    public function getGeneralReliefAttribute()
    {
        $relief = 0;

        if ($this->nhif) {
            $relief += (0.15 * $this->nhif);
        }
        if ($this->insurance) {
            foreach ($this->insurance as $insurance) {
                $relief += (0.15 * $insurance->monthly_premium_kes);
            }
        }

        if ($this->housing_levy && Carbon::parse($this->payroll->year . '-' . $this->payroll->month . '-01')->isAfter('2024-03-31')) {
            $relief += (0.15 * $this->housing_levy);
        }

        // return $relief;
        return $this->is_taxable ? $relief : 0;
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
