<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;


    public function getYearmonthAttribute()
    {
        return Carbon::parse($this->year . '-' . $this->month)->format('F \of Y');
    }


    public function monthlySalaries()
    {
        return $this->hasMany(MonthlySalary::class,);
    }

    public function getHolidaysAttribute()
    {
        $count = 0;
        $month = Carbon::parse($this->year . '-' . $this->month);
        foreach (Holiday::all() as $holiday) {
            if (Carbon::parse($holiday->date)->isBetween($month->firstOfMonth(), $month->lastOfMonth(), true)) {
                $count++;
            }
        }

        return $count;
    }


    public function getTotalAttribute()
    {
        return $this->casual_gross + $this->full_time_gross + $this->intern_gross + $this->external_gross;
    }

    public function getFullGrossAttribute()
    {
        return $this->total + $this->nssf_total + $this->housing_levy_total;
    }

    public function getCasualGrossAttribute()
    {
        $amount = 0;
        if (count($this->monthlySalaries) > 0) {
            foreach ($this->monthlySalaries as $salary) {
                if ($salary->employee && $salary->employee->ActiveContractDuring($this->year . '-' . $this->month) && $salary->employee->ActiveContractDuring($this->year . '-' . $this->month)->is_casual()) {
                    $amount += $salary->gross_salary;
                }
            }
        }

        return $amount;
    }
    public function getCasualTotalAttribute()
    {
        $amount = 0;
        if (count($this->monthlySalaries) > 0) {
            foreach ($this->monthlySalaries as $salary) {
                if ($salary->employee && $salary->employee->ActiveContractDuring($this->year . '-' . $this->month) && $salary->employee->ActiveContractDuring($this->year . '-' . $this->month)->is_casual()) {
                    $amount += $salary->net_pay;
                }
            }
        }

        return $amount;
    }
    public function getFullTimeGrossAttribute()
    {
        $amount = 0;
        if (count($this->monthlySalaries) > 0) {
            foreach ($this->monthlySalaries as $salary) {
                if ($salary->employee && $salary->employee->ActiveContractDuring($this->year . '-' . $this->month) && $salary->employee->ActiveContractDuring($this->year . '-' . $this->month)->is_full_time()) {
                    $amount += $salary->gross_salary;
                }
            }
        }

        return $amount;
    }
    public function getAdvancesTotalAttribute()
    {
        $amount = 0;
        if (count($this->monthlySalaries) > 0) {
            foreach ($this->monthlySalaries as $salary) {
                if ($salary->employee && $salary->employee->ActiveContractDuring($this->year . '-' . $this->month)) {
                    $amount += $salary->advances;
                }
            }
        }

        return $amount;
    }
    public function getBonusesTotalAttribute()
    {
        $amount = 0;
        if (count($this->monthlySalaries) > 0) {
            foreach ($this->monthlySalaries as $salary) {
                if ($salary->employee && $salary->employee->ActiveContractDuring($this->year . '-' . $this->month)) {
                    $amount += $salary->bonuses;
                }
            }
        }

        return $amount;
    }
    public function getFinesTotalAttribute()
    {
        $amount = 0;
        if (count($this->monthlySalaries) > 0) {
            foreach ($this->monthlySalaries as $salary) {
                if ($salary->employee && $salary->employee->ActiveContractDuring($this->year . '-' . $this->month)) {
                    $amount += $salary->fines;
                }
            }
        }

        return $amount;
    }
    public function getLoansTotalAttribute()
    {
        $amount = 0;
        if (count($this->monthlySalaries) > 0) {
            foreach ($this->monthlySalaries as $salary) {
                if ($salary->employee && $salary->employee->ActiveContractDuring($this->year . '-' . $this->month)) {
                    $amount += $salary->loans;
                }
            }
        }

        return $amount;
    }
    public function getPenaltyTotalAttribute()
    {
        $amount = 0;
        if (count($this->monthlySalaries) > 0) {
            foreach ($this->monthlySalaries as $salary) {
                if ($salary->employee && $salary->employee->ActiveContractDuring($this->year . '-' . $this->month)) {
                    $amount += $salary->attendance_penalty;
                }
            }
        }

        return $amount;
    }
    public function getFullTimeNetAttribute()
    {
        $amount = 0;
        if (count($this->monthlySalaries) > 0) {
            foreach ($this->monthlySalaries as $salary) {
                if ($salary->employee && $salary->employee->ActiveContractDuring($this->year . '-' . $this->month)->is_full_time()) {
                    $amount += $salary->net_pay;
                }
            }
        }

        return $amount;
    }
    public function getInternGrossAttribute()
    {
        $amount = 0;
        if (count($this->monthlySalaries) > 0) {
            foreach ($this->monthlySalaries as $salary) {
                if ($salary->employee && $salary->employee->ActiveContractDuring($this->year . '-' . $this->month) && $salary->employee->ActiveContractDuring($this->year . '-' . $this->month)->is_intern()) {
                    $amount += $salary->gross_salary;
                }
            }
        }

        return $amount;
    }
    public function getInternNetAttribute()
    {
        $amount = 0;
        if (count($this->monthlySalaries) > 0) {
            foreach ($this->monthlySalaries as $salary) {
                if ($salary->employee && $salary->employee->ActiveContractDuring($this->year . '-' . $this->month) && $salary->employee->ActiveContractDuring($this->year . '-' . $this->month)->is_intern()) {
                    $amount += $salary->net_pay;
                }
            }
        }

        return $amount;
    }
    public function getExternalGrossAttribute()
    {
        $amount = 0;
        if (count($this->monthlySalaries) > 0) {
            foreach ($this->monthlySalaries as $salary) {
                if ($salary->employee && $salary->employee->ActiveContractDuring($this->year . '-' . $this->month) && $salary->employee->ActiveContractDuring($this->year . '-' . $this->month)->is_external()) {
                    $amount += $salary->gross_salary;
                }
            }
        }

        return $amount;
    }
    public function getExternalNetAttribute()
    {
        $amount = 0;
        if (count($this->monthlySalaries) > 0) {
            foreach ($this->monthlySalaries as $salary) {
                if ($salary->employee && $salary->employee->ActiveContractDuring($this->year . '-' . $this->month) && $salary->employee->ActiveContractDuring($this->year . '-' . $this->month)->is_external()) {
                    $amount += $salary->net_pay;
                }
            }
        }

        return $amount;
    }

    public function getPayeTotalAttribute()
    {
        $amount = 0;

        if (count($this->monthlySalaries) > 0) {
            foreach ($this->monthlySalaries as $salary) {
                $amount += $salary->paye;
            }
        }

        return $amount;
    }
    public function getWelfareContributionsTotalAttribute()
    {
        $amount = 0;

        if (count($this->monthlySalaries) > 0) {
            foreach ($this->monthlySalaries as $salary) {
                $amount += $salary->welfare_contributions;
            }
        }

        return $amount;
    }
    public function getNhifTotalAttribute()
    {
        $amount = 0;

        if (count($this->monthlySalaries) > 0) {
            foreach ($this->monthlySalaries as $salary) {
                $amount += $salary->nhif;
            }
        }

        return $amount;
    }
    public function getShifTotalAttribute()
    {
        $amount = 0;

        if (count($this->monthlySalaries) > 0) {
            foreach ($this->monthlySalaries as $salary) {
                $amount += $salary->shif;
            }
        }

        return $amount;
    }
    public function getNssfTotalAttribute()
    {
        $amount = 0;

        if (count($this->monthlySalaries) > 0) {
            foreach ($this->monthlySalaries as $salary) {
                $amount += $salary->nssf;
            }
        }

        return $amount;
    }
    public function getNitaTotalAttribute()
    {
        $amount = 0;

        if (count($this->monthlySalaries) > 0) {
            foreach ($this->monthlySalaries as $salary) {
                $amount += $salary->nita;
            }
        }

        return $amount;
    }
    public function getHousingLevyTotalAttribute()
    {
        $amount = 0;

        if (count($this->monthlySalaries) > 0) {
            foreach ($this->monthlySalaries as $salary) {
                $amount += $salary->housing_levy;
            }
        }

        return $amount;
    }

    function payments()
    {
        return $this->hasMany(PayrollPayment::class);
    }

    public function getIsPaidAttribute()
    {
        if ($this->payment_slip_path && file_exists($this->payment_slip_path)) {
            return true;
        }
        return false;
    }


    public function getGrossSalaryTotalAttribute()
    {
        $total = 0;

        foreach ($this->monthlySalaries as $key => $salary) {
            $total += $salary->gross_salary;
        }

        return $total;
    }
    public function getOvertimesTotalAttribute()
    {
        $total = 0;

        foreach ($this->monthlySalaries as $key => $salary) {
            $total += $salary->overtimes;
        }

        return $total;
    }


    public function getGrossPaymentsTotalAttribute()
    {
        $amount = 0;


        foreach ($this->payments as $key => $payment) {
            $amount += $payment->gross_salary;
        }

        return $amount;
    }

    public function getNetPayTotalAttribute()
    {
        $amount = 0;


        foreach ($this->monthlySalaries as $key => $salary) {
            $amount += $salary->net_pay;
        }

        return $amount;
    }

    public function getPaymentsTotalAttribute()
    {
        $amount = 0;


        foreach ($this->payments as $key => $payment) {
            $amount += $payment->net_pay;
        }

        return $amount;
    }
}
