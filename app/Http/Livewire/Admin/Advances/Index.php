<?php

namespace App\Http\Livewire\Admin\Advances;

use App\Exports\AdvancesDataExport;
use App\Models\Advance;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    function downloadAdvancesData()
    {
        return Excel::download(new AdvancesDataExport, "Advances Data.xlsx");
    }

    public function render()
    {
        return view('livewire.admin.advances.index', [
            'advances' => Advance::orderBy('created_at','DESC')->paginate(5)
        ]);
    }
}
