<?php

namespace App\Http\Livewire\Admin\Settings;

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
            $oldEnvContent = preg_replace("/$key=.*$/m", "$key=\"$value\"", $oldEnvContent);
        }

        File::put($envFile, $oldEnvContent);

        $this->emit('done', [
            'success' => 'Successfully Saved the Attendance Format Setting'
        ]);
    }
    public function saveCompanyDetails()
    {
        $this->validate([
            'companyName' => 'required',
            'companyEmail' => 'required',
            'companyLogo' => 'required|mimes:png',
        ]);



        $envData = [
            'COMPANY_NAME' => $this->companyName,
            'COMPANY_EMAIL' => $this->companyEmail,
        ];

        $envFile = base_path('.env');
        $oldEnvContent = File::get($envFile);

        foreach ($envData as $key => $value) {
            $oldEnvContent = preg_replace("/$key=.*$/m", "$key=\"$value\"", $oldEnvContent);
        }

        File::put($envFile, $oldEnvContent);

        $this->companyLogo->storeAs('/', 'company_logo.png', 'public');

        $this->emit('done', [
            'success' => 'Successfully Saved the Company Details Settings'
        ]);
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
            $oldEnvContent = preg_replace("/$key=.*$/m", "$key=\"$value\"", $oldEnvContent);
        }

        File::put($envFile, $oldEnvContent);

        $this->emit('done', [
            'success' => 'Successfully Saved the Company Account Details'
        ]);
    }

    public function render()
    {
        return view('livewire.admin.settings.general');
    }
}
