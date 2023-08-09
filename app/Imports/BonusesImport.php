<?php

namespace App\Imports;

use App\Models\EmployeesDetail;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class BonusesImport implements ToCollection
{
    protected $fields = [];
    protected $values = [];

    public function collection(Collection $collection)
    {
        foreach ($collection as $key => $row) {
            $rowData = $row->toArray();
            if ($key === 0) {
                $this->fields = $rowData;
                continue;
            }

            $firstName = $rowData[1];
            $lastName = $rowData[2];

            $user = User::where('first_name', $firstName)->where('last_name', $lastName)->first();

            if ($user) {
                $employee = $user->employee;

                if ($employee) {
                    $bonusData = [
                        'ID' => $rowData[0],
                        'FIRST_NAME' => $rowData[1],
                        'LAST_NAME' => $rowData[2],
                        'YEAR' => $rowData[3],
                        'MONTH' => $rowData[4],
                        'AMOUNT' => $rowData[5],
                        'REASON' => $rowData[6],
                    ];

                    $this->values[] = $bonusData;
                }
            }
        }
    }

    public function getFields()
    {
        // dd($this->fields);
        return $this->fields;
    }

    public function getValues()
    {
        return $this->values;
    }
}


