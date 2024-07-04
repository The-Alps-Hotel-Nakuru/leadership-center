<?php

namespace App\Http\Livewire\Admin\Biometrics;

use App\Imports\BiometricsImport;
use App\Models\EmployeesDetail;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class MassAddition extends Component
{
    use WithFileUploads;
    public $employee_biometrics_file;
    public $biometrics = [];

    protected $rules = [
        'employee_biometrics_file' => 'required|mimes:xlsx,csv,txt',
    ];

    public function validateData()
    {
        $this->validate();

        $filePath = $this->employee_biometrics_file->store('excel_files');
        $import = new BiometricsImport;
        Excel::import($import, $filePath);

        $values = $import->getData();

        $expectedFields = ["ID", "NATIONAL_ID", "BIOMETRIC_ID"];
        // dd([$values[0]->toArray(), $expectedFields]);

        if ($values[0]->toArray() !== $expectedFields) {
            $this->addError('employee_biometrics_file', 'The Fields set are incorrect');
            return;
        }


        $this->reset('biometrics');

        for ($i = 1; $i < count($values); $i++) {
            array_push($this->biometrics, $values[$i]);
        }

        // dd($this->biometrics);
    }

    public function uploadBiometrics()
    {
        $count = 0;
        $amount = 0;
        foreach ($this->biometrics as $bonusData) {
            $employee = EmployeesDetail::where('national_id', $bonusData[1])->first();

            if ($employee) {
                $employee->biometrics()->create([
                    'biometric_id' => $bonusData[2],
                ]);
                $count++;
                $amount += $bonusData[6];
            }
        }

        $this->emit('done', [
            'success' => 'Successfully Added ' . $count . ' biometrics records To Employees Amounting to KES ' . number_format($amount, 2)
        ]);
        $this->reset();
    }
    public function render()
    {
        return view('livewire.admin.biometrics.mass-addition');
    }
}
