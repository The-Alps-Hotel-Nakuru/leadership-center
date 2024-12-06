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

class ShifExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting, WithTitle, ShouldAutoSize
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
            if ($payment->gross_salary > 0) {
                array_push($paymentsArray, $payment);
            }
        }




        return collect($paymentsArray)->sortByDesc('gross_salary');
    }

    public function headings(): array
    {
        return [
            "PAYROLL NUMBER",
            "FIRSTNAME",
            "LASTNAME",
            "ID NO",
            "KRA PIN",
            "NHIF NO",
            "CONTRIBUTION AMOUNT",
            "PHONE"

        ];
    }


    public function map($row): array
    {
        return [
            $row->id,
            $row->employee->user->last_name,
            $row->employee->user->first_name,
            $row->employee->national_id,
            $row->employee->kra_pin,
            $row->employee->nhif,
            $row->shif,
            $row->employee->phone_number,

        ];
    }

    function title(): string
    {
        return "SHA Payment";
    }

    function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_TEXT,
            'G' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2,
            'H' => NumberFormat::FORMAT_TEXT,
        ];
    }
}
