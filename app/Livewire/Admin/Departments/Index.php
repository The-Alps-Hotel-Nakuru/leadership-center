<?php

namespace App\Livewire\Admin\Departments;

use App\Models\Department;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    function delete($id)
    {
        if (count(Department::find($id)->designations) <= 0) {
            Department::find($id)->delete();

            $this->dispatch(
                'done',
                success: "Successfully Deleted the Department"
            );
        } else {
            $this->dispatch(
                'done',
                warning: "Cannot delete a department with designations"
            );
        }
    }
    public function render()
    {
        return view('livewire.admin.departments.index', [
            'departments' => Department::paginate(5)
        ]);
    }
}
