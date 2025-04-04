<?php

namespace App\Livewire\Admin\Fines;

use App\Exports\FinesDataExport;
use App\Exports\FineTemplateExport;
use App\Models\Fine;
use App\Models\Log;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

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

        $this->dispatch(
            'done',
            success: "Successfully Deleted the Fine from the system"
        );
    }

    public function downloadTemplate()
    {
        return Excel::download(new FineTemplateExport, 'mass_fines_data.xlsx');
    }

    function downloadFinesData()
    {
        return Excel::download(new FinesDataExport, "Fines data.xlsx");
    }
    public function render()
    {
        return view('livewire.admin.fines.index', [
            'fines' => Fine::orderBy('id', 'DESC')->paginate(10)
        ]);
    }
}
