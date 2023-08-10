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

            $email = $rowData[7];
            $user = User::where('email', $email)->first();

            if($user){
                $employee = $user->employee;
                if($employee){
                    $finesData= [
                        'ID' => $rowData[0],
                        'FIRST_NAME' => $rowData[1],
                        'LAST_NAME' => $rowData[2],
                        'YEAR' => $rowData[3],
                        'MONTH' => $rowData[4],
                        'AMOUNT' => $rowData[5],
                        'REASON' => $rowData[6],
                        'EMAIL' => $user->email,
                    ];

                    $this->values[] = $finesData;
                }
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
