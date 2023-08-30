<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Reader\Xml\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat as StyleNumberFormat;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat\NumberFormatter;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BonusesTemplateExport implements FromCollection, WithHeadings, ShouldAutoSize, WithTitle, WithColumnFormatting, WithStyles
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
        return "Bonuses Mass Addition";
    }
    public function headings(): array
    {
        $expectedFields = ["ID", "NATIONAL_ID", "FIRST_NAME", "LAST_NAME", "YEAR", "MONTH", "AMOUNT", "REASON"];

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
        $KES_FORMAT = '_("KES"* #,##0.00_);_("KES"* \(#,##0.00\);_("KES"* "-"??_);_(@_)';
        return [
            'A' => StyleNumberFormat::FORMAT_NUMBER,
            'B' => StyleNumberFormat::FORMAT_TEXT,
            'C' => StyleNumberFormat::FORMAT_TEXT,
            'D' => StyleNumberFormat::FORMAT_NUMBER,
            'E' => StyleNumberFormat::FORMAT_NUMBER,
            'F' => $KES_FORMAT,
            'G' => StyleNumberFormat::FORMAT_TEXT,
            'H' => StyleNumberFormat::FORMAT_TEXT,
        ];
    }

}
