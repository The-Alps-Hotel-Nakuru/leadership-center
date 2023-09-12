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
<<<<<<< HEAD
        foreach ($collection as $key => $row) {
            $rowData = $row->toArray();
            if ($key === 0) {
                $this->fields = $rowData;
                continue;
            }

            // $firstName = $rowData[1];
            // $lastName = $rowData[2];
            // $user = User::where('first_name', $firstName)->where('last_name', $lastName)->first();


            // $phoneNumber = $rowData[7];
            // $user = EmployeesDetail::where('phone_number', $phoneNumber)->first();

            $national_id = $rowData[1];
            // dd($email);
            // $user = User::where('national_id', $national_id)->first();
            $employee = EmployeesDetail::where('national_id', $national_id)->first();

            // dd(DB::getQueryLog());

            // dd($user);

            // if ($user) {
                // $employee = $user->employee;

                if ($employee) {
                    $bonusData = [
                        'ID' => $rowData[0],
                        'NATIONAL_ID' => $employee->national_id,
                        'FIRST_NAME' => $rowData[2],
                        'LAST_NAME' => $rowData[3],
                        'YEAR' => $rowData[4],
                        'MONTH' => $rowData[5],
                        'AMOUNT' => $rowData[6],
                        'REASON' => $rowData[7],
                        // 'EMAIL' => $rowData[7],

                    ];

                    $this->values[] = $bonusData;

                    // dd($bonusData);
                }
            // }
=======
        foreach ($collection as $row) {
            $this->data[] = $row;
>>>>>>> master
        }
    }

    public function getData()
    {
        // dd($this->fields);
        return $this->data;
    }

}


