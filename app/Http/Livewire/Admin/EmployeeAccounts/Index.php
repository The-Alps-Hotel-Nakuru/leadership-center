<?php

namespace App\Http\Livewire\Admin\EmployeeAccounts;

use App\Exports\EmployeesAccountsExport;
use App\Models\EmployeeAccount;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Component
{
    public function downloadData(){
        return Excel::download(new EmployeesAccountsExport, 'employees_bank_accounts.xlsx');
    }

    public function render()
    {
        return view('livewire.admin.employee-accounts.index', [
            'employees_accounts' => EmployeeAccount::orderBy('bank_id')->get()
        ]);
    }
}
