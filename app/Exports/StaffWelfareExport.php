<?php

namespace App\Exports;

use App\Models\WelfareContribution;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StaffWelfareExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return WelfareContribution::all();
    }

    function map($row): array
    {
        return [
            $row->id,
            $row->employee->national_id,
            $row->employee->user->first_name,
            $row->employee->user->last_name,
            $row->year,
            $row->month,
            $row->amount_kes,
            $row->reason,
            $row->employee->user->email,

        ];
    }

    function headings(): array
    {

        $expectedFields = ["ID", "NATIONAL_ID", "FIRST_NAME", "LAST_NAME", "YEAR", "MONTH", "AMOUNT", "REASON"];

        return $expectedFields;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12],
            ],
        ];
    }
}
