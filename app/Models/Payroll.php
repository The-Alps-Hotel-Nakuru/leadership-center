<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    function getYearmonthAttribute()
    {
        return Carbon::parse($this->year . '-' . $this->month)->format('F \of Y');
    }

    public function monthlySalaries()
    {
        return $this->hasMany(MonthlySalary::class,);
    }


    public function getTotalAttribute()
    {


        return $this->casual_gross + $this->full_time_gross + $this->intern_gross + $this->external_gross;
    }

    public function getCasualGrossAttribute()
    {
        $amount = 0;
        foreach ($this->monthlySalaries as $salary) {
            if ($salary->employee && $salary->employee->ActiveContractDuring($this->year . '-' . $this->month)->is_casual()) {
                $amount += $salary->gross_salary;
            }
        }

        return $amount;
    }
    public function getCasualTotalAttribute()
    {
        $amount = 0;
        foreach ($this->monthlySalaries as $salary) {
            if ($salary->employee && $salary->employee->ActiveContractDuring($this->year . '-' . $this->month)->is_casual()) {
                $amount += $salary->net_pay;
            }
        }

        return $amount;
    }
    public function getFullTimeGrossAttribute()
    {
        $amount = 0;
        foreach ($this->monthlySalaries as $salary) {
            if ($salary->employee && $salary->employee->ActiveContractDuring($this->year . '-' . $this->month)->is_full_time()) {
                $amount += $salary->gross_salary;
            }
        }

        return $amount;
    }
    public function getAdvancesTotalAttribute()
    {
        $amount = 0;
        foreach ($this->monthlySalaries as $salary) {
            if ($salary->employee && $salary->employee->ActiveContractDuring($this->year . '-' . $this->month)->is_full_time()) {
                $amount += $salary->advances;
            }
        }

        return $amount;
    }
    public function getBonusesTotalAttribute()
    {
        $amount = 0;
        foreach ($this->monthlySalaries as $salary) {
            if ($salary->employee && $salary->employee->ActiveContractDuring($this->year . '-' . $this->month)->is_full_time()) {
                $amount += $salary->bonuses;
            }
        }

        return $amount;
    }
    public function getFinesTotalAttribute()
    {
        $amount = 0;
        foreach ($this->monthlySalaries as $salary) {
            if ($salary->employee && $salary->employee->ActiveContractDuring($this->year . '-' . $this->month)->is_full_time()) {
                $amount += $salary->fines;
            }
        }

        return $amount;
    }
    public function getPenaltyTotalAttribute()
    {
        $amount = 0;
        foreach ($this->monthlySalaries as $salary) {
            if ($salary->employee && $salary->employee->ActiveContractDuring($this->year . '-' . $this->month)->is_full_time()) {
                $amount += $salary->attendance_penalty;
            }
        }

        return $amount;
    }
    public function getFullTimeNetAttribute()
    {
        $amount = 0;
        foreach ($this->monthlySalaries as $salary) {
            if ($salary->employee && $salary->employee->ActiveContractDuring($this->year . '-' . $this->month)->is_full_time()) {
                $amount += $salary->net_pay;
            }
        }

        return $amount;
    }
    public function getInternGrossAttribute()
    {
        $amount = 0;
        foreach ($this->monthlySalaries as $salary) {
            if ($salary->employee && $salary->employee->ActiveContractDuring($this->year . '-' . $this->month)->is_intern()) {
                $amount += $salary->gross_salary;
            }
        }

        return $amount;
    }
    public function getInternNetAttribute()
    {
        $amount = 0;
        foreach ($this->monthlySalaries as $salary) {
            if ($salary->employee && $salary->employee->ActiveContractDuring($this->year . '-' . $this->month)->is_intern()) {
                $amount += $salary->net_pay;
            }
        }

        return $amount;
    }
    public function getExternalGrossAttribute()
    {
        $amount = 0;
        foreach ($this->monthlySalaries as $salary) {
            if ($salary->employee && $salary->employee->ActiveContractDuring($this->year . '-' . $this->month)->is_external()) {
                $amount += $salary->gross_salary;
            }
        }

        return $amount;
    }
    public function getExternalNetAttribute()
    {
        $amount = 0;
        foreach ($this->monthlySalaries as $salary) {
            if ($salary->employee && $salary->employee->ActiveContractDuring($this->year . '-' . $this->month)->is_external()) {
                $amount += $salary->net_pay;
            }
        }

        return $amount;
    }

    public function getPayeTotalAttribute()
    {
        $amount = 0;

        foreach ($this->monthlySalaries as $salary) {
            $amount += $salary->paye;
        }

        return $amount;
    }
    public function getWelfareContributionsTotalAttribute()
    {
        $amount = 0;

        foreach ($this->monthlySalaries as $salary) {
            $amount += $salary->welfare_contributions;
        }

        return $amount;
    }
    public function getNhifTotalAttribute()
    {
        $amount = 0;

        foreach ($this->monthlySalaries as $salary) {
            $amount += $salary->nhif;
        }

        return $amount;
    }
    public function getNssfTotalAttribute()
    {
        $amount = 0;

        foreach ($this->monthlySalaries as $salary) {
            $amount += $salary->nssf;
        }

        return $amount;
    }
    public function getHousingLevyTotalAttribute()
    {
        $amount = 0;

        foreach ($this->monthlySalaries as $salary) {
            $amount += $salary->housing_levy;
        }

        return $amount;
    }

    function payment()
    {
        return $this->hasMany(PayrollPayment::class);
    }
}
