<?php

namespace App\Http\Livewire\Admin\Admins;

use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    public $admins;

    public function mount()
    {
        $this->admins = User::whereIn('role_id', [1,2])->get();
    }
    public function render()
    {
        return view('livewire.admin.admins.index');
    }
}
