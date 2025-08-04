<?php

namespace App\Livewire\Admin\Advances;

use App\Exports\AdvancesDataExport;
use App\Models\Advance;
use App\Models\Log;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // function downloadAdvancesData()
    // {
    //     return Excel::download(new AdvancesDataExport, "Advances Data.xlsx");
    // }

    public function delete($id)
    {
        $advance  = Advance::find($id);
        $advance->delete();

        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\Fine';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has Deleted Fine for <strong>" . $advance->employee->user->name . ' on ' . Carbon::parse($advance->created_at)->format('j F, Y - h:i A') . "</strong> amounting to <strong>KES " . number_format($advance->amount_kes, 2) . "</strong> in the system";

        $this->dispatch(
            'done',
            success: "Successfully Deleted the Fine from the system"
        );
    }

    public function render()
    {
        return view('livewire.admin.advances.index', [
            'advances' => Advance::orderBy('created_at','DESC')->paginate(5)
        ]);
    }
}
