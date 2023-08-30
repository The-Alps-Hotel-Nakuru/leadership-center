<?php

namespace App\Exports;

use App\Models\EmployeesDetail;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class EmployeeNSSFExport implements WithHeadings, WithMapping, WithStyles, FromCollection, WithColumnFormatting
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $employeesNssfData = EmployeesDetail::with('user')->select('id', 'user_id', 'nssf','national_id', 'created_at')->where('nssf', '!=', null)->orderBy('id', 'asc')->get();
        return $employeesNssfData;
    }

    public function headings(): array
    {
        return ['ID', 'Employee National ID', 'Employee Name', 'NSSF Number', 'Registered On'];
    }

    public function map($row): array
    {
        $employeeName = $row->user ? $row->user->name : 'N/A';
        $employeeID = $row->national_id;
        $employeeeNssf = $row->nssf ? $row->nssf : 'N/A';
        $registeredDate = Carbon::parse($row->created_at)->format('jS F Y');

        return [
            $row->id . "",
            $employeeID . "",
            $employeeName . "",
            strval($employeeeNssf),
            $registeredDate . ""
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
            'D' => NumberFormat::FORMAT_TEXT,
        ];
    }
}
