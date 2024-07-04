<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class BiometricsImport implements ToCollection
{
    protected $data = [];

    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            $this->data[] = $row;
        }
    }

    public function getData()
    {
        // dd($this->fields);
        return $this->data;
    }
}
