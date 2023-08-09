<?php

namespace App\Http\Livewire\Admin\Bonuses;

use App\Imports\BonusesImport;
use App\Models\EmployeesDetail;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\WithFileUploads;

class MassAddition extends Component
{
    use WithFileUploads;
    public $employee_bonuses;
    public $bonuses = [];

    protected $rules = [
        'employee_bonuses' => 'required|mimes:xlsx,csv,txt',
    ];

    public function validateData()
    {
        $this->validate();

        $filePath = $this->employee_bonuses->store('excel_files');
        $import = new BonusesImport;
        Excel::import($import, $filePath);

        $actualFields = $import->getFields();

        dd($actualFields);
        $expectedFields = ["ID", "FIRST_NAME", "LAST_NAME", "YEAR", "MONTH", "AMOUNT", "REASON"];

        if ($actualFields !== $expectedFields) {
            $this->addError('employee_bonuses', 'The Fields set are incorrect');
            return;
        }

        $this->bonuses = $import->getValues();
    }

    public function import()
    {
        foreach ($this->bonuses as $bonusData) {
            $employee = EmployeesDetail::where('first_name', $bonusData['FIRST_NAME'])
                ->where('last_name', $bonusData['LAST_NAME'])->first();

            if ($employee) {
                $employee->bonuses()->create([
                    'year' => $bonusData['YEAR'],
                    'month' => $bonusData['MONTH'],
                    'reason' => $bonusData['REASON'],
                    'amount_kes' => $bonusData['AMOUNT'],
                ]);
            }
        }

        $this->emit('done', [
            'success' => 'Successfully Added Bonuses To Employees'
        ]);
        $this->reset();
    }

    public function render()
    {
        return view('livewire.admin.bonuses.mass-addition');
    }
}