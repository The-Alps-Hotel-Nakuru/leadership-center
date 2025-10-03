<?php

namespace App\Exports;

use App\Models\EmployeesDetail;
use App\Models\Payroll;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class AbsaBankingGuideExport implements FromCollection, WithMapping, WithTitle, ShouldAutoSize, WithEvents, WithColumnFormatting
{
    public $id;

    function __construct($id)
    {
        $this->id = $id;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $payroll = Payroll::find($this->id);

        $employees = [];

        foreach ($payroll->payments as $payment) {
            // $employee = EmployeesDetail::find($payment->employees_detail_id);
            if ($payment->net_pay > 10) {
                array_push($employees, $payment);
            }
        }

        return collect($employees)->sortByDesc('net_pay');
    }

    function title(): string
    {
        return "Employees - ABSA";
    }

    function map($row): array
    {

        return [
            "3",
            $row->employee->bankAccount && $row->employee->bankAccount->bank ? $row->employee->bankAccount->account_number : '',
            $row->employee->bankAccount && $row->employee->bankAccount->bank ? $row->employee->bankAccount->bank->bank_code : '',
            "",
            Carbon::now()->format("dmY"),
            "KES",
            $row->net_pay,
            $row->employee->user->name,
            "",
            "",
            "KEN",
            strtoupper(Carbon::parse($row->payroll->year . '-' . $row->payroll->month)->format("M y") . " SALARY"),
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "KEN",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",

        ];
    }

    function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            'B' => NumberFormat::FORMAT_TEXT,
            'D' => NumberFormat::FORMAT_TEXT,
            'E' => NumberFormat::FORMAT_TEXT,
            'F' => NumberFormat::FORMAT_TEXT,
            'G' => NumberFormat::FORMAT_NUMBER_00,
            'H' => NumberFormat::FORMAT_TEXT,
            'I' => NumberFormat::FORMAT_TEXT,
            'J' => NumberFormat::FORMAT_TEXT,
            'K' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'L' => NumberFormat::FORMAT_TEXT,
        ];
    }

    function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                /** @var Worksheet $sheet */

                $sheet = $event->sheet->getDelegate();
                $payroll = Payroll::find($this->id);

                $highestColumn = $sheet->getHighestColumn();
                $highestRow = $sheet->getHighestRow();
                $totalRow = $highestRow + 1;
                $sheet->setCellValue(
                    "C{$totalRow}",
                    "=SUM(G1:G{$highestRow})"  // Sum from the second row to the last row
                );
                $sheet->setCellValue(
                    "B{$totalRow}",
                    "=ROW()"  // Sum from the second row to the last row
                );
                $sheet->setCellValue(
                    "A{$totalRow}",
                    "9"  // Sum from the second row to the last row
                );

                $sheet->insertNewRowBefore(1, 1);

                $sheet->setCellValue('A1', '2');
                $sheet->setCellValue('B1', env('BANK_ACCOUNT_NUMBER'));
                // Extract the first 2 digits
                $firstPart = substr(env('BANK_SORT'), 0, 2);
                $sheet->setCellValue('C1', "" . $firstPart);

                // Extract the remaining 3 digits
                $secondPart = substr(env('BANK_SORT'), 2);
                $sheet->setCellValue('D1', "" . $secondPart);
                $sheet->setCellValue('E1', "KES");
                $sheet->setCellValue('F1', strtoupper(Carbon::parse($payroll->year . '-' . $payroll->month)->format("M y") . " SALARY"));
                $sheet->setCellValue('G1', "SALARYPAYT");
                $sheet->setCellValue('H1', "=SUM(G2:G{$totalRow})");
                $sheet->setCellValue('J1', "KEN");


                $sheet->insertNewRowBefore(1, 1);
                $sheet->setCellValue('A1', '1');
                $sheet->setCellValue('B1', 'LOCAL');

                $sheet->insertNewRowBefore(1, 1);
                $sheet->setCellValue('A1', '0');
                $sheet->setCellValue('B1', Carbon::now()->format("dmY"));
                $sheet->setCellValue('C1', Carbon::now()->format("His"));
                $sheet->setCellValue('E1', "C");

                $sheet->getStyle('A1:' . $highestColumn . $highestRow + 2)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            }
        ];
    }
}
