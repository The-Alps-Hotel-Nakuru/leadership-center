<?php

namespace App\Services;

use Carbon\Carbon;

class PaymentsCalculationsService
{
    public $gross_salary;
    public $date;
    public function __construct($gross_salary, $date)
    {
        $this->gross_salary = $gross_salary;
        $this->date = $date;
    }

    public function getNssf()
    {
        $nssf = 0;
        if (Carbon::parse($this->date)->isBefore('2025-02-01')) {
            if (Carbon::parse($this->date)->isBefore('2024-02-01')) {
                $nssf = 0.06 * $this->gross_salary;

                if ($nssf > 1080) {
                    $nssf = 1080;
                }
            } else {
                $nssf = 0.06 * $this->gross_salary;

                if ($nssf > 2160) {
                    $nssf = 2160;
                }
            }
            return $nssf;
        } else {
            $nssf = 0.06 * $this->gross_salary;

            if ($nssf > 4320) {
                $nssf = 4320;
            }
        }
        return $nssf;
    }

    public function getTaxableIncome()
    {
        if (Carbon::parse($this->date)->isBefore("2025-01-01")) {
            return $this->gross_salary - $this->getNssf();
        }
        return $this->gross_salary - ($this->getNssf() + $this->getHousingLevy() + $this->getShif());
    }
    public function getIncomeTax()
    {
        $tax = 0;

        $level1 = 288000 / 12;
        $level2 = 388000 / 12;
        $level3 = 6000000 / 12;
        $level4 = 9600000 / 12;

        if ($this->getTaxableIncome() <= $level1) {
            $tax = $this->getTaxableIncome() * 0.1;
        } elseif ($this->getTaxableIncome() > $level1 && $this->getTaxableIncome() <= $level2) {
            $tax = (($this->getTaxableIncome() - $level1) * 0.25) + ($level1 * 0.1);
        } elseif ($this->getTaxableIncome() > $level2 && $this->getTaxableIncome() <= $level3) {
            $tax = (($this->getTaxableIncome() - $level2) * 0.3) + (($level2 - $level1) * 0.25) + ($level1 * 0.1);
        } elseif ($this->getTaxableIncome() > $level3 && $this->getTaxableIncome() <= $level4) {
            $tax = (($this->getTaxableIncome() - $level3) * 0.325) + (($level3 - $level2) * 0.3) + (($level2 - $level1) * 0.25) + ($level1 * 0.1);
        } else {
            $tax = (($this->getTaxableIncome() - $level4) * 0.35) + (($level4 - $level3) * 0.325) + (($level3 - $level2) * 0.3) + (($level2 - $level1) * 0.25) + ($level1 * 0.1);
        }

        return $tax;
    }

    public function getNhif()
    {
        $levels = [5999, 7999, 11999, 14999, 19999, 24999, 29999, 34999, 39999, 44999, 49999, 59999, 69999, 79999, 89999, 99999];
        $rates = [150, 300, 400, 500, 600, 750, 850, 900, 950, 1000, 1100, 1200, 1300, 1400, 1500, 1600];

        $nhif = 0;

        if (Carbon::parse($this->date)->isAfter("2024-09-30")) {
            return 0;
        }

        if ($this->gross_salary > 99999) {
            return 1700;
        } elseif ($this->gross_salary < 1000) {
            return 0;
        } else {
            for ($i = 0; $i < count($levels); $i++) {
                if ($this->gross_salary <= $levels[$i] && $this->gross_salary > ($levels[$i - 1] ?? 0)) {
                    $nhif = $rates[$i];
                }
            }
        }
        return $nhif;
    }

    public function getShif()
    {

        $shif = 0;

        if (Carbon::parse($this->date)->isAfter("2024-09-30")) {
            $shif = 0.0275 * $this->gross_salary;
            if ($shif < 300) {
                $shif = 300;
            }
        } else {
            return 0;
        }
        return $shif;
    }

    public function getHousingLevy()
    {
        $levy = 0;

        if (Carbon::parse($this->date)->isAfter('2024-02-29')) {
            $levy = $this->gross_salary * 0.015; // Get 1.5% of Gross Salary
        }
        return $levy;
    }

    public function getGeneralRelief()
    {
        return $this->getInsuranceRelief() + $this->getHousingLevyRelief();
    }

    public function getInsuranceRelief()
    {
        if (Carbon::parse($this->date)->isBefore("2025-01-01")) {
            $insurance = 0;

            $insurance += $this->getNhif();

            if (Carbon::parse($this->date)->isAfter("2024-10-31")) {
                $insurance += $this->getShif();
            }

            return 0.15 * $insurance;
        }
        return 0;
    }

    public function getHousingLevyRelief()
    {
        if (Carbon::parse($this->date)->isBefore("2025-01-01")) {
            return 0.15 * $this->getHousingLevy();
        }

        return 0;
    }


    public function getTaxRelief()
    {

        $relievable = $this->getIncomeTax() - $this->getGeneralRelief();

        return $relievable >= 2400 ? 2400 : $relievable;
    }

    public function getPaye()
    {
        return $this->getIncomeTax() - $this->getTaxRelief() - $this->getGeneralRelief();
    }

    public function getNetSalary()
    {
        return $this->gross_salary - $this->getPaye() - $this->getNssf() - $this->getNhif() - $this->getShif() - $this->getHousingLevy();
    }
}
