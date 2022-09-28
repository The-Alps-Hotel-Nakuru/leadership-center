<?php

namespace App\Http\Livewire\Admin\AssetCategories;

use App\Models\AssetCategory;
use Livewire\Component;

class Create extends Component
{
    public AssetCategory $asset_category;

    protected $rules = [
        'asset_category.title'=>'required',
        'asset_category.description'=>'nullable',
    ];

    public function mount()
    {
        $this->asset_category = new AssetCategory();
    }

    public function save()
    {
        $this->validate();

        $this->asset_category->created_by = auth()->user()->id;

        $this->asset_category->save();

        return redirect()->back();
    }
    public function render()
    {
        return view('livewire.admin.asset-categories.create');
    }
}
