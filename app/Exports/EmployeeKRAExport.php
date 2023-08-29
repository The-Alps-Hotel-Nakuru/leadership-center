<?php

namespace App\Exports;

use App\Models\EmployeesDetail;
use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Font;

class EmployeeKRAExport implements WithHeadings, WithMapping, WithStyles, FromCollection
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
        return ['ID', 'Employee Name', 'KRA PIN', 'Registered On'];
    }

    public function map($row): array
    {
        $employeeName = $row->user ? $row->user->first_name . ' ' . $row->user->last_name : 'N/A';
        $EmployeeKra = $row->kra_pin ? $row->kra_pin : 'N/A';
        $registeredDate = Carbon::parse($row->created_at)->format('jS F Y');
        return [
            $row->id,
            $employeeName,
            $EmployeeKra,
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
