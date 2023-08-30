<?php

namespace App\Http\Livewire\Admin\EmployeeAccounts;

use App\Imports\AccountsImport;
use App\Models\Bank;
use App\Models\EmployeeAccount;
use App\Models\EmployeesDetail;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class MassAddition extends Component
{
    use WithFileUploads;

    public $accountsFile;

    public $validAccounts = [], $invalidAccounts = [], $alreadyExisting = [];


    protected $rules = [
        'accountsFile' => 'required|mimes:xlsx,csv,txt'
    ];

    function checkData()
    {
        $this->validate();
        $this->reset(['validAccounts', 'invalidAccounts', 'alreadyExisting']);
        // Store the uploaded file
        $filePath = $this->accountsFile->store('excel_files');

        // Import and parse the Excel data
        $import = new AccountsImport();
        Excel::import($import, $filePath);

        // Access the parsed data
        $data = $import->getData();

        // dd($data);

        $values = [];

        $fields = ["NAME", "BANK", "ACCOUNT NUMBER"];

        for ($i = 0; $i < count($fields); $i++) {
            if ($data[0][$i] != $fields[$i]) {
                throw ValidationException::withMessages([
                    'accountsFile' => ['The Fields set are incorrect']
                ]);
            }
        }

        foreach ($data as $item) {
            if ($item[0] != null) {
                array_push($values, [$item[0], $item[1], $item[2]]);
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
                    if ($user->employee->bankAccount) {
                        array_push($this->alreadyExisting, [$values[$i], $user->employee->bankAccount]);
                    } else {
                        array_push($this->validAccounts, [$user->id, $values[$i][1], $values[$i][2]]);
                    }
                }
            } else {
                array_push($this->invalidAccounts, $values[$i]);
            }
        }
    }

    function uploadAccounts()
    {
        $count = 0;
        foreach ($this->validAccounts as $account) {
            // $user = User::find($account[0]);
            // $acc = $user->employee->bankAccount ? EmployeeAccount::find($user->employee->bankAccount->id) : new EmployeeAccount();
            $acc = new EmployeeAccount();
            $acc->employees_detail_id = EmployeesDetail::where('user_id', $account[0])->first()->id;
            $acc->bank_id = Bank::where('short_name', $account[1])->first()->id;
            $acc->account_number = $account[2];
            $acc->save();
            $count++;
        }
        // dd();

        $this->emit('done', [
            'success' => "Successfully Uploaded {$count} Accounts"
        ]);
        $this->reset();
    }
    public function render()
    {
        return view('livewire.admin.employee-accounts.mass-addition');
    }
}
