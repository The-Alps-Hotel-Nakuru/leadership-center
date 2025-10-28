<?php

namespace App\Exports\ForceHRMS;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class FullDataExportForceHRMS implements WithMultipleSheets
{
    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [
            // Required sheets
            new Company(),
            new Departments(),
            new Designations(),
            new Employees(),
        ];

        // Add optional sheets if they have data
        if ($this->hasEmploymentTypes()) {
            $sheets[] = new EmploymentTypes();
        }

        if ($this->hasBans()) {
            $sheets[] = new Bans();
        }

        if ($this->hasLeaveTypes()) {
            $sheets[] = new LeaveTypes();
        }

        if ($this->hasLeaves()) {
            $sheets[] = new Leaves();
        }

        if ($this->hasContracts()) {
            $sheets[] = new Contracts();
        }

        if ($this->hasFines()) {
            $sheets[] = new Fines();
        }

        if ($this->hasBonuses()) {
            $sheets[] = new Bonuses();
        }

        if ($this->hasAdvances()) {
            $sheets[] = new Advances();
        }

        if ($this->hasWelfareContributions()) {
            $sheets[] = new WelfareContributions();
        }

        if ($this->hasAttendances()) {
            $sheets[] = new Attendances();
        }

        if ($this->hasExtraWorks()) {
            $sheets[] = new ExtraWorks();
        }
        if ($this->hasLoans()) {
            $sheets[] = new Loans();
        }

        if ($this->hasLoanDeductions()) {
            $sheets[] = new LoanDeductions();
        }

        if ($this->hasPayrolls()) {
            $sheets[] = new Payrolls();
        }

        if ($this->hasPayments()) {
            $sheets[] = new Payments();
        }

        return $sheets;
    }

    /**
     * Check if company has bans data
     */
    private function hasBans(): bool
    {
        return \App\Models\Ban::exists();
    }

    /**
     * Check if company has loans data
     */
    private function hasLoans(): bool
    {
        return \App\Models\Loan::exists();
    }

    /**
     * Check if company has loan deductions data
     */
    private function hasLoanDeductions(): bool
    {
        return \App\Models\LoanDeduction::exists();
    }

    /**
     * Check if company has employment types data
     */
    private function hasEmploymentTypes(): bool
    {
        return \App\Models\EmploymentType::exists();
    }

    /**
     * Check if company has leave types data
     */
    private function hasLeaveTypes(): bool
    {
        return \App\Models\LeaveType::exists();
    }

    /**
     * Check if company has leaves data
     */
    private function hasLeaves(): bool
    {
        return \App\Models\Leave::exists();
    }

    /**
     * Check if company has contracts data
     */
    private function hasContracts(): bool
    {
        return \App\Models\EmployeeContract::exists();
    }

    /**
     * Check if company has fines data
     */
    private function hasFines(): bool
    {
        return \App\Models\Fine::exists();
    }

    /**
     * Check if company has bonuses data
     */
    private function hasBonuses(): bool
    {
        return \App\Models\Bonus::exists();
    }

    /**
     * Check if company has advances data
     */
    private function hasAdvances(): bool
    {
        return \App\Models\Advance::exists();
    }

    /**
     * Check if company has welfare contributions data
     */
    private function hasWelfareContributions(): bool
    {
        return \App\Models\WelfareContribution::exists();
    }

    /**
     * Check if company has attendance data
     */
    private function hasAttendances(): bool
    {
        return \App\Models\Attendance::exists();
    }

    /**
     * Check if company has extra work data
     */
    private function hasExtraWorks(): bool
    {
        return \App\Models\ExtraWork::exists();
    }

    /**
     * Check if company has payroll data
     */
    private function hasPayrolls(): bool
    {
        return \App\Models\Payroll::exists();
    }

    /**
     * Check if company has payment data
     */
    private function hasPayments(): bool
    {
        return \App\Models\PayrollPayment::exists();
    }
}
