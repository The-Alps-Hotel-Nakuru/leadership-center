<?php

namespace App\Http\Livewire\Admin;

use App\Models\EventOrder;
use App\Models\Log;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component

{
    use WithPagination;

    public $monthearnings = 0;
    public $increase = 0;
    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $orders = EventOrder::all();

        foreach ($orders as $order) {
            if ($order->isDuringMonthOf(Carbon::now())) {
                $this->monthearnings += $order->earnings;
            }
        }

        $lastearning = 0;
        foreach ($orders as $order) {
            if ($order->isDuringMonthOf(Carbon::now()->subMonth())) {
                $lastearning += $order->earnings;
            }
        }

        $this->increase = (($this->monthearnings - $lastearning) / $lastearning) * 100;
    }


    public function render()
    {
        return view('livewire.admin.dashboard', [
            'logs' => Log::orderBy('id', 'DESC')->paginate(10)
        ]);
    }
}
