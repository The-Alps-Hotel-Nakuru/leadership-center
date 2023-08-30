<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Reader\Xml\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat as StyleNumberFormat;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat\Wizard\Number;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EmployeesBankAccountsTemplateExport implements FromCollection,  WithHeadings, ShouldAutoSize, WithTitle, WithColumnFormatting, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect([]);
    }

    public function title(): string
    {
        return "Bank Accounts Template";
    }

    public function headings(): array
    {
        $expectedFields = ["NAME", "BANK", "ACCOUNT NUMBER"];
        return $expectedFields;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12]
            ],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => StyleNumberFormat::FORMAT_TEXT,
            'B' => StyleNumberFormat::FORMAT_TEXT,
            'C' => StyleNumberFormat::FORMAT_NUMBER,
        ];
    }
}
