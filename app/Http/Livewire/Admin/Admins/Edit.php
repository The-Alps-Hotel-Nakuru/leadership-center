<?php

namespace App\Http\Livewire\Admin\Admins;

use App\Models\Log;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Edit extends Component
{
    public User $admin;

    public function rules()
    {
        return [
            'admin.first_name' => 'required',
            'admin.last_name' => 'required',
            'admin.email' => 'required|email|unique:users,email,' . ($this->admin->id ?? 'NULL'),
            'admin.role_id' => 'required',
        ];
    }

    protected $messages = [
        'admin.first_name.required' => "The First Name is Required",
        'admin.last_name.required' => "The Last Name is Required",
        'admin.email.required' => "The Email Address is Required",
        'admin.email.email' => "This Email Format is not Supported",
        'admin.role_id.required' => "Please select a Role",
    ];

    public function mount($id)
    {
        $this->admin = User::find($id);
    }


    public function save()
    {
        $this->validate();
        $this->admin->password = Hash::make(env('DEFAULT_PASSWORD'));
        $this->admin->update();

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
