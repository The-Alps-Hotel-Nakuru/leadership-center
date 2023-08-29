<?php

namespace App\Exports;

use App\Models\EmployeesDetail;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EmployeesDataExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnFormatting
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return EmployeesDetail::all();
    }

    public function headings(): array
    {
        return [
            "USERID",
            "Badgenumber",
            "NATIONAL_ID",
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
            "NHIF"
        ];
    }

    public function map($row): array
    {
        return [
            $row->id,
            "",
            $row->national_id ?? "",
            $row->user->name,
            $row->user->email,
            $row->gender,
            $row->designation->title,
            $row->phone_number,
            (Carbon::parse($row->birth_date)->getTimestamp() / 86400) + 25569,
            (Carbon::parse($row->created_at)->getTimestamp() / 86400) + 25569,
            "Kenyan",
            $row->kra_pin ?? "",
            $row->nssf ?? "",
            $row->nhif ?? "",
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
