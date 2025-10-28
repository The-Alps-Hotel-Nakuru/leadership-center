<?php

namespace App\Exports\ForceHRMS;

use App\Models\PayrollPayment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

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
            'ID',
            'Payroll ID',
            'Employee Detail ID',
            'Employee Email',
            'Payroll Year',
            'Payroll Month',
            'Gross Salary',
            'NSSF',
            'NHIF',
            'PAYE',
            'Housing Levy',
            'Total Fines',
            'Total Advances',
            'Total Bonuses',
            'Total Welfare Contributions',
            'Bank Name',
            'Account Number',
            'Created At',
            'Updated At',
            'Total Loans',
            'NITA',
            'Total Overtimes',
            'SHIF',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return PayrollPayment::with(['employee.user', 'payroll', 'bank'])->get()->map(function ($payment) {
            return [
                $payment->id ?? '',
                $payment->payroll_id ?? '',
                $payment->employees_detail_id ?? '',
                $payment->employee->user->email ?? '',
                $payment->payroll->year ?? '',
                $payment->payroll->month ?? '',
                $payment->gross_salary ?? 0,
                $payment->nssf ?? 0,
                $payment->nhif ?? 0,
                $payment->paye ?? 0,
                $payment->housing_levy ?? 0,
                $payment->total_fines ?? 0,
                $payment->total_advances ?? 0,
                $payment->total_bonuses ?? 0,
                $payment->total_welfare_contributions ?? 0,
                $payment->bank->name ?? '',
                $payment->account_number ?? '',
                $payment->created_at ?? '',
                $payment->updated_at ?? '',
                $payment->total_loans ?? 0,
                $payment->nita ?? 0,
                $payment->total_overtimes ?? 0,
                $payment->shif ?? 0,
            ];
        });
    }
}
