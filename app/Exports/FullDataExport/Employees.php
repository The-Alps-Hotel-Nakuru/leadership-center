<?php

namespace App\Exports\FullDataExport;

use App\Models\EmployeesDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Employees implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnFormatting
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
        $fields = [
            "NATIONAL ID",
            "FULL NAME",
            "EMAIL ADDRESS",
            "PHONE NUMBER",
            "GENDER",
            "DATE OF BIRTH",
            "MARITAL STATUS",
            "KRA PIN",
            "NSSF NUMBER",
            "NHIF NUMBER",
            "DESIGNATION",
            "COUNTY",
            "CITY",
            "BANK",
            "ACCOUNT NUMBER",
            "NEXT OF KIN NAME",
            "NEXT OF KIN RELATIONSHIP",
            "NEXT OF KIN PHONE",
            "RECRUITMENT DATE",
        ];
        return $fields;
    }

    public function map($row): array
    {
        return [
            $row->national_id,
            $row->user->name,
            $row->user->email,
            $row->phone_number,
            $row->gender,
            $row->date_of_birth,
            $row->marital_status,
            $row->kra_pin,
            $row->nssf_number,
            $row->nhif_number,
            $row->designation->title ?? '',
            $row->county??'',
            $row->city,
            $row->bankAccount->bank->short_name ?? '',
            $row->bankAccount->account_number ?? '',
            $row->next_of_kin_name ?? '',
            $row->next_of_kin_relationship ?? '',
            $row->next_of_kin_phone ?? '',
            $row->recruitment_date ?? '',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12],
            ],
        ];
    }

    // private $showDropDown = true;

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            'B' => NumberFormat::FORMAT_TEXT,
            'C' => NumberFormat::FORMAT_TEXT,
            'D' => NumberFormat::FORMAT_TEXT,
            'E' => NumberFormat::FORMAT_TEXT,
            'F' => NumberFormat::FORMAT_DATE_DMYMINUS,
            'G' => NumberFormat::FORMAT_TEXT,
            'H' => NumberFormat::FORMAT_TEXT,
            'I' => NumberFormat::FORMAT_TEXT,
            'J' => NumberFormat::FORMAT_TEXT,
            'K' => NumberFormat::FORMAT_TEXT,
            'L' => NumberFormat::FORMAT_TEXT,
            'M' => NumberFormat::FORMAT_TEXT,
            'N' => NumberFormat::FORMAT_TEXT,
            'O' => NumberFormat::FORMAT_TEXT,
            'P' => NumberFormat::FORMAT_TEXT,
            'Q' => NumberFormat::FORMAT_TEXT,
            'R' => NumberFormat::FORMAT_TEXT,
            'S' => NumberFormat::FORMAT_DATE_DMYMINUS,

        ];
    }
}
