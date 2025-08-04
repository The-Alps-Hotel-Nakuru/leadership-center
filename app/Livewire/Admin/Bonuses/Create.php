<?php

namespace App\Livewire\Admin\Bonuses;

use App\Models\Bonus;
use App\Models\EmployeesDetail;
use App\Models\Log;
use Carbon\Carbon;
use Livewire\Component;

class Create extends Component
{
    public Bonus $bonus;
    public $yearmonth;
    public $search = "";
    protected $rules = [
        'yearmonth' => 'required',
        'bonus.employees_detail_id' => 'required',
        'bonus.amount_kes' => 'required',
        'bonus.reason' => 'nullable',
    ];

    public function selectEmployee($id)
    {
        $this->bonus->employees_detail_id = $id;
    }

    public function mount()
    {
        $this->bonus = new Bonus();
        $this->yearmonth = Carbon::now()->format('Y-m');
    }
    public function save()
    {
        $this->validate();
        $this->bonus->year = Carbon::parse($this->yearmonth)->year;
        $this->bonus->month = Carbon::parse($this->yearmonth)->month;
        $this->bonus->created_by = auth()->user()->id;
        $this->bonus->save();

        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\Bonus';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has added a bonus for <strong>" . $this->bonus->employee->user->name . ' on ' . Carbon::parse($this->bonus->created_at)->format('j F, Y - h:i A') . "</strong> amounting to <strong>KES " . number_format($this->bonus->amount_kes, 2) . "</strong> in the system";
        $log->save();

        return redirect()->route('admin.bonuses.index');
    }
    public function render()
    {

        $employees = EmployeesDetail::whereHas('user', function ($query) {
            $query->whereraw("concat(first_name, ' ', last_name) like ?", ['%' . $this->search . '%']);
        })->get();

        return view('livewire.admin.bonuses.create', [
            'employees' => $employees,
        ]);
    }
}
