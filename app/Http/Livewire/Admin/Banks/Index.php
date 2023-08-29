<?php

namespace App\Http\Livewire\Admin\Banks;

use App\Models\Bank;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('livewire.admin.banks.index',[
            'banks'=>Bank::paginate(10)
        ]);
    }
}
