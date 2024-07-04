<?php

namespace App\Http\Livewire\Admin\SecurityGuards;

use App\Jobs\SendAdminWelcomeEmailJob;
use App\Jobs\SendSecurityWelcomeEmailJob;
use App\Models\Log;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Illuminate\Support\Str;

class Create extends Component
{

    public User $security_guard;

    protected $rules = [
        'security_guard.first_name' => 'required',
        'security_guard.last_name' => 'required',
        'security_guard.email' => 'required|email|unique:users,email',
    ];

    protected $messages = [
        'security_guard.first_name.required' => "The First Name is Required",
        'security_guard.last_name.required' => "The Last Name is Required",
        'security_guard.email.required' => "The Email Address is Required",
        'security_guard.email.email' => "This Email Format is not Supported",
    ];

    public function mount()
    {
        $this->security_guard = new User();
    }


    public function save()
    {
        $this->validate();
        $password = Str::random(10);
        $this->security_guard->password = Hash::make($password);
        $this->security_guard->role_id = 4;
        $this->security_guard->save();

        SendSecurityWelcomeEmailJob::dispatch($this->security_guard, $password);

        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\User';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has created a new admin named <strong>" . $this->security_guard->name . "</strong> from the system";
        $log->save();


        return redirect()->route('admin.security_guards.index');
    }

    public function render()
    {
        return view('livewire.admin.security-guards.create');
    }
}
