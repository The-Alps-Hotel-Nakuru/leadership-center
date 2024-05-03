<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EmployeesDataTemplateExport implements WithHeadings, WithColumnFormatting, WithStyles
{

    public function headings(): array
    {
        return [
            "USERID",
            "Badgenumber",
            "NATIONAL ID",
            "NAME",
            "EMAIL ADDRESS",
            "GENDER",
            "DESIGNATION",
            "PHONE NUMBER",
            "BIRTHDAY",
            "HIREDDAY",
            "NATIONALITY",
            "KRA PIN",
            "NSSF",
            "NHIF",
            "BANK",
            "ACCOUNT NUMBER",
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12],
            ],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'H' => NumberFormat::FORMAT_TEXT,
            'I' => NumberFormat::FORMAT_DATE_DMYMINUS,
            'J' => NumberFormat::FORMAT_DATE_DMYMINUS,

        ];
    }
}
