<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    function getYearmonthAttribute() {
        return Carbon::parse($this->year.'-'.$this->month)->format('F \of Y');
    }

    public function monthlySalaries()
    {
        return $this->hasMany(MonthlySalary::class, );
    }


    public function getTotalAttribute()
    {
        $amount = 0;
        foreach ($this->monthlySalaries as $salary) {
            $amount += $salary->employee->active_contract->salary_kes ?? 0;
        }

        return $amount;
    }

    public function getCasualTotalAttribute()
    {
        $amount = 0;
        foreach ($this->monthlySalaries as $salary) {
            if ($salary->employee && $salary->employee->is_casual) {
                $amount += $salary->gross_salary;
            }
        }

        return $amount;
    }
    public function getFullTimeGrossAttribute()
    {
        $amount = 0;
        foreach ($this->monthlySalaries as $salary) {
            if ($salary->employee && $salary->employee->is_full_time) {
                $amount += $salary->gross_salary;
            }
        }

        return $amount;
    }
    public function getPenaltyTotalAttribute()
    {
        $amount = 0;
        foreach ($this->monthlySalaries as $salary) {
            if ($salary->employee && $salary->employee->is_full_time) {
                $amount += $salary->attendance_penalty;
            }
        }

        return $amount;
    }
    public function getFullTimeNetAttribute()
    {
        $amount = 0;
        foreach ($this->monthlySalaries as $salary) {
            if ($salary->employee && $salary->employee->is_full_time) {
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
}
