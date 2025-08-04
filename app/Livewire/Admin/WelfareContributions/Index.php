<?php

namespace App\Livewire\Admin\WelfareContributions;

use App\Exports\StaffWelfareExport;
use App\Exports\WelfareContributionExport;
use App\Models\Log;
use App\Models\WelfareContribution;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = [
        'done' => 'render'
    ];

    public function delete($id)
    {
        $welfare_contribution  = WelfareContribution::find($id);
        $welfare_contribution->delete();

        $log = new Log();
        $log->user_id = auth()->user()->id;
        $log->model = 'App\Models\Fine';
        $log->payload = "<strong>" . auth()->user()->name . "</strong> has Deleted Welfare Contribution for <strong>" . $welfare_contribution->employee->user->name . ' on ' . Carbon::parse($welfare_contribution->created_at)->format('j F, Y - h:i A') . "</strong> amounting to <strong>KES " . number_format($welfare_contribution->amount_kes, 2) . "</strong> in the system";

        $this->dispatch(
            'done',
            success: "Successfully Deleted the Fine from the system"
        );
    }

    function downloadWelfareContributionsData()
    {
        return Excel::download(new StaffWelfareExport, "Welfare Contribution Data.xlsx");
    }


    public function render()
    {
        return view(
            'livewire.admin.welfare-contributions.index',
            [
                'welfare_contributions' => WelfareContribution::orderBy('id', 'DESC')->paginate(10)
            ]
        );
    }
}
