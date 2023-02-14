<?php

namespace App\Http\Livewire\Admin\Fines;

use App\Models\Fine;
use App\Models\Log;
use Carbon\Carbon;
use Livewire\Component;

class Edit extends Component
{
    public Fine $fine;
    public $yearmonth;
    protected $rules = [
        'yearmonth' => 'required',
        'fine.employees_detail_id' => 'required',
        'fine.amount_kes' => 'required',
        'fine.reason' => 'nullable',
    ];

    public function mount($id)
    {
        $this->fine = Fine::find($id);
        $this->yearmonth = $this->fine->year . '-' . sprintf("%02d", $this->fine->month);
    }
    public function save()
    {
        $this->validate();
        $this->fine->year = Carbon::parse($this->yearmonth)->year;
        $this->fine->month = Carbon::parse($this->yearmonth)->month;
        $this->fine->updated_by = auth()->user()->id;
        $this->fine->save();

        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\Fine';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has Edited the Fine for <strong>" . $this->fine->employee->user->name . ' on ' . Carbon::parse($this->bonus->created_at)->format('j F, Y - h:i A') . "</strong> now amounting to <strong>KES " . number_format($this->bonus->amount_kes) . "</strong> in the system";
        $log->save();

        return redirect()->route('admin.fines.index');
    }
    public function render()
    {
        return view('livewire.admin.fines.edit');
    }
}
