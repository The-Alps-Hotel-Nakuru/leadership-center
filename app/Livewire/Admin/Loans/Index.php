<?php

namespace App\Livewire\Admin\Loans;

use App\Models\Loan;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'done' => 'render'
    ];

    function delete($id)
    {
        $loan = Loan::find($id);

        if ($loan->hasBeganSettlement()) {
            $this->dispatch(
                'done',
                warning: 'The Loan has already began settlement. Cannot be deleted'
            );

            return;
        }

        $loan->delete();

        $this->dispatch(
            'done',
            success: 'This Loan record has been Successfully Deleted'
        );
    }
    public function render()
    {
        return view('livewire.admin.loans.index', [
            'loans' => Loan::orderBy('created_at', 'DESC')->paginate(10)
        ]);
    }
}
