<?php

namespace App\Livewire\Admin\Bonuses;

use App\Exports\BonusesDataExport;
use App\Exports\BonusesTemplateExport;
use App\Exports\FinesDataExport;
use App\Models\Bonus;
use App\Models\Log;
use App\Models\Payroll;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

use function Deployer\timestamp;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'done' => 'render'
    ];

    public function delete($id)
    {
        try {
            $bonus  = Bonus::find($id);
            if (Payroll::where('month', $bonus->month)->where('year', $bonus->year)->first()->is_paid) {
                throw new \Exception("Payroll attached to this bonus is already paid", 1);
            }
            $bonus->delete();

            $log = new Log();
            $log->user_id = auth()->user()->id;
            $log->model = 'App\Models\Bonus';
            $log->payload = "<strong>" . auth()->user()->name . "</strong> has Deleted Bonus for <strong>" . $bonus->employee->user->name . ' on ' . Carbon::parse($bonus->created_at)->format('j F, Y - h:i A') . "</strong> amounting to <strong>KES " . number_format($bonus->amount_kes) . "</strong> in the system";

            $this->dispatch(
                'done',
                success: "Successfully Deleted the Bonus from the system"
            );
        } catch (\Throwable $th) {
            $this->dispatch(
                'done',
                error: "Something went wrong: " . $th->getMessage()
            );
            //throw $th;
        }
    }

    // function downloadBonusesData()
    // {
    //     return Excel::download(new BonusesDataExport, "Bonuses Data.xlsx");
    // }
    function downloadBonusesTemplate()
    {
        return Excel::download(new BonusesTemplateExport, "Bonuses Template - " . Carbon::now()->timestamp . ".xlsx");
    }

    public function render()
    {
        return view('livewire.admin.bonuses.index', [
            'bonuses' => Bonus::orderBy('created_at', 'DESC')->paginate(10)
        ]);
    }
}
