<?php

namespace App\Livewire\Admin\Settings;

use App\Models\Bank;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Livewire\WithFileUploads;

class General extends Component
{

    public $attendanceDateFormat;
    public $bankName;
    public $accountNumber;
    public $sortCode;
    public $companyName;
    public $companyEmail;
    public $companyHREmail;
    public $companyLocation;
    public $companyLogo;
    public $banks;
    public $bank;

    use WithFileUploads;

    protected $rules = [
        'attendanceDateFormat' => 'required',
        'bankName' => 'required',
        'accountNumber' => 'required',
        'sortCode' => 'required',
        'companyName' => 'required',
        'companyEmail' => 'required',
        'companyHREmail' => 'required',
        'companyLocation' => 'required',
        'companyLogo' => 'required',
    ];

    protected $listeners = [
        'done' => 'render'
    ];

    function mount()
    {

        $this->attendanceDateFormat = env('ATTENDANCE_DATE_FORMAT');
        $this->bankName = env('BANK_NAME');
        $this->sortCode = env('BANK_SORT');
        $this->accountNumber = env('BANK_ACCOUNT_NUMBER');
        $this->companyName = env('COMPANY_NAME');
        $this->companyEmail = env('COMPANY_EMAIL');
        $this->companyHREmail = env('COMPANY_HR_EMAIL');
        $this->companyLocation = env('COMPANY_LOCATION');
        $this->banks = Bank::all();
    }

    public function saveAttendanceFormat()
    {
        $this->validate([
            'attendanceDateFormat' => 'required'
        ]);
        $envData = [
            'ATTENDANCE_DATE_FORMAT' => $this->attendanceDateFormat,
        ];

        $envFile = base_path('.env');
        $oldEnvContent = File::get($envFile);

        foreach ($envData as $key => $value) {
            if (preg_match("/$key=.*$/m", $oldEnvContent)) {
                // If the variable already exists, update it
                $oldEnvContent = preg_replace("/$key=.*$/m", "$key=\"$value\"", $oldEnvContent);
            } else {
                // If the variable doesn't exist, add it
                $oldEnvContent .= "\n$key=\"$value\"";
            }
        }

        File::put($envFile, $oldEnvContent);

        $this->dispatch(
            'done',
            success: 'Successfully Saved the Attendance Format Setting'
        );
    }
    public function saveCompanyDetails()
    {
        $this->validate([
            'companyName' => 'required',
            'companyLocation' => 'required',
            'companyEmail' => 'required|email',
            'companyHREmail' => 'required|email',
            'companyLogo' => 'nullable|mimes:png',
        ]);

        $envData = [
            'COMPANY_NAME' => $this->companyName,
            'COMPANY_EMAIL' => $this->companyEmail,
            'COMPANY_LOCATION' => $this->companyLocation,
            'COMPANY_HR_EMAIL' => $this->companyHREmail,
        ];

        $envFile = base_path('.env');
        $oldEnvContent = File::get($envFile);

        foreach ($envData as $key => $value) {
            if (preg_match("/$key=.*$/m", $oldEnvContent)) {
                $oldEnvContent = preg_replace("/$key=.*$/m", "$key=\"$value\"", $oldEnvContent);
            } else {
                $oldEnvContent .= "\n$key=\"$value\"";
            }
        }

        File::put($envFile, $oldEnvContent);

        if ($this->companyLogo) {
            $this->companyLogo->storeAs('/', 'company_logo.png', 'public');
        }



        $this->dispatch(
            'done',
            success: 'Successfully Saved the Company Details Settings'
        );
    }


    public function saveAccountDetails()
    {
        $this->validate([
            'bankName' => 'required',
            'accountNumber' => 'required',
            'sortCode' => 'required',
        ]);



        $envData = [
            'BANK_NAME' => $this->bankName,
            'BANK_ACCOUNT_NUMBER' => $this->accountNumber,
            'BANK_SORT' => $this->sortCode,
        ];

        $envFile = base_path('.env');
        $oldEnvContent = File::get($envFile);

        foreach ($envData as $key => $value) {
            if (preg_match("/$key=.*$/m", $oldEnvContent)) {
                // If the variable already exists, update it
                $oldEnvContent = preg_replace("/$key=.*$/m", "$key=\"$value\"", $oldEnvContent);
            } else {
                // If the variable doesn't exist, add it
                $oldEnvContent .= "\n$key=\"$value\"";
            }
        }

        File::put($envFile, $oldEnvContent);


        $this->dispatch(
            'done',
            success: 'Successfully Saved the Company Account Details'
        );
    }

    public function render()
    {
        return view('livewire.admin.settings.general');
    }
}
