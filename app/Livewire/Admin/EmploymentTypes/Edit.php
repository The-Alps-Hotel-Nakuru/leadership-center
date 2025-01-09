<?php

namespace App\Livewire\Admin\EmploymentTypes;

use App\Models\EmploymentType;
use Livewire\Component;

class Edit extends Component
{
    public EmploymentType $type;

    protected $rules = [
        'type.title' => 'required',
        'type.description' => 'required',
        'type.rate_type' => 'required',
        'type.is_penalizable' => 'required',
    ];

    function mount($id)
    {
        $this->type = EmploymentType::find($id);
    }

    function save()
    {
        $this->validate();
        $this->type->update();

        $this->dispatch(
            'done',
            success: "Successfully Created a new Employment Type"
        );
    }
    public function render()
    {
        return view('livewire.admin.employment-types.edit');
    }
}
