<?php

namespace App\Exports;

use App\Models\Payroll;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithFormatData;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

// use PhpOffice\PhpSpreadsheet\Reader\Xml\Style\NumberFormat;

class NssfExport implements FromCollection, WithHeadings,WithMapping,WithTitle,ShouldAutoSize,WithColumnFormatting
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
            "SURNAME",
            "OTHER NAMES",
            "ID NO",
            "KRA PIN",
            "NSSF NO",
            "GROSS PAY",
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
            $row->employee->nssf,
            $row->gross_salary,

        ];
    }

    function title(): string {
        return "NSSF Payment";
    }

    function columnFormats(): array
    {
        return [
            'G' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2
        ];
    }
}
