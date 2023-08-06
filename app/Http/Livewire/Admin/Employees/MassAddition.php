<?php

namespace App\Http\Livewire\Admin\Employees;

use App\Imports\EmployeesImport;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class MassAddition extends Component
{

    use WithFileUploads;

    public $employeeFile;

    protected $rules = [
        'employeeFile' => 'required|mimes:xlsx,csv,txt'
    ];


    function checkData()
    {
        $this->validate();

        // Store the uploaded file
        $filePath = $this->employeeFile->store('excel_files');

        // Import and parse the Excel data
        $import = new EmployeesImport();
        Excel::import($import, $filePath);

        // Access the parsed data
        $data = $import->getData();

        // dd($data);

        $values = [];

        $fields = ["USERID", "Badgenumber", "NATIONAL_ID", "NAME", "EMAIL ADDRESS", "GENDER", "DESIGNATION", "PHONE NUMBER", "BIRTHDAY", "HIREDDAY", "NATIONALITY", "KRA PIN", "NSSF", "NHIF"];

        for ($i = 0; $i < count($fields); $i++) {
            if ($data[0][$i] != $fields[$i]) {
                throw ValidationException::withMessages([
                    'employeeFile' => ['The Fields set are incorrect']
                ]);
            }
        }

        foreach ($data as $item) {
            if (count($item) != 14) {
                throw ValidationException::withMessages([
                    'employeeFile' => ['This Document is not Valid']
                ]);
            }

            if ($item[0] != null) {
                array_push($values, [$item[0], $item[1], $item[2], $item[3], $item[4], $item[5], $item[6], $item[7], $item[8], $item[9], $item[10], $item[11], $item[12], $item[13]],);
            }
        }
        dd($values);

        // dd($test);

        for ($i = 1; $i < count($values); $i++) {

        }

        // if (count($this->productsList) == 0) {
        //     $this->emit('done', [
        //         'info' => 'There were no items that matched the system database'
        //     ]);
        // }
        // unlink($filePath);

    }

    public function render()
    {
        return view('livewire.admin.employees.mass-addition');
    }
}
