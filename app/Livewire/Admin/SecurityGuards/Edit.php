<?php

namespace App\Livewire\Admin\SecurityGuards;

use Livewire\Component;
use App\Jobs\SendSecurityWelcomeEmailJob;
use App\Models\Log;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Edit extends Component
{
    public User $security_guard;

    protected $rules = [
        'security_guard.first_name' => 'required',
        'security_guard.last_name' => 'required',
        'security_guard.email' => 'required|email|unique:users,email',
        'security_guard.role_id' => 'required',
    ];

    protected $messages = [
        'security_guard.first_name.required' => "The First Name is Required",
        'security_guard.last_name.required' => "The Last Name is Required",
        'security_guard.email.required' => "The Email Address is Required",
        'security_guard.email.email' => "This Email Format is not Supported",
        'security_guard.role_id.required' => "Please select a Role",
    ];

    public function mount($id)
    {
        $this->security_guard = User::find($id);
    }


    public function save()
    {
        $this->validate();
        $password = Str::random(10);
        $this->admin->password = Hash::make($password);
        $this->admin->save();

        SendSecurityWelcomeEmailJob::dispatch($this->admin, $password);

        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\User';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has created a new admin named <strong>" . $this->admin->name . "</strong> from the system";
        $log->save();


        return redirect()->route('admin.security_guards.index');
    }

    public function render()
    {
        return view('livewire.admin.security-guards.edit');
    }
}
