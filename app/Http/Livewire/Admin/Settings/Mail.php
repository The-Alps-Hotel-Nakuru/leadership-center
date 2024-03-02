<?php

namespace App\Http\Livewire\Admin\Settings;

use Illuminate\Support\Facades\File;
use Livewire\Component;

class Mail extends Component
{

    public $mailDriver;
    public $mailUsername;
    public $mailPassword;
    public $mailHost;
    public $mailPort;
    public $mailFromAddress;
    public bool $passwordVisible = false;



    function mount()
    {
        $this->mailDriver = env('MAIL_MAILER');
        $this->mailHost = env('MAIL_HOST');
        $this->mailPort = env('MAIL_PORT');
        $this->mailFromAddress = env('MAIL_FROM_ADDRESS');
        $this->mailUsername = env('MAIL_USERNAME');
        $this->mailPassword = env('MAIL_PASSWORD');
    }

    function toggleVisibility()
    {
        $this->passwordVisible = $this->passwordVisible ? false : true;
    }

    public function saveSettings()
    {
        $this->validate([
            'mailDriver' => 'required',
            'mailHost' => 'required|string',
            'mailPort' => 'required|numeric',
            'mailFromAddress' => 'required|email',
            'mailUsername' => 'required|string',
            'mailPassword' => 'required|min:8',
        ]);

        $envData = [
            'MAIL_MAILER' => $this->mailDriver,
            'MAIL_HOST' => $this->mailHost,
            'MAIL_PORT' => $this->mailPort,
            'MAIL_FROM_ADDRESS' => $this->mailFromAddress,
            'MAIL_USERNAME' => $this->mailUsername,
            'MAIL_PASSWORD' => $this->mailPassword,
        ];

        $envFile = base_path('.env');
        $oldEnvContent = File::get($envFile);

        foreach ($envData as $key => $value) {
            $oldEnvContent = preg_replace("/$key=.*$/m", "$key=$value", $oldEnvContent);
        }

        File::put($envFile, $oldEnvContent);

        $this->emit('done', [
            'success' => 'Successfully Saved the Mail Settings'
        ]);
    }


    public function render()
    {
        return view('livewire.admin.settings.mail');
    }
}
