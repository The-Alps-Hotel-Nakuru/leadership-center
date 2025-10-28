<?php

namespace App\Exports\ForceHRMS;

use App\Models\MonthlySalary;
use App\Models\PayrollPayment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class Salaries implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
{
    /**
     * @return string
     */
    public function title(): string
    {
        return 'Salaries';
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Employee Email',
            'Year',
            'Month',
            'Basic Salary KES',
            'House Allowance KES',
            'Transport Allowance KES',
            'Created At',
            'Updated At',
            'Is Taxable',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return MonthlySalary::with(['employee.user', 'payroll'])->get()->map(function ($salary) {
            return [
                $salary->employee->user->email ?? '',
                $salary->payroll->year ?? '',
                $salary->payroll->month ?? '',
                $salary->basic_salary_kes ?? 0,
                $salary->house_allowance_kes ?? 0,
                $salary->transport_allowance_kes ?? 0,
                $salary->created_at ?? '',
                $salary->updated_at ?? '',
                $salary->is_taxable ?? 0,
            ];
        });
    }
}
