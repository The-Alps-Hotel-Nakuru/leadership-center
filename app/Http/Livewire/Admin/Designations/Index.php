<?php

namespace App\Http\Livewire\Admin\Designations;

use App\Models\Designation;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    
    public function render()
    {
        return view('livewire.admin.designations.index', [
            'designations'=>Designation::paginate(10)
        ]);
    }
}
