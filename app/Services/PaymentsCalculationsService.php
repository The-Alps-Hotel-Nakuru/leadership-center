<?php

namespace App\Services;

use Carbon\Carbon;

class PaymentsCalculationsService
{

    public $gross_salary, $datetime;

    public function __construct($gross_salary, $datetime)
    {
        $this->gross_salary = $gross_salary;
        $this->datetime = $datetime;
    }

    function nhif()
    {
        $nhif = 0;


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


        return $nhif;
    }
    function nssf()
    {
        $nssf = 0;

        if (Carbon::parse($this->datetime)->isBefore('2024-01-31')) {

            $nssf = 200;
            if ($this->gross_salary > (40000 / 12)) {
                $nssf = 0.06 * $this->gross_salary;
                if ($nssf > 1080) {
                    $nssf = 1080;
                }
            }
        } else {
            if (Carbon::parse($this->datetime)->isBefore('2024-03-31')) {
                $nssf = 420;
                if ($this->gross_salary > (7000)) {
                    $nssf = 0.06 * $this->gross_salary;
                    if ($nssf > 1740) {
                        $nssf = 1740;
                    }
                }
            } else {

                $nssf = 420;
                if ($this->gross_salary > (7000)) {
                    $nssf = 0.06 * $this->gross_salary;
                    if ($nssf > 2160) {
                        $nssf = 2160;
                    }
                }
            }
        }


        return $nssf;
    }
    function ahl()
    {
        $levy = 0;
        if (Carbon::parse($this->datetime)->isBefore('2024-01-31')) {

            $levy = 0.015 * $this->gross_salary;
        } else {
            if (Carbon::parse($this->datetime)->isBefore('2024-02-29')) {
                $levy = 0;
            } else {

                $levy = 0.015 * $this->gross_salary;
            }
        }

        return $levy;
    }
    function paye()
    {

        $personalRelief = 2400;
        $insuranceReliefPercentage = 0.15;

        // Securities Fund Contribution (capped at KES 2160)
        $securitiesFund = $this->nssf();

        // Taxable Income
        $taxableIncome = $this->gross_salary - $securitiesFund;

        // Tax Calculation based on brackets
        $tax = 0;


        $level1 = (288000 / 12);
        $level2 = (388000 / 12);
        $level3 = (6000000 / 12);
        $level4 = (9600000 / 12);

        if ($taxableIncome <= $level1) {
            $tax = $taxableIncome * 0.1;
        } elseif ($taxableIncome > $level1 && $taxableIncome <= $level2) {
            $tax = (($taxableIncome - $level1) * 0.25) + 2400;
        } elseif ($taxableIncome > $level2 && $taxableIncome <= $level3) {
            $tax = (($taxableIncome - $level2) * 0.3) + (($level2 - $level1) * 0.25) + 2400;
        } elseif ($taxableIncome > $level3 && $taxableIncome <= $level4) {
            $tax = (($taxableIncome - $level3) * 0.325) + (($level3 - $level2) * 0.3) + (($level2 - $level1) * 0.25) + 2400;
        } else {
            $tax = (($taxableIncome - $level4) * 0.35) + (($level4 - $level3) * 0.325) + (($level3 - $level2) * 0.3) + (($level2 - $level1) * 0.25) + 2400;
        }

        // Insurance Relief
        $insuranceRelief = $this->nhif() * $insuranceReliefPercentage;

        // PAYE After Reliefs
        $paye = $tax - $personalRelief - $insuranceRelief;

        // Ensure PAYE is not negative
        return max($paye, 0);
    }

    function net_salary()
    {
        return $this->gross_salary - ($this->paye() + $this->nssf() + $this->nhif() + $this->ahl());
    }
}
