<?php

namespace App\Http\Livewire\Admin\Biometrics;

use App\Models\Biometric;
use App\Models\EmployeesDetail;
use App\Models\Log;
use Carbon\Carbon;
use Livewire\Component;

class Create extends Component
{
    public Biometric $biometric;
    public $search = "";
    protected $rules = [
        'biometric.employees_detail_id' => 'required',
        'biometric.biometric_id' => 'required|unique:biometrics,biometric_id',
    ];

    public function selectEmployee($id)
    {
        $this->biometric->employees_detail_id = $id;
    }

    public function mount()
    {
        $this->biometric = new Biometric();
    }
    public function save()
    {
        $this->validate();
        $this->biometric->save();

        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\Biometric';
        $log->payload = "added a biometric for <strong>" . $this->biometric->employee->user->name . ' on ' . Carbon::parse($this->biometric->created_at)->format('j F, Y - h:i A') . "</strong> in the system";
        $log->save();

        return redirect()->route('admin.biometrics.index');
    }
    public function render()
    {

        $employees = EmployeesDetail::whereHas('user', function ($query) {
            $query->whereraw("concat(first_name, ' ', last_name) like ?", ['%' . $this->searchemployee . '%']);
        })->get();

        return view('livewire.admin.biometrics.create', [
            'employees' => $employees,
        ]);
    }
}
