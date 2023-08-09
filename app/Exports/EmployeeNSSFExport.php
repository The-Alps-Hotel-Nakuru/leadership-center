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

class EmployeeNSSFExport implements WithHeadings, WithMapping, WithStyles, FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $employeesNssfData = EmployeesDetail::with('user')->select('id', 'user_id', 'nssf', 'created_at')->orderBy('id', 'asc')->get();
        return $employeesNssfData;
    }

    public function headings():array{
        return['ID', 'Employee Name', 'NSSF Number', 'Registered On'];
    }

    public function map($row): array{
        $emloyeeName = $row->user ? $row->user->first_name . ' ' . $row->user->last_name: 'N/A';
        $employeeeNssf = $row->nssf ? $row->nssf: 'N/A';
        $registeredDate = Carbon::parse($row->created_at)->format('jS F Y');

        return[
            $row->id,
            $emloyeeName,
            $employeeeNssf,
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
