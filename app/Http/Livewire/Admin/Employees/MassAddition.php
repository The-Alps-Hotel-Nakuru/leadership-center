<?php

namespace App\Http\Livewire\Admin\Employees;

use App\Imports\EmployeesImport;
use App\Mail\AccountCreated;
use App\Models\Designation;
use App\Models\EmployeesDetail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class MassAddition extends Component
{

    use WithFileUploads;

    public $employeeFile;
    public $readyUsers = [];
    public $existingUsers = [];
    public $invalidUsers = [];

    protected $rules = [
        'employeeFile' => 'required|mimes:xlsx,csv,txt'
    ];


    function checkData()
    {
        $this->validate();

        $this->reset(['readyUsers', 'existingUsers', 'invalidUsers']);
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
            // if (count($item) != 14) {
            //     throw ValidationException::withMessages([
            //         'employeeFile' => ['This Document is not Valid']
            //     ]);
            // }

            if ($item[0] != null) {
                array_push($values, [$item[0], $item[1], $item[2], $item[3], $item[4], $item[5], $item[6], $item[7], $item[8], $item[9], $item[10], $item[11], $item[12], $item[13]],);
            }
        }
        // dd($values);

        // dd($test);

        for ($i = 1; $i < count($values); $i++) {
            if (!$values[$i][2] || !$values[$i][3] || !$values[$i][4] || !$values[$i][5] || !$values[$i][6] || !$values[$i][7] || !$values[$i][8] || !$values[$i][10] || !$values[$i][11] || !preg_match('/^\d{10}$/', $values[$i][7]) || !Designation::where('title', 'LIKE', '%' . $values[$i][6] . '%')->exists()) {
                array_push($this->invalidUsers, $values[$i]);
            } elseif (User::where('email', $values[$i][4])->exists()) {
                array_push($this->existingUsers, $values[$i]);
            } else {
                array_push($this->readyUsers, $values[$i]);
            }
        }

        // if (count($this->productsList) == 0) {
        //     $this->emit('done', [
        //         'info' => 'There were no items that matched the system database'
        //     ]);
        // }
        // unlink($filePath);

    }

    function uploadUsers()
    {
        foreach ($this->readyUsers as $key => $readyUser) {
            $user = new User();
            $employee = new EmployeesDetail();
            $password = Str::random(12);
            $name = explode(" ", $readyUser[3]);
            $user->first_name = $name[0];
            $user->last_name = $name[count($name) - 1];
            $user->email = $readyUser[4];
            $user->password = Hash::make($password);
            $user->role_id = 3;
            $user->save();
            $employee->user_id = $user->id;
            $employee->designation_id = Designation::where('title', 'like', '%' . $readyUser[6] . '%')->first()->id;
            $employee->phone_number = $readyUser[7];
            $employee->gender = $readyUser[5] == "M" ? "male" : "female";
            $employee->birth_date = Carbon::parse($readyUser[8])->toDateString();
            $employee->kra_pin = $readyUser[11];
            if ($readyUser[12]) {
                $employee->nssf = $readyUser[12];
            }
            if ($readyUser[13]) {
                $employee->nhif = $readyUser[13];
            }
            $employee->save();
            Mail::to($user->email)->send(new AccountCreated($user, $employee, $password));
        }

        $this->emit('done', [
            'success' => 'Successfully Added ' . count($this->readyUsers) . " users into the system."
        ]);
        $this->reset();
    }


    public function render()
    {
        return view('livewire.admin.employees.mass-addition');
    }
}
