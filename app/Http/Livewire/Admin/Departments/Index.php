<?php

namespace App\Http\Livewire\Admin\Departments;

use App\Models\Department;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    function delete($id) {
        Department::find($id)->delete();

        $this->emit('done', [
            'success'=>"Successfully Deleted the Department"
        ]);
    }
    public function render()
    {
        return view('livewire.admin.departments.index',[
            'departments'=>Department::paginate(5)
        ]);
    }
}
