<?php

namespace App\Http\Livewire\Admin\Admins;

use App\Models\Log;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    // use WithPagination;
    public $admins;

    protected $listeners = [
        'done' => 'render'
    ];
    
    // protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->admins = User::whereIn('role_id', [1, 2])->get();
    }

    public function delete($id)
    {
        if ($id == 1) {
            abort(403, "This Admin cannot be deleted");
        }
        $admin = User::find($id);
        $admin->delete();

        $this->emit('done', [
            'success' => 'Successfully Deleted This Administrator'
        ]);
        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\User';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has deleted <strong>" . $admin->name . "</strong> from the system";
        $log->save();
    }
    public function render()
    {
        return view('livewire.admin.admins.index');
    }
}
