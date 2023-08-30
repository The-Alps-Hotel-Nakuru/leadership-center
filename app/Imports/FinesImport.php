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
            $national_id = $rowData[1];
            // dd($national_id);
            $employee = EmployeesDetail::where('national_id', $national_id)->first();
            // dd($user);
            // dd($employee);
                if($employee){

                    $finesData= [
                        'ID' => $rowData[0],
                        'NATIONAL_ID' => $employee->national_id,
                        'FIRST_NAME' => $rowData[2],
                        'LAST_NAME' => $rowData[3],
                        'YEAR' => $rowData[4],
                        'MONTH' => $rowData[5],
                        'AMOUNT' => $rowData[6],
                        'REASON' => $rowData[7],
                    ];

                    $this->values[] = $finesData;
                    // dd($finesData);
                }
        }
    }
    
    public function getFields(){
        // dd($this->fields);
        return $this->fields;
        
    }

    public function getValues(){
        // dd($this->values);
        return $this->values;
        
    }
}
