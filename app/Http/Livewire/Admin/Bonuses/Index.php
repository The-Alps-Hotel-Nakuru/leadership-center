<?php

namespace App\Http\Livewire\Admin\Bonuses;

use App\Models\Bonus;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.admin.bonuses.index', [
            'bonuses' => Bonus::all()
        ]);
    }
}
