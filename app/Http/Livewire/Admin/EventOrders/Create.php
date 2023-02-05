<?php

namespace App\Http\Livewire\Admin\EventOrders;

use App\Models\ConferencePackage;
use App\Models\EventOrder;
use App\Models\Log;
use Livewire\Component;

class Create extends Component
{
    public EventOrder $event_order;

    public $packages, $package_id;

    public $conference_halls;

    protected $rules = [
        'event_order.organization_name' => 'required',
        'event_order.event_name' => 'nullable',
        'event_order.contact_name' => 'required',
        'conference_halls' => 'required',
        'event_order.start_date' => 'required',
        'event_order.end_date' => 'required',
        'event_order.pax' => 'required',
        'event_order.table_setup' => 'nullable',
        'event_order.rate_kes' => 'required',
        'event_order.breakfast' => 'boolean',
        'event_order.early_morning_tea' => 'boolean',
        'event_order.midmorning_tea' => 'boolean',
        'event_order.lunch' => 'boolean',
        'event_order.afternoon_tea' => 'boolean',
        'event_order.dinner' => 'boolean',
        'event_order.meals' => 'nullable',
        'event_order.beverages' => 'nullable',
        'event_order.seminar_room' => 'nullable',
        'event_order.equipment' => 'nullable',
        'event_order.additions' => 'nullable',

    ];
    public function mount()
    {
        $this->event_order = new EventOrder();
        $this->packages = ConferencePackage::all();
        $this->event_order->breakfast = false;
        $this->event_order->early_morning_tea = false;
        $this->event_order->midmorning_tea = false;
        $this->event_order->lunch = false;
        $this->event_order->afternoon_tea = false;
        $this->event_order->dinner = false;
    }

    public function changedPackage()
    {
        $this->event_order->rate_kes = ConferencePackage::find($this->package_id)->rate_kes ?? null;
    }

    public function save()
    {
        $this->validate();
        $this->event_order->save();
        foreach ($this->conference_halls as $key => $value) {
            $this->event_order->conferenceHalls()->attach($value);
        }

        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\EventOrder';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has created a new Event Order for <strong> " . $this->event_order->organization_name . "</strong> in the system";
        $log->save();

        return redirect()->route('admin.event-orders.index');
    }
    public function render()
    {
        return view('livewire.admin.event-orders.create');
    }
}
