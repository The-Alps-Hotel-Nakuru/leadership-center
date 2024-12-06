<?php

namespace App\Exports;

use App\Models\Payroll;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class HousingLevyExport implements FromCollection, WithMapping, WithTitle, WithColumnFormatting, ShouldAutoSize
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

        $paymentsArray = [];

        foreach ($payroll->payments as $payment) {
            if ($payment->gross_salary > 0 && $payment->monthlySalary()->is_taxable) {
                array_push($paymentsArray, $payment);
            }
        }




        return collect($paymentsArray)->sortByDesc('gross_salary');
    }




    public function map($row): array
    {
        return [
            $row->employee->national_id,
            $row->employee->user->name,
            $row->employee->kra_pin,
            $row->gross_salary,
        ];
    }

    function title(): string
    {
        return "Housing Levy Payment";
    }

    function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            'B' => NumberFormat::FORMAT_TEXT,
            'C' => NumberFormat::FORMAT_TEXT,
            'D' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2,
        ];
    }
}
