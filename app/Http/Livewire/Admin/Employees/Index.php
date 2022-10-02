<?php

namespace App\Http\Livewire\Admin\Employees;

use App\Models\EmployeesDetail;
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
    }

    public function render()
    {
        return view('livewire.admin.employees.index', [
            'employees'=>EmployeesDetail::orderBy('id', 'DESC')->paginate(5),
        ]);

    }
}
