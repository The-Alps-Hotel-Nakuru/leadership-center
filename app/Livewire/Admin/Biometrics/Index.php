<?php

namespace App\Livewire\Admin\Biometrics;

use App\Models\Biometric;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'done' => 'render'
    ];
    public function render()
    {
        return view('livewire.admin.biometrics.index', [
            'biometrics' => Biometric::orderBy('created_at', 'DESC')->paginate(10)
        ]);
    }
}
