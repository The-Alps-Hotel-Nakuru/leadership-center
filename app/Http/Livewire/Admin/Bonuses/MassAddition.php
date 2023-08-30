<?php

namespace App\Http\Livewire\Admin\Bonuses;

use App\Exports\BonusesTemplateExport;
use App\Imports\BonusesImport;
use App\Models\EmployeesDetail;
use App\Models\Log;
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

    // public function logs()
    // {
    //     $log = new Log();
    //     $log->user_id = auth()->user();
    //     $log->model = 'App\Models\EmployeesDetail';
    //     $log->payload = "<strong>" . auth()->user()->name . "</strong> has downloaded <strong> " . 'Bonuses Template' . "</strong> from the system";
    //     $log->save();
    // }

    //exports the template for mass addition of employee bonuses
    public function downloadTemplate(){
        return Excel::download(new BonusesTemplateExport, 'employee_bonuses_file.xlsx');
    }

    public function validateData()
    {
        $this->validate();

        $filePath = $this->employee_bonuses_file->store('excel_files');
        $import = new BonusesImport;
        Excel::import($import, $filePath);

        $actualFields = $import->getFields();


        $expectedFields = ["ID", "NATIONAL_ID", "FIRST_NAME", "LAST_NAME", "YEAR", "MONTH", "AMOUNT", "REASON"];
        // dd($expectedFields);

        if ($actualFields !== $expectedFields) {
            $this->addError('employee_bonuses_file', 'The Fields set are incorrect');
            return;
        }

        $this->bonuses = $import->getValues();

        // dd($this->bonuses);
    }

    public function uploadBonuses()
    {
        foreach ($this->bonuses as $bonusData) {
            // $user = User::where('email', $bonusData['EMAIL'])->first();
            $employee = EmployeesDetail::where('national_id', $bonusData['NATIONAL_ID'])->first();

            // if ($user) {
                // $employee = $user->employee;
                if($employee){
                    $employee->bonuses()->create([
                        'year' => $bonusData['YEAR'],
                        'month' => $bonusData['MONTH'],
                        'reason' => $bonusData['REASON'],
                        'amount_kes' => $bonusData['AMOUNT'],
                    ]);
                // }
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
