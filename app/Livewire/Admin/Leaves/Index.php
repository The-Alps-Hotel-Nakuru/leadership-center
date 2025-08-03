<?php

namespace App\Livewire\Admin\Leaves;

use App\Models\Leave;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function delete($id)
    {
        Leave::find($id)->delete();
        $this->dispatch(
            'done',
            success: 'This Leave has been Successfully Deleted'
        );
    }
    public function render()
    {
        return view('livewire.admin.leaves.index', [
            'leaves' => Leave::orderBy('created_at', 'DESC')->paginate(10)
        ]);
    }
}
