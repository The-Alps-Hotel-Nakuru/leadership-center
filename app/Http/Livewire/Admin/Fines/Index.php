<?php

namespace App\Http\Livewire\Admin\Fines;

use App\Models\Fine;
use App\Models\Log;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $listeners = [
        'done' => 'render'
    ];

    protected $paginationTheme = 'bootstrap';

    public function delete($id)
    {
        $fine  = Fine::find($id);
        $fine->delete();

        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\Fine';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has Deleted Fine for <strong>" . $fine->employee->user->name . ' on ' . Carbon::parse($fine->created_at)->format('j F, Y - h:i A') . "</strong> amounting to <strong>KES " . number_format($fine->amount_kes) . "</strong> in the system";

        $this->emit('done', [
            'success' => "Successfully Deleted the Fine from the system"
        ]);
    }
    public function render()
    {
        return view('livewire.admin.fines.index', [
            'fines' => Fine::paginate(10)
        ]);
    }
}
