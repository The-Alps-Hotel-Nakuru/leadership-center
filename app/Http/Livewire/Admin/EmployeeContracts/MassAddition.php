<?php

namespace App\Http\Livewire\Admin\EmployeeContracts;

use App\Imports\ContractsImport;
use App\Models\EmployeeContract;
use App\Models\EmployeesDetail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class MassAddition extends Component
{
    use WithFileUploads;

    public $contractsFile;
    // public $contracts = [];
    public $validContracts = [];
    public $invalidContracts = [];
    public $alreadyExisting = [];

    protected $rules = [
        'contractsFile' => 'required|mimes:xlsx,csv,txt'
    ];

    function checkData()
    {
        $this->validate();
        $this->reset(['validContracts', 'invalidContracts', 'alreadyExisting']);
        // Store the uploaded file
        $filePath = $this->contractsFile->store('excel_files');

        // Import and parse the Excel data
        $import = new ContractsImport();
        Excel::import($import, $filePath);

        // Access the parsed data
        $data = $import->getData();

        // dd($data);

        $values = [];

        $fields = ["NAME", "TYPE ID", "START DATE", "END DATE", "SALARY"];

        for ($i = 0; $i < count($fields); $i++) {
            if ($data[0][$i] != $fields[$i]) {
                throw ValidationException::withMessages([
                    'contractsFile' => ['The Fields set are incorrect']
                ]);
            }
        }

        foreach ($data as $key => $item) {
            if ($item[0] != null) {
                if ($key == 0) {
                    array_push($values, [$item[0], $item[1], $item[2], $item[3], $item[4]]);
                    continue;
                }
                array_push($values, [$item[0], $item[1], Carbon::parse(($item[2] - 25569) * 86400)->getTimestamp(), Carbon::parse(($item[3] - 25569) * 86400)->getTimestamp(), $item[4]]);

                // Name, TypeId, StartDate, EndDate, Salary
            }
        }

        // dd($values);

        for ($i = 1; $i < count($values); $i++) {
            $name = explode(' ', $values[$i][0]);
            $last_name = array_pop($name);
            $first_name = implode(" ", $name);
            if (User::where('first_name', 'LIKE', "%{$first_name}%")->where('last_name', 'LIKE', "%{$last_name}%")->exists()) {
                $user = User::where('first_name', 'LIKE', "%{$first_name}%")->where('last_name', 'LIKE', "%{$last_name}%")->first();
                if ($user->employee) {
                    if ($user->employee->ActiveContractBetween($values[$i][2], $values[$i][3])) {
                        array_push($this->alreadyExisting, [$user->id, $user->employee->designation_id, $values[$i][1], $values[$i][2], $values[$i][3], $values[$i][4], $user->employee->active_contract]);
                    } else {
                        array_push($this->validContracts, [$user->id, $user->employee->designation_id, $values[$i][1], $values[$i][2], $values[$i][3], $values[$i][4],]);
                        // user_id, designation_id, contract_type_id, start_date, end_date, salary
                    }
                }
            } else {
                array_push($this->invalidContracts, $values[$i]);
            }
        }
    }

    function uploadContracts()
    {
        $count = 0;
        foreach ($this->validContracts as $contract) {
            $newContract = new EmployeeContract();
            $newContract->employees_detail_id = EmployeesDetail::where('user_id', $contract[0])->first()->id;
            $newContract->designation_id = $contract[1];
            $newContract->employment_type_id = $contract[2];
            $newContract->start_date = $contract[3];
            $newContract->end_date = $contract[4];
            $newContract->salary_kes = $contract[5];
            $newContract->save();
            $count++;
        }
        // dd();

        $this->emit('done', [
            'success' => "Successfully Uploaded {$count} Contracts"
        ]);
        $this->reset();
    }
    public function render()
    {
        return view('livewire.admin.employee-contracts.mass-addition');
    }
}
