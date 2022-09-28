<?php

namespace App\Http\Livewire\Admin\AssetSubcategories;

use App\Models\AssetSubcategory;
use Livewire\Component;

class Create extends Component
{
    public AssetSubcategory $asset_subcategory;

    protected $rules = [
        'asset_subcategory.title'=>'required',
        'asset_subcategory.asset_category_id'=>'required',
    ];

    public function mount()
    {
        $this->asset_subcategory = new AssetSubcategory();
    }

    public function save()
    {
        $this->validate();

        $this->asset_subcategory->created_by = auth()->user()->id;

        $this->asset_subcategory->save();

        return redirect()->route('admin.asset_subcategories.index');
    }
    public function render()
    {
        return view('livewire.admin.asset-subcategories.create');
    }
}
