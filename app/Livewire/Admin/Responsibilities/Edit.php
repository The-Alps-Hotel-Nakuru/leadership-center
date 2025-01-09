<?php

namespace App\Livewire\Admin\Responsibilities;

use App\Models\Designation;
use App\Models\Log;
use App\Models\Responsibility;
use Livewire\Component;

class Edit extends Component
{
    public $responsibility;

    protected $rules = [
        'responsibility.responsibility' => 'required'
    ];

    protected $messages = [
        'responsibility.responsibility.required' => "The Responsibility is Required"
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
        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\Responsibility';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has Edited a Responsibility belonging to the designation of <strong>" . $this->responsibility->designation->title . "</strong>  in the system";
        $log->save();


        return redirect()->route('admin.responsibilities.index');
    }

    public function render()
    {
        return view('livewire.admin.responsibilities.edit');
    }
}
