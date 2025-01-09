<?php

namespace App\Livewire\Admin\EmploymentTypes;

use App\Models\EmploymentType;
use Livewire\Component;

class Index extends Component
{
    public $employment_types;

    protected $listeners = [
        'done' => 'mount'
    ];

    function mount()
    {
        $this->employment_types = EmploymentType::all();
    }

    function delete($id)
    {
        $type = EmploymentType::find($id);

        if (count($type->contracts) > 0) {
            $this->dispatch(
                'done',
                warning: "This Employment Type was used to create " . count($type->contracts) . " contracts. It can't be deleted."
            );
            return;
        }

        $type->delete();
        $this->dispatch(
            'done',
            success: "Employment Type Successfully Deleted."
        );
    }
    public function render()
    {
        return view('livewire.admin.employment-types.index');
    }
}
