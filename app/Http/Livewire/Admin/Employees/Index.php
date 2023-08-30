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

    // public function exportData($exportType)
    // {
    //     $this->logs($exportType);

    //     $fileName = '';
    //     $exportClass = null;

    //     if ($exportType === 'kra') {
    //         $fileName = 'employeeskra.xlsx';
    //         $exportClass = new EmployeeKRAExport;
    //     } elseif ($exportType === 'nhif') {
    //         $fileName = 'employeesnhif.xlsx';
    //         $exportClass = new EmployeeNHIFExport;
    //     } elseif ($exportType === 'nssf') {
    //         $fileName = 'employeesnssf.xlsx';
    //         $exportClass = new EmployeeNSSFExport;
    //     }

    //     if ($exportClass) {
    //         Excel::download($exportClass, $fileName);
    //         // $this->emit('done', [
    //         //     'success' => ucfirst($exportType) . ' data exported successfully'
    //         // ]);
    //     }
    // }

    // public function logs($exportType)
    // {
    //     $log = new Log();
    //     $log->user_id = auth()->user()->id;
    //     $log->model = 'App\Models\EmployeesDetail';

    //     if ($exportType === 'kra') {
    //         $log->payload = "<strong>" . auth()->user()->name . "</strong> has done mass extraction of KRA information for <strong> " . 'every employee' . "</strong> in the system";
    //     } elseif ($exportType === 'nhif') {
    //         $log->payload = "<strong>" . auth()->user()->name . "</strong> has done mass extraction of NHIF information for <strong> " . 'every employee' . "</strong> in the system";
    //     } elseif ($exportType === 'nssf') {
    //         $log->payload = "<strong>" . auth()->user()->name . "</strong> has done mass extraction of NSSF information for <strong> " . 'every employee' . "</strong> in the system";
    //     }

    //     $log->save();
    // }

    public function exportKraData()
    {

        return Excel::download(new EmployeeKRAExport, 'employeeskra.xlsx');
    }

    public function exportNhifData()
    {
        return Excel::download(new EmployeeNHIFExport, 'employeesnhif.xlsx');
    }

    public function exportNssfData()
    {
        return Excel::download(new EmployeeNSSFExport, 'employeesnssf.xlsx');
    }

    public function render()
    {
        return view('livewire.admin.employees.index', [
            'employees' => EmployeesDetail::orderBy('id', 'DESC')->paginate(5),
        ]);
    }
}
