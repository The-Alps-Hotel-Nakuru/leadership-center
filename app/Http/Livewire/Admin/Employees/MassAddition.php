<?php

namespace App\Http\Livewire\Admin\Employees;

use Livewire\Component;
use Livewire\WithFileUploads;

class MassAddition extends Component
{

    use WithFileUploads;

    public $employeeFile;

    protected $rules = [
        'employeeFile' => 'required|mimes:xlsx,csv,txt'
    ];


    function checkData()
    {
        $this->validate();

        dd($this->employeeFile);
    }

    public function render()
    {
        return view('livewire.admin.employees.mass-addition');
    }
}
