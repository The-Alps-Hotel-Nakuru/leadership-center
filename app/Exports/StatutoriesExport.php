<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class StatutoriesExport implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
    public function sheets(): array
    {
        return [
            new ShifExport($this->id),
            new NssfExport($this->id),
            new HousingLevyExport($this->id),
            new PayeExport($this->id),
        ];
    }
}
