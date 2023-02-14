<?php

namespace App\Http\Livewire\Admin\Bonuses;

use App\Models\Bonus;
use App\Models\Log;
use Carbon\Carbon;
use Livewire\Component;

class Index extends Component
{
    protected $listeners = [
        'done' => 'render'
    ];

    public function delete($id)
    {
        $bonus  = Bonus::find($id);
        $bonus->delete();

        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\Bonus';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has Deleted Bonus for <strong>" . $bonus->employee->user->name . ' on ' . Carbon::parse($bonus->created_at)->format('j F, Y - h:i A') . "</strong> amounting to <strong>KES " . number_format($bonus->amount_kes) . "</strong> in the system";

        $this->emit('done', [
            'success' => "Successfully Deleted the Bonus from the system"
        ]);
    }
    public function render()
    {
        return view('livewire.admin.bonuses.index', [
            'bonuses' => Bonus::all()
        ]);
    }
}
