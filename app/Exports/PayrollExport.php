<?php

namespace App\Exports;

use App\Exports\Payroll\CasualExport;
use App\Exports\Payroll\FullTimeExport;
use App\Models\Payroll;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PayrollExport implements  WithMultipleSheets
{
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function sheets(): array
    {
        return [
            new CasualExport($this->id),
            new FullTimeExport($this->id)
        ];
    }


}
