<?php

namespace App\Exports\FullDataExport;

use Maatwebsite\Excel\Concerns\FromCollection;

class Contracts implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
    }
}
