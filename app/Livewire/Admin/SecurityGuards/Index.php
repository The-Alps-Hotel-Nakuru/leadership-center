<?php

namespace App\Livewire\Admin\SecurityGuards;

use App\Models\Log;
use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    public $security_guards;

    protected $listeners = [
        'done' => 'render'
    ];
    public function mount()
    {
        $this->security_guards = User::where('role_id', 4)->get();
    }
    public function delete($id)
    {
        if ($id == 1) {
            abort(403, "This Admin cannot be deleted");
        }
        $security_guard = User::find($id);
        $security_guard->delete();
        $this->dispatch(
            'done',
            success: 'Successfully Deleted This Security Guard'
        );
        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\User';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has deleted <strong>" . $security_guard->name . "</strong> from the system";
        $log->save();
    }
    public function render()
    {
        return view('livewire.admin.security-guards.index');
    }
}
