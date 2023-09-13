<?php

namespace App\Http\Livewire\Admin\Admins;

use App\Jobs\SendAdminWelcomeEmailJob;
use App\Models\Log;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Illuminate\Support\Str;

class Create extends Component
{
    public User $admin;

    protected $rules = [
        'admin.first_name' => 'required',
        'admin.last_name' => 'required',
        'admin.email' => 'required|email|unique:users,email',
        'admin.role_id' => 'required',
    ];

    public function mount()
    {
        $this->admin = new User();
    }


    public function save()
    {
        $this->validate();
        $password = Str::random(10);
        $this->admin->password = Hash::make(env('DEFAULT_PASSWORD'));
        $this->admin->save();


        SendAdminWelcomeEmailJob::dispatch($this->admin, $password);

        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\User';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has created a new admin named <strong>" . $this->admin->name . "</strong> from the system";
        $log->save();


        return redirect()->route('admin.admins.index');
    }

    public function render()
    {
        return view('livewire.admin.admins.create');
    }
}
