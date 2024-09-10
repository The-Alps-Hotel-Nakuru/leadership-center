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
        return EmployeesDetail::where('exit_date', '=', null)->get();
    }

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

    public function map($row): array
    {
        return [
            $row->id,                   //A
            "",                         //B
            $row->national_id ?? "",    //C
            $row->user->name,           //D
            $row->user->email,          //E
            $row->gender,               //F
            $row->designation->title,   //G
            $row->phone_number,         //H
            (Carbon::parse($row->birth_date)->getTimestamp() / 86400) + 25569,  //I
            (Carbon::parse($row->created_at)->getTimestamp() / 86400) + 25569,  //J
            "Kenyan",                   //K
            $row->kra_pin ?? "",        //L
            $row->nssf ?? "",           //M
            $row->nhif ?? "",           //N
            $row->bankAccount->bank->short_name ?? "",    //O
            $row->bankAccount->account_number ?? "",      //P
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

    // private $showDropDown = true;

    public function columnFormats(): array
    {
        return [
            'H' => NumberFormat::FORMAT_TEXT,
            'I' => NumberFormat::FORMAT_DATE_DMYMINUS,
            'J' => NumberFormat::FORMAT_DATE_DMYMINUS,
            'O' => NumberFormat::FORMAT_TEXT,
            'P' => NumberFormat::FORMAT_TEXT,

        ];
    }
}
