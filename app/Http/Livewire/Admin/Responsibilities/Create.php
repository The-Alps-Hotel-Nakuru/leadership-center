<?php

namespace App\Http\Livewire\Admin\Responsibilities;

use App\Models\Designation;
use App\Models\Responsibility;
use Livewire\Component;

class Create extends Component
{

    public Designation $designation;
    public $responsibility;

    protected $rules = [
        'responsibility.responsibility' => 'required'
    ];

    protected $listeners = [
        'done' => 'render'
    ];

    public function mount($designation_id)
    {
        $this->designation = Designation::find($designation_id);
        $this->responsibility = new Responsibility();
    }

    public function save()
    {
        $this->validate();
        $this->responsibility->designation_id = $this->designation->id;
        $this->responsibility->save();


        $this->emit('done', [
            'success' => 'Successfully Created a new Responsibility for the ' . $this->designation->title . ' staff'
        ]);
        $this->responsibility = new Responsibility();
    }


    public function delete($id)
    {
        Responsibility::find($id)->delete();
        $this->emit('done', [
            'success' => 'Successfully Deleted a Responsibility!'
        ]);

    }

    public function render()
    {
        return view('livewire.admin.responsibilities.create');
    }
}
