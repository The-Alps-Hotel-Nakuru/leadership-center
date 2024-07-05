<?php

namespace App\Exports;

use App\Exports\Payroll\CasualExport;
use App\Exports\Payroll\ExternalExport;
use App\Exports\Payroll\FullTimeExport;
use App\Exports\Payroll\InternExport;
use App\Exports\Payroll\StudentAttacheeExport;
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
            new FullTimeExport($this->id),
            new InternExport($this->id),
            new ExternalExport($this->id),
            new StudentAttacheeExport($this->id),
        ];
    }


}
