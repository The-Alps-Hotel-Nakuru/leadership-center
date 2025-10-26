<?php

namespace App\Exports\ForceHRMS;

use App\Models\PayrollPayment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class Payments implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
{
    /**
     * @return string
     */
    public function title(): string
    {
        return 'Payments';
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'employee_email',
            'payroll_year',
            'payroll_month',
            'gross_salary',
            'nssf',
            'nhif',
            'shif',
            'paye',
            'housing_levy',
            'nita',
            'total_fines',
            'total_loans',
            'total_advances',
            'total_welfare_contributions',
            'attendance_penalty',
            'total_bonuses',
            'total_overtimes',
            'net_pay',
            'bank_name',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return PayrollPayment::with(['employee.user', 'payroll', 'bank'])->get()->map(function ($payment) {
            return [
                $payment->employee->user->email ?? '',
                $payment->payroll->year ?? '',
                $payment->payroll->month ?? '',
                $payment->gross_salary ?? 0,
                $payment->nssf ?? 0,
                $payment->nhif ?? 0,
                $payment->shif ?? 0,
                $payment->paye ?? 0,
                $payment->housing_levy ?? 0,
                $payment->nita ?? 0,
                $payment->total_fines ?? 0,
                $payment->total_loans ?? 0,
                $payment->total_advances ?? 0,
                $payment->total_welfare_contributions ?? 0,
                $payment->attendance_penalty ?? 0,
                $payment->total_bonuses ?? 0,
                $payment->total_overtimes ?? 0,
                $payment->net_pay ?? 0,
                $payment->bank->name ?? '',
            ];
        });
    }
}
