<?php

namespace App\Exports;

use App\Models\Payroll;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PayeExport implements FromCollection, WithMapping, WithTitle, WithColumnFormatting, ShouldAutoSize
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
            $row->employee->kra_pin,
            $row->employee->user->name,
            "resident",
            "Primary Employee",
            $row->gross_salary,
            "0", //F
            "0", //G
            "0", //H
            "0", //I
            "0", //J
            "0", //K
            "0", //L
            "", //M
            "0", //N
            "0", //O
            "", //P
            "0", //Q
            "Benefit not given", //R
            "", //S
            "", //T
            "", //U
            "", //V
            "", //W
            $row->shif, //X
            $row->nssf, //Y
            "0", //Z
            "0", //AA
            $row->housing_levy, //AB
            "", //AC
            "", //AD
            "", //AE
            $row->tax_relief, //AF
            "0", //AG
            "", //AH
            $row->paye ?? "0", //AI

        ];
    }

    function title(): string
    {
        return "PAYE Breakdown";
    }

    function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            'B' => NumberFormat::FORMAT_TEXT,
            'C' => NumberFormat::FORMAT_TEXT,
            'D' => NumberFormat::FORMAT_TEXT,
            'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2,
            'R' => NumberFormat::FORMAT_TEXT,
            'Y' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2,
            'AB' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2,
            'AF' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2,
            'AG' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2,
            'AI' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2,
        ];
    }
}
