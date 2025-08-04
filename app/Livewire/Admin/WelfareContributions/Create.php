<?php

namespace App\Livewire\Admin\WelfareContributions;

use App\Models\EmployeesDetail;
use App\Models\Log;
use App\Models\WelfareContribution;
use Carbon\Carbon;
use Livewire\Component;

class Create extends Component
{

    public WelfareContribution $welfare_contribution;
    public $yearmonth;
    public $search = "";

    protected $rules = [
        'yearmonth' => 'required',
        'welfare_contribution.employees_detail_id' => 'required',
        'welfare_contribution.amount_kes' => 'required',
        'welfare_contribution.reason' => 'nullable',
    ];

    public function selectEmployee($id)
    {
        $this->welfare_contribution->employees_detail_id = $id;
        $this->search = $this->welfare_contribution->employee->user->name;
    }


    public function mount()
    {
        $this->welfare_contribution = new WelfareContribution();
        $this->yearmonth = Carbon::now()->format('Y-m');
    }
    public function save()
    {
        $this->validate();
        $this->welfare_contribution->year = Carbon::parse($this->yearmonth)->year;
        $this->welfare_contribution->month = Carbon::parse($this->yearmonth)->month;
        $this->welfare_contribution->created_by = auth()->user()->id;
        $this->welfare_contribution->save();

        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\Fine';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has Created a new Welfare Contribution for <strong>" . $this->welfare_contribution->employee->user->name . ' on ' . Carbon::parse($this->welfare_contribution->created_at)->format('j F, Y - h:i A') . "</strong> now amounting to <strong>KES " . number_format($this->welfare_contribution->amount_kes, 2) . "</strong> in the system";
        $log->save();

        return redirect()->route('admin.welfare_contributions.index');
    }
    public function render()
    {
        $employees = EmployeesDetail::whereHas('user', function ($query) {
            $query->whereRaw("CONCAT(first_name, ' ', last_name) like ?", ['%' . $this->search . '%']);
        })->get();

        return view('livewire.admin.welfare-contributions.create', [
            'employees'=>$employees
        ]);
    }
}
