<?php

namespace App\Http\Livewire\Admin\Employees;

use App\Exports\EmployeeKRAExport;
use App\Exports\EmployeeNHIFExport;
use App\Exports\EmployeeNSSFExport;
use App\Exports\EmployeesDataTemplateExport;
use App\Jobs\PasswordResetMailJob;
use App\Models\Ban;
use App\Models\EmployeesDetail;
use App\Models\Log;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class Index extends Component
{
    use WithPagination;

    public $search = "";
    public $reason = "";
    protected $listeners = [
        'done' => 'render'
    ];

    protected $rules = [
        'reason'
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

    function resetPassword($user_id)
    {
        $password = Str::random(10);
        $user = User::find($user_id);
        $user->password = Hash::make($password);
        $user->save();

        PasswordResetMailJob::dispatch($user, $password);

        $this->emit('done', [
            'success' => "Successfully Reset this Employee's Password"
        ]);

        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\EmployeesDetail';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has Reset the Password for <strong> " . $user->name . "</strong> in the system";
        $log->save();
    }

    function banEmployee($employee_id)
    {

        $this->validate([
            'reason' => 'required'
        ]);
        $ban = new Ban();
        if (Ban::where('employees_detail_id', $employee_id)->exists()) {
            $this->emit('done', [
                'warning' => 'This Employee has Already been Banned'
            ]);
            return;
        }

        $ban->employees_detail_id = $employee_id;
        $ban->reason = $this->reason;
        $ban->save();

        $this->emit('done', [
            'success' => 'Successfully Banned this Employee'
        ]);
        $this->reset('reason');

        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\Ban';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has banned <strong> " . $ban->employee->user->name . "</strong> from accessing the system";
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
            'success' => 'NHIF data exported successfully'
        ]);
    }

    public function exportNssfData()
    {
        return Excel::download(new EmployeeNSSFExport, 'employeesnssf.xlsx');

        $this->emit('done', [
            'success' => 'NSSF data exported successfully'
        ]);
    }
    public function downloadEmployeesTemplate()
    {
        return Excel::download(new EmployeesDataTemplateExport, 'employees_data_template.xlsx');

        $this->emit('done', [
            'success' => 'NSSF data exported successfully'
        ]);
    }

    public function unban($id)
    {
        $ban = Ban::find($id);
        $ban->delete();

        $this->emit('done', [
            'success' => 'You have successfully Unbanned this User'
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
