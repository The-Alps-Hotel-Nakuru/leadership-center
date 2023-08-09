<?php

namespace App\Exports;

use App\Models\EmployeesDetail;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Font;


class EmployeeNHIFExport implements WithHeadings, WithMapping, WithStyles,  FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $employeesNhifData = EmployeesDetail::with('user')->select('id', 'user_id', 'nhif', 'created_at')->orderBy('id', 'asc')->get();
        return $employeesNhifData;
    }

    public function headings(): array
    {
        return ['ID', 'Employee Name', 'NHIF Number', 'Registered On'];
    }

    public function map($row): array
    {
        $employeeName = $row->user ? $row->user->first_name . ' ' . $row->user->last_name : 'N/A';
        $employeeNhif = $row->nhif ? $row->nhif : 'N/A';
        $registeredDate = Carbon::parse($row->created_at)->format('jS F Y');
        return [
            $row->id,
            $employeeName,
            $employeeNhif,
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
}
