<?php

namespace App\Http\Livewire\Admin\Advances;

use App\Models\Advance;
use App\Models\EmployeesDetail;
use App\Models\Log;
use Carbon\Carbon;
use Livewire\Component;

class Edit extends Component
{
    public $search = "";
    public $selectedEmployee;
    public Advance $advance;
    public $yearmonth;
    protected $rules = [
        'yearmonth' => 'required',
        'advance.amount_kes' => 'required',
        'advance.transaction' => 'required',
        'advance.reason' => 'nullable',
    ];

    public function mount($id)
    {
        $this->advance = Advance::find($id);
        $this->yearmonth = Carbon::now()->format('Y-m');
        $this->selectedEmployee = $this->advance->employees_detail_id;
        $this->search = $this->advance->employee->user->first_name;
    }
    public function selectEmployee($id)
    {
        $this->selectedEmployee = $id;
    }

    public function save()
    {
        $this->validate();
        $this->advance->employees_detail_id = $this->selectedEmployee;
        $this->advance->year = Carbon::parse($this->yearmonth)->year;
        $this->advance->month = Carbon::parse($this->yearmonth)->month;
        $this->advance->created_by = auth()->user()->id;
        $this->advance->save();

        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\Advance';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has Updated the advance for <strong>" . $this->advance->employee->user->name . ' on ' . Carbon::parse($this->advance->created_at)->format('j F, Y - h:i A') . "</strong> amounting to <strong>KES " . number_format($this->advance->amount_kes) . "</strong> in the system";
        $log->save();

        return redirect()->route('admin.advances.index');
    }

    public function render()
    {
        $employees = EmployeesDetail::whereHas('user', function ($query) {
            $query->where('first_name', 'like', '%' . $this->search . '%')
                ->orWhere('last_name', 'like', '%' . $this->search . '%');
        })->get();
        return view('livewire.admin.advances.edit', [
            'employees' => $employees
        ]);
    }
}
