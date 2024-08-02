<?php

namespace App\Exports\Payroll;

use App\Models\EmployeesDetail;
use App\Models\Payroll;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FullTimeExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting, WithTitle, WithStyles, ShouldAutoSize
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

        $full_time = [];

        foreach ($payroll->monthlySalaries as $salary) {
            $employee = EmployeesDetail::find($salary->employees_detail_id);
            if ($employee->isFullTimeBetween(Carbon::parse($payroll->year . '-' . $payroll->month)->firstOfMonth(), Carbon::parse($payroll->year . '-' . $payroll->month)->lastOfMonth()) && $salary->net_pay > 0) {
                array_push($full_time, $salary);
            }
        }

        return collect($full_time)->sortByDesc('basic_salary_kes');
    }


    public function title(): string
    {
        return "Full Time Payroll";
    }


    public function headings(): array
    {
        return [
            "#",
            "ID No.",
            "Full Name",
            "Department",
            "Designation",
            "Number of Days Worked",
            "Gross Salary",
            "NSSF Contribution",
            "Taxable Income",
            "NHIF Premium",
            "Income Tax",
            "Tax Relief",
            "Insurance Relief",
            "Gross PAYE",
            "Attendance Penalty",
            "PAYE Rebate",
            "NET PAYE",
            "Housing Levy",
            "Advance",
            "Bonuses",
            "Fines",
            "Loan Payment",
            "Staff Welfare",
            "Total Additions",
            "Total Deductions",
            "Net Pay",
            "Bank",
            "A/c No."
        ];
    }

    function map($row): array
    {
        return [
            $row->id,
            $row->employee->national_id,
            $row->employee->user->name,
            $row->employee->designation->department->title,
            $row->employee->designation->title,
            $row->employee->daysWorked($row->payroll->year . '-' . $row->payroll->month),
            $row->gross_salary,
            $row->nssf,
            $row->taxable_income,
            $row->nhif,
            $row->income_tax,
            $row->tax_relief,
            $row->general_relief,
            $row->paye,
            $row->attendance_penalty,
            $row->rebate,
            $row->net_paye,
            $row->housing_levy,
            $row->advances,
            $row->bonuses,
            $row->fines,
            $row->loans,
            $row->welfare_contributions,
            $row->total_additions,
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
            'F' => NumberFormat::FORMAT_NUMBER,
            'G' => $KES_FORMAT,
            'H' => $KES_FORMAT,
            'I' => $KES_FORMAT,
            'J' => $KES_FORMAT,
            'K' => $KES_FORMAT,
            'L' => $KES_FORMAT,
            'M' => $KES_FORMAT,
            'N' => $KES_FORMAT,
            'O' => $KES_FORMAT,
            'P' => $KES_FORMAT,
            'Q' => $KES_FORMAT,
            'R' => $KES_FORMAT,
            'S' => $KES_FORMAT,
            'T' => $KES_FORMAT,
            'U' => $KES_FORMAT,
            'V' => $KES_FORMAT,
            'W' => $KES_FORMAT,
            'X' => $KES_FORMAT,
            'Y' => $KES_FORMAT,
            'Z' => $KES_FORMAT,
            'AA' => NumberFormat::FORMAT_TEXT,
            'AB' => NumberFormat::FORMAT_TEXT,
        ];
    }

    function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 13],
            ],
        ];
    }
}
