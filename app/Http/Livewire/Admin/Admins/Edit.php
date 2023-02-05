<?php

namespace App\Http\Livewire\Admin\Admins;

use App\Models\Log;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Edit extends Component
{
    public User $admin;

    protected $rules = [
        'admin.first_name'=>'required',
        'admin.last_name'=>'required',
        'admin.email'=>'required|email|unique:users,email',
        'admin.role_id'=>'required',
    ];

    public function mount($id)
    {
        $this->admin = User::find($id);
    }


    public function save()
    {
        $this->validate();
        $this->admin->password = Hash::make(env('DEFAULT_PASSWORD'));
        $this->admin->save();

        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\User';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has edited <strong>" . $this->admin->name . "</strong> from the system";
        $log->save();

        return redirect()->route('admin.admins.index');
    }
    public function render()
    {
        return view('livewire.admin.admins.edit');
    }
}
