<?php

namespace App\Http\Livewire\Admin\Responsibilities;

use App\Models\Designation;
use App\Models\Responsibility;
use Livewire\Component;

class Edit extends Component
{
    public $responsibility;

    protected $rules = [
        'responsibility.responsibility' => 'required'
    ];

    protected $listeners = [
        'done' => 'render'
    ];

    public function mount( $id)
    {
        $this->responsibility = Responsibility::find($id);
    }

    public function save()
    {
        $this->validate();
        $this->responsibility->save();

        return redirect()->route('admin.responsibilities.index');
    }

    public function render()
    {
        return view('livewire.admin.responsibilities.edit');
    }
}
