<?php

namespace App\Http\Livewire\Admin\Holidays;

use App\Models\Holiday;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;


    public function render()
    {
        return view('livewire.admin.holidays.index', [
            'holidays' => Holiday::orderBy('created_at', 'desc')->paginate(10),
        ]);
    }
}
