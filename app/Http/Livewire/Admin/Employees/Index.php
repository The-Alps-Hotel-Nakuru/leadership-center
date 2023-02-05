<?php

namespace App\Http\Livewire\Admin\Employees;

use App\Models\EmployeesDetail;
use App\Models\Log;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $listeners=[
        'done'=>'render'
    ];

    protected $paginationTheme='bootstrap';

    public function delete($id)
    {
        $det = EmployeesDetail::find($id);

        $det->delete();


        $this->emit('done', [
            'success'=>'You are trying to delete Employee No.'.$id
        ]);
        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\EmployeesDetail';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has Deleted <strong> " . $this->detail->user->name . "</strong> from the system";
        $log->save();
    }

    public function render()
    {
        return view('livewire.admin.employees.index', [
            'employees'=>EmployeesDetail::orderBy('id', 'DESC')->paginate(5),
        ]);

    }
}
