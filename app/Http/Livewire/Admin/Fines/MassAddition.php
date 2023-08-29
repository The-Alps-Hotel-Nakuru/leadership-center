<?php

namespace App\Http\Livewire\Admin\Fines;

use App\Imports\FinesImport;
use App\Models\User;
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
        $expectedFields = ["ID", "NATIONAL_ID", "FIRST_NAME", "LAST_NAME", "YEAR", "MONTH", "AMOUNT", "REASON"];

        if ($actualFields !== $expectedFields) {
            $this->addError('employee_fines_file', 'The fields set are incorrect');
        }

        $this->fines = $import->getValues();
    }

    public function uploadFines()
    {
        foreach ($this->fines as $finesData) {
            $user = User::where('email', $finesData['EMAIL'])->first();

            if ($user) {
                $employee = $user->employee;
                if ($employee) {
                    $employee->fines()->create([
                        'year' => $finesData['YEAR'],
                        'month' => $finesData['MONTH'],
                        'reason' => $finesData['REASON'],
                        'amount_kes' => $finesData['AMOUNT'],
                    ]);
                }
            }
            $this->emit('done', [
                'success' => 'Successfully Added Fines To Employees'
            ]);
            $this->reset();
        }
    }

    public function render()
    {
        return view('livewire.admin.fines.mass-addition');
    }
}
