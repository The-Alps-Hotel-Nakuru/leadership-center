<?php

namespace App\Http\Livewire\Admin\Employees;

use App\Exports\EmployeeKRAExport;
use App\Exports\EmployeeNHIFExport;
use App\Exports\EmployeeNSSFExport;
use App\Models\EmployeesDetail;
use App\Models\Log;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Component
{
    use WithPagination;

    public $search = "";
    protected $listeners = [
        'done' => 'render'
    ];

    protected $paginationTheme = 'bootstrap';

    public function delete($id)
    {
        $det = EmployeesDetail::find($id);

        $det->delete();


        $this->emit('done', [
            'success' => 'You are trying to delete Employee No.' . $id
        ]);
        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\EmployeesDetail';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has Deleted <strong> " . $this->detail->user->name . "</strong> from the system";
        $log->save();
    }

    public function exportKraData()
    {
        return Excel::download(new EmployeeKRAExport, 'employeeskra.xlsx');

        $this->emit('done', [
            'success' => 'KRA data exported successfully'
        ]);
    }

    public function exportNhifData()
    {
        return Excel::download(new EmployeeNHIFExport, 'employeesnhif.xlsx');

        $this->emit('done', [
            'success'=> 'NHIF data exported successfully'
        ]);
    }

    public function exportNssfData()
    {
        return Excel::download(new EmployeeNSSFExport, 'employeesnssf.xlsx');

        $this->emit('done', [
            'success'=> 'NSSF data exported successfully'
        ]);
    }

    public function render()
    {
        $employees = EmployeesDetail::whereHas('user', function ($query) {
            $query->where('first_name', 'like', '%' . $this->search . '%')
                ->orWhere('last_name', 'like', '%' . $this->search . '%');
        });

        return view('livewire.admin.employees.index', [
            'employees' => $employees->orderBy('id', 'DESC')->paginate(5),
        ]);
    }
}
