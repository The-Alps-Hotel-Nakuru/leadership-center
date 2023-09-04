<?php

namespace App\Exports;

use App\Exports\BankingGuide\CasualExport;
use App\Exports\BankingGuide\OtherExport;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class BankingGuideExport implements WithMultipleSheets
{
    public $id;

    function __construct($id)
    {
        $this->id = $id;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function sheets(): array
    {
        return [
            new OtherExport($this->id),
            new CasualExport($this->id),
        ];
    }


}
