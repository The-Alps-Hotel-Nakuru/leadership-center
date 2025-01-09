<?php

namespace App\Livewire\Admin\Bans;

use App\Models\Ban;
use Livewire\Component;

class Index extends Component
{
    public $bans;

    protected $listeners = [
        'done' => 'mount'
    ];

    function mount()
    {
        $this->bans = Ban::all();
    }

    function unban($id)
    {
        $ban = Ban::find($id);
        $ban->delete();
        $this->dispatch(
            'done',
            success: "Successfully Unbanned " . $ban->employee->user->name
        );
    }
    public function render()
    {
        return view('livewire.admin.bans.index');
    }
}
