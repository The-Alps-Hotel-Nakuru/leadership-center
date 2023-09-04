<?php

namespace App\Http\Livewire\Admin\Advances;

use App\Models\Advance;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public function render()
    {
        return view('livewire.admin.advances.index', [
            'advances' => Advance::paginate(5)
        ]);
    }
}
