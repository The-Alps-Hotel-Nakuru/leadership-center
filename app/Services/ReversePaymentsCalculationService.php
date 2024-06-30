<?php

namespace App\Services;

class ReversePaymentsCalculationService {
    public $net_salary;

    public function __construct($net_salary) {
        $this->net_salary = $net_salary;
    }

    function calculateGrossFromNet($datetime, $tolerance = 0.01, $maxIterations = 1000)
    {
        // Constants
        $initialGrossEstimate = $this->net_salary / 0.7; // Initial estimate

        $grossPay = $initialGrossEstimate;

        for ($i = 0; $i < $maxIterations; $i++) {
            // Calculate deductions for the current estimate of gross pay
            $calculations = new PaymentsCalculationsService($grossPay, $datetime);


            // Check if the computed net pay is within the tolerance of the target net pay
            if (abs($calculations->net_salary() - $this->net_salary) < $tolerance) {
                return $grossPay;
            }

            // Adjust gross pay estimate
            $grossPay += ($this->net_salary - $calculations->net_salary());
        }

        // If the loop finishes without finding an accurate result, return the last estimate
        return $grossPay;
    }
}
