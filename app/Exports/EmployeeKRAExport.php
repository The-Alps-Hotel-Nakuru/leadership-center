<?php

namespace App\Exports;

use App\Models\EmployeesDetail;
use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Reader\Xml\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat as StyleNumberFormat;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat\Wizard\Number;

class EmployeeKRAExport implements WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle, FromCollection, WithColumnFormatting
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $employeesKRAData = EmployeesDetail::with('user')->select('id', 'user_id', 'kra_pin', 'national_id','created_at')->where('kra_pin', '!=', null)->orderBy('id', 'asc')->get();
        return $employeesKRAData;
    }

    public function headings(): array
    {
        return ['ID', 'Employee National ID','Employee Name', 'KRA PIN', 'Registered On'];
    }

    public function title(): string
    {
        return "Employees KRA information";
    }

    public function map($row): array
    {
        $employeeName = $row->user ? $row->user->first_name . ' ' . $row->user->last_name : 'N/A';
        $employeeID = $row->national_id;
        $EmployeeKra = $row->kra_pin ? $row->kra_pin : 'N/A';
        $registeredDate = Carbon::parse($row->created_at)->format('jS F Y');
        return [
            $row->id. "",
            $employeeID. "",
            $employeeName. "",
            strval($EmployeeKra),
            $registeredDate. ""
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
            'A' => StyleNumberFormat::FORMAT_NUMBER,
            'B' => StyleNumberFormat::FORMAT_TEXT,
            'C' => StyleNumberFormat::FORMAT_TEXT,
            'D' => StyleNumberFormat::FORMAT_TEXT,
        ];
    }
}
