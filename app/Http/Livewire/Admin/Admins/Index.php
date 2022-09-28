<?php

namespace App\Http\Livewire\Admin\Admins;

use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    public $admins;

    protected $listeners = [
        'done'=>'render'
    ];

    public function mount()
    {
        $this->admins = User::whereIn('role_id', [1,2])->get();
    }

    public function delete($id)
    {
        if ($id == 1) {
            abort(403, "This Admin cannot be deleted");
        }
        $admin = User::find($id);
        $admin->delete();

        $this->emit('done', [
            'success'=>'Successfully Deleted This Administrator'
        ]);
    }
    public function render()
    {
        return view('livewire.admin.admins.index');
    }
}
