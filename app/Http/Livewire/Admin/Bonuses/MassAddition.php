<?php

namespace App\Http\Livewire\Admin\Bonuses;

use App\Imports\BonusesImport;
use App\Models\EmployeesDetail;
use App\Models\User;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\ValidationException;
use Livewire\WithFileUploads;

class MassAddition extends Component
{
    use WithFileUploads;
    public $employee_bonuses_file;
    public $bonuses = [];

    protected $rules = [
        'employee_bonuses_file' => 'required|mimes:xlsx,csv,txt',
    ];

    public function validateData()
    {
        $this->validate();

        $filePath = $this->employee_bonuses_file->store('excel_files');
        $import = new BonusesImport;
        Excel::import($import, $filePath);

        $values = $import->getData();

        $expectedFields = ["ID", "NATIONAL_ID", "FIRST_NAME", "LAST_NAME", "YEAR", "MONTH", "AMOUNT", "REASON"];
        // dd([$values[0]->toArray(), $expectedFields]);

        if ($values[0]->toArray() !== $expectedFields) {
            $this->addError('employee_bonuses_file', 'The Fields set are incorrect');
            return;
        }

        $this->reset('bonuses');

        for ($i = 2; $i < count($values); $i++) {
            array_push($this->bonuses, $values[$i]);
        }

        // dd($this->bonuses);
    }

    public function uploadBonuses()
    {
        foreach ($this->bonuses as $bonusData) {
            $employee = EmployeesDetail::where('national_id', $bonusData[1])->first();

            if ($employee) {
                $employee->bonuses()->create([
                    'year' => $bonusData[4],
                    'month' => $bonusData[5],
                    'amount_kes' => $bonusData[6],
                    'reason' => $bonusData[7],
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