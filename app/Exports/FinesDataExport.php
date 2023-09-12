<?php

namespace App\Exports;

use App\Models\Fine;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FinesDataExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles,WithColumnFormatting
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Fine::all();
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
    function columnFormats(): array
    {
        $KES_FORMAT = '_("KES"* #,##0.00_);_("KES"* \(#,##0.00\);_("KES"* "-"??_);_(@_)';
        return [
            'A' => NumberFormat::FORMAT_NUMBER,
            'B' => NumberFormat::FORMAT_NUMBER,
            'C' => NumberFormat::FORMAT_TEXT,
            'D' => NumberFormat::FORMAT_TEXT,
            'E' => NumberFormat::FORMAT_NUMBER,
            'F' => NumberFormat::FORMAT_NUMBER,
            'G' => $KES_FORMAT,
            'H' => NumberFormat::FORMAT_TEXT,
            'I' => NumberFormat::FORMAT_TEXT,
        ];
    }
}
