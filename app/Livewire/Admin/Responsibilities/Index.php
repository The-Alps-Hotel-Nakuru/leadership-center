<?php

namespace App\Livewire\Admin\Responsibilities;

use App\Models\Responsibility;
use Livewire\Component;

class Index extends Component
{
    public $responsibilities;


    public function mount()
    {
        $this->responsibilities = Responsibility::all();
    }

    public function delete($id)
    {
        Responsibility::find($id)->delete();
        $this->dispatch(
            'done',
            success: 'Successfully Deleted a Responsibility!'
        );
    }
    public function render()
    {
        return view('livewire.admin.responsibilities.index');
    }
}
