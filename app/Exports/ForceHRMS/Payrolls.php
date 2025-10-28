<?php

namespace App\Exports\ForceHRMS;

use App\Models\Payroll;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

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
            'Year',
            'Month',
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
            ];
        });
    }
}
