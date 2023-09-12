<?php

namespace App\Exports;

use App\Models\Bonus;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BonusesDataExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Bonus::all();
    }

    function map($row): array
    {
        return [
            $row->id,
            $row->employee->national_id,
            $row->employee->user->first_name,
            $row->employee->user->last_name,
            $row->year,
            $row->month,
            $row->amount_kes,
            $row->reason,

        ];
    }

    function headings(): array
    {

        $expectedFields = ["ID", "NATIONAL_ID", "FIRST_NAME", "LAST_NAME", "YEAR", "MONTH", "AMOUNT", "REASON"];

        return $expectedFields;
    }
}
