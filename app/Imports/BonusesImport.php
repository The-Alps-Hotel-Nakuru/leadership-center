<?php

namespace App\Imports;

use App\Models\EmployeesDetail;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class BonusesImport implements ToCollection
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


