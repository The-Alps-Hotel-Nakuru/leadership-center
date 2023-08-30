<?php

namespace App\Exports;

use App\Models\EmployeeAccount;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Symfony\Component\CssSelector\Node\FunctionNode;

class EmployeesAccountsExport implements FromCollection, WithHeadings, WithStyles, WithColumnFormatting, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $employeesBankDetails = EmployeeAccount::with('employee')->select('id', 'employees_detail_id', 'bank_id', 'account_number', 'created_at')->where('account_number', '!=', null)->orderBy('id', 'asc')->get();
        return $employeesBankDetails;
    }

    public function headings(): array
    {
        return [
            "USERID",
            "NAME",
            "BANK NAME",
            "ACCOUNT NUMBER"
        ];
    }
    public function map($row): array
    {
        $employeeName = $row->employee ? $row->employee->user->first_name . ' ' . $row->employee->user->last_name : 'N/A';
        $employeeBank = $row->bank->name ? $row->bank->name : 'N/A';
        return [
            $row->id,
            $employeeName,
            $employeeBank,
            $row->account_number,
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
            'A' => NumberFormat::FORMAT_NUMBER,
            'B' => NumberFormat::FORMAT_TEXT,
            'C' => NumberFormat::FORMAT_TEXT,
            'D' => NumberFormat::FORMAT_TEXT,
        ];
    }
}
