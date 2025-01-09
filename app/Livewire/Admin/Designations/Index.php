<?php

namespace App\Livewire\Admin\Designations;

use App\Models\Designation;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function delete($id)
    {
        $designation = Designation::find($id);

        if (!$designation->employees->count() > 0) {
            $designation->delete();
            $this->dispatch(
                'done',
                success: 'Successfully Deleted the designation'
            );
        } else {
            $this->dispatch(
                'done',
                danger: 'There are Employees Assigned to this designation'
            );
        }
    }
    public function render()
    {
        return view('livewire.admin.designations.index', [
            'designations' => Designation::paginate(10)
        ]);
    }
}
