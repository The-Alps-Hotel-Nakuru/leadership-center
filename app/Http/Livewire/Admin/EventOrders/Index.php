<?php

namespace App\Http\Livewire\Admin\EventOrders;

use App\Models\EventOrder;
use App\Models\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $newOrders = 0;
    public $lunch_today = 0;
    public $dinner_today = 0;
    public $groups_lunch = [];
    public $groups_dinner = [];

    public function mount()
    {
        foreach (EventOrder::all() as $order) {
            if ($order->newOrder) {
                $this->newOrders++;
            }

            if (Carbon::now()->isBetween($order->start_date, $order->end_date) && $order->lunch) {
                $this->lunch_today += $order->pax;
                array_push($this->groups_lunch, $order->organization_name);
            }
            if (Carbon::now()->isBetween($order->start_date, $order->end_date) && $order->dinner) {
                $this->dinner_today += $order->pax;
                array_push($this->groups_dinner, $order->organization_name);
            }
        }
    }

    public function generateToday()
    {
        $pdf =  Pdf::setOptions(['defaultFont' => 'sans-serif']);



        return response()->streamDownload(
            fn () => print($pdf->loadView('doc.summary', [
                'date' => Carbon::now()->toDateString(),
            ])),
            "file1.pdf"
        );
    }


    public function delete($id)
    {
        EventOrder::find($id)->delete();

        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\EventOrder';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has Deleted Event Order <strong> #" . sprintf('%04u', $id) . " </strong> from the system";
        $log->save();

        $this->emit('done', [
            'success' => 'Successfully Deleted Event Order no. ' . sprintf('%04u', $id)
        ]);
    }

    public function render()
    {
        return view('livewire.admin.event-orders.index', [
            'event_orders' => EventOrder::orderBy('start_date', 'DESC')->paginate(10)
        ]);
    }
}
