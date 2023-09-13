<?php

namespace App\Http\Livewire\Admin\Fines;

use App\Imports\FinesImport;
use App\Models\EmployeesDetail;
use App\Models\Log;
use App\Models\User;
use Illuminate\Validation\ValidationException;
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

        $data = $import->getData();
        $values = [];
        $expectedFields = ["ID", "NATIONAL_ID", "FIRST_NAME", "LAST_NAME", "YEAR", "MONTH", "AMOUNT", "REASON"];


        for ($i = 0; $i < count($expectedFields); $i++) {
            if ($data[0][$i] != $expectedFields[$i]) {
                throw ValidationException::withMessages([
                    'employee_fines_file' => ['The Fields set are incorrect']
                ]);
            }
        }
        foreach ($data as $item) {
            if ($item[0] != null) {
                array_push($values, [$item[0], $item[1], $item[2], $item[3], $item[4], $item[5], $item[6], $item[7]]);
            }
        }

        $this->reset('fines');

        for ($i = 1; $i < count($values); $i++) {
            $employee = EmployeesDetail::where('national_id', $values[$i][1]);
            if ($employee->exists()) {
                # code...
                array_push($this->fines, $values[$i]);
            }
            // array_push($this->fines, $values[$i]);
        }

        // dd($this->fines);
    }

    public function uploadFines()
    {
        $count = 0;
        $amount = 0;
        foreach ($this->fines as $finesData) {
            $employee = EmployeesDetail::where('national_id', $finesData[1])->first();
            if ($employee) {
                $employee->fines()->create([
                    'year' => $finesData[4],
                    'month' => $finesData[5],
                    'amount_kes' => $finesData[6],
                    'reason' => $finesData[7],
                ]);
                $count++;
                $amount += $finesData[6];
            }
            $this->emit('done', [
                'success' => 'Successfully Added ' . $count . ' Fines To Employees Amounting to KES ' . number_format($amount, 2)
            ]);
            $this->reset();
        }

        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\Fine';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has created fines to <strong> " . $count . " employees</strong> in the system through mass addition";
        $log->save();
    }

    public function render()
    {
        return view('livewire.admin.fines.mass-addition');
    }
}
