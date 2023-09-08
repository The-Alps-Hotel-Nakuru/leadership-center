<?php

namespace App\Exports;

use App\Exports\Payroll\CasualExport;
use App\Exports\Payroll\FullTimeExport;
use App\Exports\Payroll\InternExport;
use App\Models\Payroll;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;

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
            new FullTimeExport($this->id),
            new InternExport($this->id),
        ];
    }


}
