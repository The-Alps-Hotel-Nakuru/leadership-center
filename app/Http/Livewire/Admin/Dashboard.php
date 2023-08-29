<?php

namespace App\Http\Livewire\Admin;

use App\Exports\EmployeesDataExport;
use App\Models\EventOrder;
use App\Models\Log;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Dashboard extends Component

{
    use WithPagination;

    public $monthearnings = 0;
    public $increase = 0;
    protected $paginationTheme = 'bootstrap';

    function downloadEmployeesData() {
        return Excel::download(new EmployeesDataExport, 'employees data.xlsx');

        $this->emit('done', [
            'success' => 'Employees data exported successfully'
        ]);
    }


    public function render()
    {
        return view('livewire.admin.dashboard', [
            'logs' => Log::orderBy('id', 'DESC')->paginate(10)
        ]);
    }
}
