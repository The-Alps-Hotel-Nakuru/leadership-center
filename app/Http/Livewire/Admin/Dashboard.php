<?php

namespace App\Http\Livewire\Admin;

use App\Models\Log;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component

{
    use WithPagination;
    public $logs;

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->logs = Log::orderBy('id', 'DESC')->paginate(5);
    }


    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
