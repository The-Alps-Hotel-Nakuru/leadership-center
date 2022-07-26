<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    public function monthlySalaries()
    {
        return $this->hasMany(MonthlySalary::class);
    }


    public function getTotalAttribute()
    {
        $amount = 0;
        foreach ($this->monthlySalaries as $salary) {
            $amount += $salary->employee->active_contract->salary_kes;
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
    public function getFullTimeTotalAttribute()
    {
        $amount = 0;
        foreach ($this->monthlySalaries as $salary) {
            if ($salary->employee && $salary->employee->is_full_time) {
                $amount += $salary->gross_salary;
            }
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
}
