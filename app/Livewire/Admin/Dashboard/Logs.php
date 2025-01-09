<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\Log;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Logs extends Component
{
    use WithPagination, WithoutUrlPagination;
    public function render()
    {
        return view('livewire.admin.dashboard.logs',[
            'logs' => Log::orderBy('id', 'DESC')->paginate(5)
        ]);
    }
}
