<?php

namespace App\Http\Livewire\Admin\WelfareContributions;

use App\Exports\StaffWelfareExport;
use App\Exports\WelfareContributionExport;
use App\Models\WelfareContribution;
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
