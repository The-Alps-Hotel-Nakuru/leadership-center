<?php

namespace App\Http\Livewire\Admin\AssetCategories;

use App\Models\AssetCategory;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public function mount()
    {
        # code...
    }

    public function delete($id)
    {
        AssetCategory::find($id)->delete();

        $this->emit('done', [
            'success'=>'Successfully Deleted Asset Category No.'.$id
        ]);
    }

    public function render()
    {
        return view('livewire.admin.asset-categories.index',[
            'asset_categories'=>AssetCategory::orderBy('updated_at', 'DESC')->orderBy('id', 'DESC')->paginate(5)
        ]);
    }
}
