<?php

namespace App\Http\Livewire\Admin\EmploymentTypes;

use App\Models\EmploymentType;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Create extends Component
{
    public EmploymentType $type;

    protected $rules = [
        'type.title' => 'required',
        'type.description' => 'required',
        'type.rate_type' => 'required',
        'type.is_penalizable' => 'required',
    ];

    protected $listeners = [
        'done' => 'mount'
    ];

    function mount()
    {
        $this->type = new EmploymentType();
    }

    function save()
    {
        $this->validate();

        if (EmploymentType::where('title', $this->type->title)->exists()) {
            throw ValidationException::withMessages([
                'type.title' => "This Title already Exists!"
            ]);
        }

        $this->type->save();

        $this->emit('done', [
            'success' => "Successfully Created a new Employment Type"
        ]);
    }
    public function render()
    {
        return view('livewire.admin.employment-types.create');
    }
}
