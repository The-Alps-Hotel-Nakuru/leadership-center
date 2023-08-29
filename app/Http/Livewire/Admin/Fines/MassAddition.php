<?php

namespace App\Http\Livewire\Admin\Fines;

use App\Imports\FinesImport;
use App\Models\EmployeesDetail;
use App\Models\Fine;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class MassAddition extends Component
{
    use WithFileUploads;
    public $employee_fines_file;
    public $fines = [];
    protected $rules = [
        'employee_fines_file' => 'required|mimes:xlsx,csv,txt'
    ];

    public function validateData()
    {

        $this->validate();
        $filePath = $this->employee_fines_file->store('excel_files');
        $import = new FinesImport;
        Excel::import($import, $filePath);

        $actualFields = $import->getFields();
        $expectedFields = ["ID", "FIRST_NAME", "LAST_NAME", "YEAR", "MONTH", "AMOUNT", "REASON", "NATIONAL_ID"];

        if ($actualFields !== $expectedFields) {
            $this->addError('employee_fines_file', 'The fields set are incorrect');
        }

        $this->fines = $import->getValues();
    }

    public function uploadFines()
    {
        $expectedFields = ["ID", "FIRST_NAME", "LAST_NAME", "YEAR", "MONTH", "AMOUNT", "REASON", "NATIONAL_ID"];

        foreach ($this->fines as $index => $finesData) {

            $rules = [];
            foreach ($expectedFields as $field) {
                $rules[$field] = 'required';
            }

            $validator = Validator::make($finesData, $rules);

            if ($validator->fails()) {
                $this->emit('warning', [
                    'message' => "Invalid data in record $index: " . implode(', ', $validator->errors()->all())
                ]);
                continue;
            }

            $employee = EmployeesDetail::where('national_id', $finesData['NATIONAL_ID'])->first();

            if ($employee) {

                $existingFine = Fine::where('employees_detail_id', $employee->id)
                    ->where('year', $finesData['YEAR'])
                    ->where('month', $finesData['MONTH'])
                    ->first();

                if (!$existingFine) {
                    Fine::create([
                        'employees_detail_id' => $employee->id,
                        'reason' => $finesData['REASON'],
                        'amount_kes' => $finesData['AMOUNT'],
                        'year' => $finesData['YEAR'],
                        'month' => $finesData['MONTH'],
                    ]);

                    $this->emit('success', [
                        'message' => "Fine added successfully for record $index"
                    ]);
                } else {

                    $this->emit('warning', [
                        'message' => "Duplicate record in record $index"
                    ]);
                }
            }
        }

        $this->emit('done', [
            'success' => 'Successfully Added Fines To Employees'
        ]);
        $this->reset();
    }


    public function render()
    {
        return view('livewire.admin.fines.mass-addition');
    }
}
