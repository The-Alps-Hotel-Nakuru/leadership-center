<?php

namespace App\Livewire\Admin\Fines;

use App\Models\EmployeesDetail;
use App\Models\Fine;
use App\Models\Log;
use Carbon\Carbon;
use Livewire\Component;

class Create extends Component
{
    public Fine $fine;
    public $yearmonth;
    public $search = "";

    protected $rules = [
        'yearmonth' => 'required',
        'fine.employees_detail_id' => 'required',
        'fine.amount_kes' => 'required',
        'fine.reason' => 'nullable',
    ];

    public function selectEmployee($id)
    {
        $this->fine->employees_detail_id = $id;
    }


    public function mount()
    {
        $this->fine = new Fine();
        $this->yearmonth = Carbon::now()->format('Y-m');
    }
    public function save()
    {
        $this->validate();
        $this->fine->year = Carbon::parse($this->yearmonth)->year;
        $this->fine->month = Carbon::parse($this->yearmonth)->month;
        $this->fine->created_by = auth()->user()->id;
        $this->fine->save();

        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\Fine';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has Created a new Fine for <strong>" . $this->fine->employee->user->name . ' on ' . Carbon::parse($this->fine->created_at)->format('j F, Y - h:i A') . "</strong> now amounting to <strong>KES " . number_format($this->fine->amount_kes, 2) . "</strong> in the system";
        $log->save();

        return redirect()->route('admin.fines.index');
    }
    public function render()
    {
        $employees = EmployeesDetail::whereHas('user', function ($query) {
            $query->whereRaw("CONCAT(first_name, ' ', last_name) like ?", ['%' . $this->search . '%']);
        })->get();

        return view('livewire.admin.fines.create', [
            'employees' => $employees,
        ]);
    }
}
