<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\EmployeesDetail;
use App\Models\Payroll;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PayrollExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting, WithTitle, WithStyles, ShouldAutoSize, WithEvents
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

        $salariesArray = [];

        foreach ($payroll->monthlySalaries as $salary) {
            if ($salary->gross_salary > 0) {
                array_push($salariesArray, $salary);
            }
        }
        $totals = [
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            $payroll->gross_salary_total,
            "",
            "",
            $payroll->nhif_total,
            "",
            "",
            "",
            $payroll->paye_total,
            $payroll->housing_levy_total,
            $payroll->nita_total,
            "",
            "",
            "",
            "",
            "",
            $payroll->overtimes_total,
            "",
            "",
            $payroll->net_pay_total,
        ];



        return collect($salariesArray)->sortByDesc('basic_salary_kes');
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
            "Days Worked",
            "Days on leave",
            "Earned Off Days",
            "Daily Rate",
            "Gross Salary",
            "NSSF Contribution",
            "Taxable Income (J-K)",
            "NHIF Premium",
            "Income Tax",
            "Insurance Relief (0.15*M)",
            "Tax Relief",
            "PAYE (N-(O+P))",
            "Affordable Housing Levy (0.015*J)",
            "NITA",
            "Salary Advances",
            "Fines",
            "Loan Payment",
            "Welfare Contributions",
            "Bonuses",
            "Extra Hours",
            "Total Deductions (K+M+Q+R+S+T+U+V+W)",
            "Total Additions (X+Y)",
            "Net Pay (J+AA-Z)",
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
            $row->employee->daysOnLeave($row->payroll->year . '-' . $row->payroll->month),
            $row->earned_off_days,
            $row->daily_rate,
            $row->gross_salary,
            $row->nssf,
            $row->taxable_income,
            $row->nhif,
            $row->income_tax,
            $row->general_relief,
            $row->tax_relief,
            $row->paye,
            $row->housing_levy,
            $row->nita,
            $row->advances,
            $row->fines,
            $row->loans,
            $row->welfare_contributions,
            $row->bonuses,
            $row->overtimes,
            $row->total_deductions,
            $row->total_additions,
            $row->net_pay,
            $row->employee->bankAccount && $row->employee->bankAccount->bank ? $row->employee->bankAccount->bank->name : "",
            $row->employee->bankAccount && $row->employee->bankAccount->bank ? $row->employee->bankAccount->account_number : "",


        ];
    }



    function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 13],
            ],

            // count(Payroll::find($this->id)->monthlySalaries) + 1 => [
            //     'font' => ['bold' => true, 'size' => 15]
            // ]
        ];
    }

    public function registerEvents(): array
    {
        $KES_FORMAT = '_("KES"* #,##0.00_);_("KES"* \(#,##0.00\);_("KES"* "-"??_);_(@_)';
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();

                // Calculate totals
                $sheet->setCellValue("A" . ($highestRow + 1), 'Total');
                $sheet->setCellValue("J" . ($highestRow + 1), '=SUM(J2:J' . $highestRow . ')');
                $sheet->setCellValue("M" . ($highestRow + 1), '=SUM(M2:M' . $highestRow . ')');
                $sheet->setCellValue("Q" . ($highestRow + 1), '=SUM(Q2:Q' . $highestRow . ')');
                $sheet->setCellValue("R" . ($highestRow + 1), '=SUM(R2:R' . $highestRow . ')');
                $sheet->setCellValue("S" . ($highestRow + 1), '=SUM(S2:S' . $highestRow . ')');
                $sheet->setCellValue("Y" . ($highestRow + 1), '=SUM(Y2:Y' . $highestRow . ')');
                $sheet->setCellValue("AB" . ($highestRow + 1), '=SUM(AB2:AB' . $highestRow . ')');
                // Repeat for other columns as needed

                // Apply styling (optional)
                $sheet->getStyle("A" . ($highestRow + 1) . ":{$highestColumn}" . ($highestRow + 1))->getFont()->setBold(true);
                $sheet->getStyle("A1:{$highestColumn}1")->applyFromArray([
                    'borders' => [
                        'bottom' => [
                            'borderStyle' => Border::BORDER_MEDIUM
                        ]
                    ],
                ]);
                $sheet->getStyle("A" . ($highestRow + 1) . ":{$highestColumn}" . ($highestRow + 1))->applyFromArray([
                    'borders' => [
                        'top' => [
                            'borderStyle' => Border::BORDER_MEDIUM,
                        ],
                        'bottom' => [
                            'borderStyle' => Border::BORDER_THICK
                        ]
                    ],
                ]);
                $sheet->getStyle("B" . ($highestRow + 1) . ":{$highestColumn}" . ($highestRow + 1))
                    ->getNumberFormat()
                    ->setFormatCode('_("KES"* #,##0.00_);_("KES"* \(#,##0.00\);_("KES"* "-"??_);_(@_)');
                // $sheet->
            },
        ];
    }
    function columnFormats(): array
    {
        $KES_FORMAT = '_("KES"* #,##0.00_);_("KES"* \(#,##0.00\);_("KES"* "-"??_);_(@_)';
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            'B' => NumberFormat::FORMAT_TEXT,
            'C' => NumberFormat::FORMAT_TEXT,
            'D' => NumberFormat::FORMAT_TEXT,
            'E' => NumberFormat::FORMAT_TEXT,
            'F' => NumberFormat::FORMAT_TEXT,
            'G' => NumberFormat::FORMAT_TEXT,
            'H' => NumberFormat::FORMAT_TEXT,
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
            'AA' => $KES_FORMAT,
            'AB' => $KES_FORMAT,
            'AC' => NumberFormat::FORMAT_TEXT,
            'AD' => NumberFormat::FORMAT_TEXT,
        ];
    }
}
