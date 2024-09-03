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
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Events\AfterSheet;

class BankingGuideExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithColumnFormatting, ShouldAutoSize, WithEvents
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
            $employee = EmployeesDetail::find($payment->employees_detail_id);
            $first = Carbon::parse($payroll->year . '-' . $payroll->month)->firstOfMonth();
            $last = Carbon::parse($payroll->year . '-' . $payroll->month)->lastOfMonth();
            if ($employee->ActiveContractBetween($first, $last) && $payment->net_pay > 0.1) {
                array_push($employees, $payment);
            }
        }

        return collect($employees)->sortByDesc('net_pay');
    }

    public function headings(): array
    {
        return [
            "Debit/From Account",
            "Your Branch BIC/SORT Code",
            "Beneficiary Name",
            "Bank",
            "Branch",
            "BIC/SORT Code (Mpesa 99999)",
            "Account No./Phone Number",
            "Net Pay/Amount"
        ];
    }

    function title(): string
    {
        return "Employees - KCB";
    }


    public function map($row): array
    {
        return [
            env('BANK_ACCOUNT_NUMBER'),
            env('BANK_SORT'),
            $row->employee->user->name,
            $row->employee->bankAccount && $row->employee->bankAccount->bank ? $row->employee->bankAccount->bank->short_name : '',
            'NAIROBI',
            $row->employee->bankAccount && $row->employee->bankAccount->bank ? $row->employee->bankAccount->bank->bank_code : '',
            $row->employee->bankAccount && $row->employee->bankAccount->bank ? $row->employee->bankAccount->account_number : '',
            $row->net_pay
        ];
    }

    function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            'B' => NumberFormat::FORMAT_TEXT,
            'C' => NumberFormat::FORMAT_TEXT,
            'D' => NumberFormat::FORMAT_TEXT,
            'E' => NumberFormat::FORMAT_TEXT,
            'F' => NumberFormat::FORMAT_TEXT,
            'G' => NumberFormat::FORMAT_TEXT,
            'H' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                /** @var Worksheet $sheet */
                $sheet = $event->sheet->getDelegate();

                // Get the highest column to determine the range
                $highestColumn = $sheet->getHighestColumn();
                $highestRow = $sheet->getHighestRow();

                // Copy the first row to the second row
                $sheet->insertNewRowBefore(1, 1);

                // Copy the values from the original first row to the new first row
                $sheet->fromArray(
                    $sheet->rangeToArray('A2:' . $highestColumn . '2'),  // Data from the original first row (now in the second row)
                    null,                                                  // Null values will be empty
                    'A1'                                                   // Destination for the copied data (new first row)
                );

                // Add a totals row at the bottom
                $totalRow = $highestRow + 2;  // Calculate where the totals row will be
                $newHighestRow = $highestRow + 1;
                // Set the label "Total" in the first column of the totals row
                $sheet->setCellValue('A' . $totalRow, 'Total');

                // Loop through each column starting from the second column to sum the values

                $sheet->setCellValue(
                    "{$highestColumn}{$totalRow}",
                    "=SUM({$highestColumn}3:{$highestColumn}{$newHighestRow})"  // Sum from the second row to the last row
                );

                // Optionally apply bold styling to the totals row
                $sheet->getStyle("A{$totalRow}:{$highestColumn}{$totalRow}")->getFont()->setBold(true)->setSize(13);

                // Optionally apply number formatting (if needed)
                $sheet->getStyle("B{$totalRow}:{$highestColumn}{$totalRow}")
                    ->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                for ($row = 1; $row <= $newHighestRow; $row++) {
                    for ($col = 'A'; $col <= $highestColumn; $col++) {
                        $cell = $sheet->getCell("{$col}{$row}");
                        if ($cell->isFormula()) {
                            $calculatedValue = $cell->getCalculatedValue();
                            $cell->setValue($calculatedValue);
                        }
                    }
                }
            },


        ];
    }
}
