<?php

namespace App\Http\Livewire\Admin\EventOrders;

use App\Models\ConferencePackage;
use App\Models\EventOrder;
use Livewire\Component;

class Edit extends Component
{
    public EventOrder $event_order;

    public $packages, $package_id;

    protected $rules = [
        'event_order.organization_name' => 'required',
        'event_order.event_name' => 'nullable',
        'event_order.contact_name' => 'required',
        'event_order.conference_hall_id' => 'required',
        'event_order.start_date' => 'required',
        'event_order.end_date' => 'required',
        'event_order.pax' => 'required',
        'event_order.table_setup' => 'nullable',
        'event_order.rate_kes' => 'required',
        'event_order.breakfast' => 'nullable',
        'event_order.early_morning_tea' => 'nullable',
        'event_order.midmorning_tea' => 'nullable',
        'event_order.lunch' => 'nullable',
        'event_order.afternoon_tea' => 'nullable',
        'event_order.dinner' => 'nullable',
        'event_order.meals' => 'nullable',
        'event_order.beverages' => 'nullable',
        'event_order.seminar_room' => 'nullable',
        'event_order.equipment' => 'nullable',
        'event_order.additions' => 'nullable',

    ];
    public function mount($id)
    {
        $this->event_order = EventOrder::find($id);
        $this->packages = ConferencePackage::all();
    }

    public function changedPackage()
    {
        $this->event_order->rate_kes = ConferencePackage::find($this->package_id)->rate_kes ?? null;
    }

    public function save()
    {
        $this->validate();
        $this->event_order->save();

        return redirect()->route('admin.event-orders.index');
    }

    public function render()
    {
        return view('livewire.admin.event-orders.edit');
    }
}
