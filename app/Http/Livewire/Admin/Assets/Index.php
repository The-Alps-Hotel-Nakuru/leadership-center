<?php

namespace App\Http\Livewire\Admin\Assets;

use App\Models\Asset;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{

    public $assets;

    public function mount()
    {
        $this->assets = Asset::all();
    }


    public function render()
    {
        return view('livewire.admin.assets.index');
    }
}
