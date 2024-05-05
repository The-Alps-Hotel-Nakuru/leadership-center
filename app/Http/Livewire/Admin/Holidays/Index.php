<?php

namespace App\Http\Livewire\Admin\Holidays;

use App\Models\Holiday;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function delete($id)
    {
        $holiday = Holiday::find($id);

        if ($holiday->is_covered) {
            $this->emit(
                "done",
                ["warning" => "Cannot delete this holiday as it has already been accounted for in a Payroll Payment"]
            );

            return;
        }

        $holiday->delete();
        $this->emit(
            "done",
            ["success" => "Successfully Deleted the Holiday"]
        );
    }

    public function render()
    {
        return view('livewire.admin.holidays.index', [
            'holidays' => Holiday::orderBy('date', 'desc')->paginate(10),
        ]);
    }
}
