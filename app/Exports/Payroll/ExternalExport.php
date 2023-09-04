<?php

namespace App\Exports\Payroll;

use App\Models\EmployeesDetail;
use App\Models\Payroll;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExternalExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting, WithStyles, WithTitle, ShouldAutoSize
{
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $payroll = Payroll::find($this->id);

        $external = [];

        foreach ($payroll->monthlySalaries as $salary) {
            $employee = EmployeesDetail::find($salary->employees_detail_id);
            if ($employee->isExternalBetween(Carbon::parse($payroll->year . '-' . $payroll->month)->firstOfMonth(), Carbon::parse($payroll->year . '-' . $payroll->month)->lastOfMonth()) && $salary->basic_salary_kes > 0) {
                array_push($external, $salary);
            }
        }

        return collect($external)->sortByDesc('basic_salary_kes');
    }


    public function headings(): array
    {
        return [
            "#",                            //A
            "ID No.",                       //B
            "Full Name",                       //C
            "Department",                       //D
            "Designation",                       //E
            "Advance",                       //G
            "Bonuses",                       //H
            "Fines",                       //I
            "Loan Payment",                       //J
            "Staff Welfare",                       //K
            "Total Deductions",                       //L
            "Net Pay",                       //M
            "Bank",                       //N
            "A/c No."                       //O
        ];
    }

    function title(): string
    {
        return "External Employees Payroll";
    }



    function map($row): array
    {


        return [
            $row->id,
            $row->employee->national_id,
            $row->employee->user->name,
            $row->employee->designation->department->title,
            $row->employee->designation->title,
            $row->advances,
            $row->bonuses,
            $row->fines,
            0,
            $row->welfare_contributions,
            $row->total_deductions,
            $row->net_pay,
            $row->employee->bankAccount && $row->employee->bankAccount->bank ? $row->employee->bankAccount->bank->name : "",
            $row->employee->bankAccount && $row->employee->bankAccount->bank ? $row->employee->bankAccount->account_number : "",


        ];
    }

    function columnFormats(): array
    {
        $KES_FORMAT = '_("KES"* #,##0.00_);_("KES"* \(#,##0.00\);_("KES"* "-"??_);_(@_)';
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            'B' => NumberFormat::FORMAT_NUMBER,
            'C' => NumberFormat::FORMAT_TEXT,
            'D' => NumberFormat::FORMAT_TEXT,
            'E' => NumberFormat::FORMAT_TEXT,
            'F' => $KES_FORMAT,
            'G' => $KES_FORMAT,
            'H' => $KES_FORMAT,
            'I' => $KES_FORMAT,
            'J' => $KES_FORMAT,
            'K' => $KES_FORMAT,
            'L' => $KES_FORMAT,
            'M' => NumberFormat::FORMAT_TEXT,
            'N' => NumberFormat::FORMAT_TEXT,
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
}
