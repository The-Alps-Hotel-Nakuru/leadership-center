<?php

namespace App\Exports\ForceHRMS;

use App\Models\Payroll;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class Payrolls implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
{
    /**
     * @return string
     */
    public function title(): string
    {
        return 'Payrolls';
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'year',
            'month',
            'casual_gross',
            'full_time_gross',
            'intern_gross',
            'external_gross',
            'total_gross',
            'nssf_total',
            'nhif_total',
            'shif_total',
            'paye_total',
            'housing_levy_total',
            'nita_total',
            'net_pay_total',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Payroll::all()->map(function ($payroll) {
            return [
                $payroll->year ?? '',
                $payroll->month ?? '',
                $payroll->casual_gross ?? 0,
                $payroll->full_time_gross ?? 0,
                $payroll->intern_gross ?? 0,
                $payroll->external_gross ?? 0,
                $payroll->total ?? 0,
                $payroll->nssf_total ?? 0,
                $payroll->nhif_total ?? 0,
                $payroll->shif_total ?? 0,
                $payroll->paye_total ?? 0,
                $payroll->housing_levy_total ?? 0,
                $payroll->nita_total ?? 0,
                $payroll->net_pay_total ?? 0,
            ];
        });
    }
}
