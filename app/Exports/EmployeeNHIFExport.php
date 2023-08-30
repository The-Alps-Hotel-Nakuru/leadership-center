<?php

namespace App\Exports;

use App\Models\EmployeesDetail;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Reader\Xml\Style\NumberFormat as StyleNumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat\Wizard\Number;

class EmployeeNHIFExport implements WithHeadings, WithMapping, WithStyles,  FromCollection, WithColumnFormatting, WithTitle
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $employeesNhifData = EmployeesDetail::with('user')->select('id', 'user_id', 'nhif', 'national_id','created_at')->where('nhif', '!=', null)->orderBy('id', 'asc')->get();
        return $employeesNhifData;
    }

    public function headings(): array
    {
        return ['ID', 'Employee National ID',  'Employee Name', 'NHIF Number', 'Registered On'];
    }

    public function title(): string
    {
        return "Employees NHIF information";
    }

    public function map($row): array
    {
        $employeeName = $row->user ? $row->user->first_name . ' ' . $row->user->last_name : 'N/A';
        $employeeID = $row->national_id;
        $employeeNhif = $row->nhif ? $row->nhif : 'N/A';
        $registeredDate = Carbon::parse($row->created_at)->format('jS F Y');
        return [
            $row->id. "",
            $employeeID,
            $employeeName,
            strval($employeeNhif),
            $registeredDate
        ];
    }
    public function styles(Worksheet $sheet){
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12],
            ],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_NUMBER,
            'B' => NumberFormat::FORMAT_TEXT,
            'C' => NumberFormat::FORMAT_TEXT,
            'D' => NumberFormat::FORMAT_TEXT,
        ];
    }
}
