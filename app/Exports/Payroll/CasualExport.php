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

class CasualExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting, WithStyles, WithTitle, ShouldAutoSize
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

        $casual = [];

        foreach ($payroll->monthlySalaries as $salary) {
            $employee = EmployeesDetail::find($salary->employees_detail_id);
            if ($employee->isCasualBetween(Carbon::parse($payroll->year . '-' . $payroll->month)->firstOfMonth(), Carbon::parse($payroll->year . '-' . $payroll->month)->lastOfMonth()) && $salary->net_pay > 0) {
                array_push($casual, $salary);
            }
        }

        return collect($casual)->sortByDesc('basic_salary_kes');
    }


    public function title(): string
    {
        return "Casual Payroll";
    }





    public function headings(): array
    {
        return [
            "#",
            "ID No.",
            "Full Name",
            "Department",
            "Designation",
            "No. of Days Worked",
            "Daily Rate",
            "Total Earnings",
            "NSSF",
            "NHIF",
            "NITA",
            "Affordable Housing Levy",
            "Advances",
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

    function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12],
            ],
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
            $row->daily_rate,
            $row->employee->daysWorked($row->payroll->year . '-' . $row->payroll->month) * $row->daily_rate,
            $row->nssf,
            $row->nhif,
            $row->nita,
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
            'T' => NumberFormat::FORMAT_TEXT,
            'U' => NumberFormat::FORMAT_TEXT,
        ];
    }
}
