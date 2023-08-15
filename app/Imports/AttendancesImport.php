<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class AttendancesImport implements ToCollection
{
    protected $data = [];

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            $this->data[] = $row;
        }
    }

    public function getData()
    {
        return $this->data;
    }
}
