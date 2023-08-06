<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class EmployeesImport implements ToCollection
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


    // public function map($row): array
    // {
    //     // Perform any necessary mapping or transformation on each row
    //     return [
    //         'column1' => $row[0],
    //         'column2' => $row[1],
    //         // Add more columns as needed
    //     ];
    // }

    public function getData()
    {
        return $this->data;
    }
}
