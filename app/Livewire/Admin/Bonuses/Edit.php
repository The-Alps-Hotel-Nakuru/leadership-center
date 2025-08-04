<?php

namespace App\Livewire\Admin\Bonuses;

use App\Models\Bonus;
use App\Models\Log;
use Carbon\Carbon;
use Livewire\Component;

class Edit extends Component
{
    public Bonus $bonus;
    public $yearmonth;
    protected $rules = [
        'yearmonth' => 'required',
        'bonus.employees_detail_id' => 'required',
        'bonus.amount_kes' => 'required',
        'bonus.reason' => 'nullable',
    ];

    public function mount($id)
    {
        $this->bonus = Bonus::find($id);
        $this->yearmonth = $this->bonus->year . '-' . sprintf("%02d", $this->bonus->month);
    }
    public function save()
    {
        $this->validate();
        $this->bonus->year = Carbon::parse($this->yearmonth)->year;
        $this->bonus->month = Carbon::parse($this->yearmonth)->month;
        $this->bonus->updated_by = auth()->user()->id;
        $this->bonus->save();

        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\Bonus';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has Edited the bonus for <strong>" . $this->bonus->employee->user->name . ' on ' . Carbon::parse($this->bonus->created_at)->format('j F, Y - h:i A') . "</strong> now amounting to <strong>KES " . number_format($this->bonus->amount_kes, 2) . "</strong> in the system";
        $log->save();

        return redirect()->route('admin.bonuses.index');
    }
    public function render()
    {
        return view('livewire.admin.bonuses.edit');
    }
}
