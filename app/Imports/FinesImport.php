<?php

namespace App\Imports;

use App\Models\EmployeesDetail;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class FinesImport implements ToCollection
{
    /**
    * @param Collection $collection
    */

    public $fields = [];
    public $values = [];

    public function collection(Collection $collection)
    {
        foreach($collection as $key => $row){
            $rowData = $row->toArray();
            if($key === 0){
                $this->fields = $rowData;
                continue;
            }

            // $email = $rowData[7];
            // $user = User::where('email', $email)->first();
            $national_id = $rowData[7];
            // dd($nationalId);
            $employee = EmployeesDetail::where('national_id', $national_id)->first();
            // dd($user);

                if($employee){
                    $finesData= [
                        'ID' => $rowData[0],
                        'FIRST_NAME' => $rowData[1],
                        'LAST_NAME' => $rowData[2],
                        'YEAR' => $rowData[3],
                        'MONTH' => $rowData[4],
                        'AMOUNT' => $rowData[5],
                        'REASON' => $rowData[6],
                        // 'NATIONAL_ID' => $user->email,
                        'NATIONAL_ID' => $employee->national_id,
                    ];

                    $this->values[] = $finesData;
                    // dd($finesData);
                }
        }
    }
    
    public function getFields(){
        return $this->fields;
    }

    public function getValues(){
        return $this->values;
    }
}
