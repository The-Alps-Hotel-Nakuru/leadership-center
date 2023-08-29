<?php

namespace App\Http\Livewire\Admin\Settings;

use Illuminate\Support\Facades\File;
use Livewire\Component;

class General extends Component
{

    public $attendanceDateFormat;


    protected $rules = [
        'attendanceDateFormat' => 'required'
    ];

    function mount()
    {
        $this->attendanceDateFormat = env('ATTENDANCE_DATE_FORMAT');
    }

    public function saveSettings()
    {
        $this->validate();
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
            'success' => 'Successfully Saved the General Settings'
        ]);
    }

    public function render()
    {
        return view('livewire.admin.settings.general');
    }
}
