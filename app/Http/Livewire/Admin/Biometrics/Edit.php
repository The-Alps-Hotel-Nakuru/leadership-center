<?php

namespace App\Http\Livewire\Admin\Biometrics;

use App\Models\Biometric;
use App\Models\EmployeesDetail;
use App\Models\Log;
use Carbon\Carbon;
use Livewire\Component;

class Edit extends Component
{
    public Biometric $biometric;
    public $search = "";
    protected $rules = [
        'biometric.employees_detail_id' => 'required',
        'biometric.biometric_id' => 'required',
    ];

    public function selectEmployee($id)
    {
        $this->biometric->employees_detail_id = $id;
    }

    public function mount($id)
    {
        $this->biometric = Biometric::find($id);
    }
    public function save()
    {
        $this->validate();
        $this->biometric->save();

        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\Biometric';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has added a biometric for <strong>" . $this->biometric->employee->user->name . ' on ' . Carbon::parse($this->biometric->created_at)->format('j F, Y - h:i A') . "</strong>  in the system";
        $log->save();

        return redirect()->route('admin.biometrics.index');
    }
    public function render()
    {

        $employees = EmployeesDetail::whereHas('user', function ($query) {
            $query->where('first_name', 'like', '%' . $this->search . '%')
                ->orWhere('last_name', 'like', '%' . $this->search . '%');
        })->get();

        return view('livewire.admin.biometrics.edit', [
            'employees' => $employees,
        ]);
    }
}
