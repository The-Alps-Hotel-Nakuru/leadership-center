<?php

namespace App\Http\Livewire\Admin;

use App\Models\Log;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component

{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';


    public function render()
    {
        return view('livewire.admin.dashboard', [
            'logs' => Log::orderBy('id', 'DESC')->paginate(10)
        ]);
    }
}
