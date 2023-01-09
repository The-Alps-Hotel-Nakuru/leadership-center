<?php

namespace App\Models;

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
        'total_deductions',
        'total_relief',
        'daily_rate',
        'days_missed',

    ];

    public function employee()
    {
        return $this->hasOne(EmployeesDetail::class, 'id');
    }
    public function payroll()
    {
        return $this->hasOne(Payroll::class, 'id', 'payroll_id');
    }


    public function getDailyRateAttribute()
    {
        $rate = 0;
        $monthdays = Carbon::parse($this->payroll->year . '-' . $this->payroll->month)->daysInMonth;
        if ($this->employee && $this->employee->has_active_contract) {
            if ($this->employee->is_casual) {
                $rate = $this->employee->active_contract->salary_kes;
            } elseif ($this->employee->is_full_time) {
                $rate = $this->employee->active_contract->salary_kes / $monthdays;
            }
        }

        return $rate;
    }

    public function getDaysMissedAttribute()
    {
        return Carbon::parse($this->payroll->year . '-' . $this->payroll->month)->daysInMonth - $this->employee->daysWorked($this->payroll->year . '-' . $this->payroll->month);
    }


    public function getGrossSalaryAttribute()
    {
        return ($this->basic_salary_kes ?? 0) + ($this->house_allowance_kes ?? 0) + ($this->transport_allowance_kes ?? 0);
    }

    public function getNssfAttribute()
    {
        $nssf = 0;

        if ($this->employee->is_full_time) {
            $nssf = 200;
            if ($this->employee->is_full_time && $this->gross_salary > (40000 / 12)) {
                $nssf = 0.06 * $this->gross_salary;
                if ($nssf > 1080) {
                    $nssf = 1080;
                }
            }
        }

        return $nssf;
    }


    public function getTaxableIncomeAttribute()
    {
        return $this->gross_salary - $this->nssf;
    }

    public function getPayeAttribute()
    {
        $paye = 0;
        $level1 = (288000 / 12);
        $level2 = (388000 / 12);

        if ($this->employee->is_full_time && $this->taxable_income <= $level1) {
            $paye = $this->taxable_income * 0.1;
        } elseif ($this->taxable_income > $level1 && $this->taxable_income <= $level2) {
            $paye = (($this->taxable_income - $level1) * 0.25) + 2400;
        } elseif ($this->taxable_income > $level2) {
            $paye = (($this->taxable_income - $level2) * 0.3) + (($level2 - $level1) * 0.25) + 2400;
        }

        return $paye;
    }

    public function getNhifAttribute()
    {
        $nhif = 0;

        if ($this->employee->is_full_time) {
            if ($this->gross_salary >= 0 && $this->gross_salary < 6000) {
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
            }
        }

        return $nhif;
    }

    public function getAttendancePenaltyAttribute()
    {
        $penalty = 0;
        if ($this->employee->is_full_time) {
            if ($this->days_missed > 4) {
                $penalty = $this->daily_rate * ($this->days_missed - 4);
            }
        }

        return $penalty;
    }


    public function bonuses()
    {
        return $this->hasMany(Bonus::class);
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

        return $relief;
    }

    public function getBonusAttribute()
    {
        $b = 0;
        foreach ($this->bonuses as $bonus) {
            $b += $bonus->amount_kes; //check the month
        }

        return $b;
    }



    public function getTaxReliefAttribute()
    {
        $relief = 0;
        if ($this->paye > 2400) {
            $relief = 2400;
        } else {
            $relief = $this->paye;
        }

        return $relief;
    }

    public function getTotalReliefAttribute()
    {
        return $this->tax_relief + $this->insurance_relief;
    }


    public function getTotalDeductionsAttribute()
    {
        return $this->nhif + $this->attendance_penalty;
    }

    public function getTotalAdditionsAttribute()
    {
        return $this->tax_relief + $this->general_relief + $this->bonus;
    }

    public function getNetPayAttribute()
    {
        return $this->gross_salary + $this->total_additions - $this->total_deductions;
    }
}
