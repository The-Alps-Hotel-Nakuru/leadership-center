<?php

namespace App\Livewire\Admin\EmployeeAccounts;

use App\Models\EmployeeAccount;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.admin.employee-accounts.index', [
            'employees_accounts' => EmployeeAccount::orderBy('bank_id')->get()
        ]);
    }
}
