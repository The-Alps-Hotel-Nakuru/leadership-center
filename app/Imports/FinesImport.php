<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class FinesImport implements ToCollection
{
    /**
     * @param Collection $collection
     */

    public $data = [];

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
