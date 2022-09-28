<?php

namespace App\Http\Livewire\Admin\AssetCategories;

use App\Models\AssetCategory;
use Livewire\Component;

class Edit extends Component
{
    public AssetCategory $asset_category;

    protected $rules = [
        'asset_category.title'=>'required',
        'asset_category.description'=>'nullable',
    ];

    public function mount($id)
    {
        $this->asset_category = AssetCategory::find($id);
    }

    public function save()
    {
        $this->validate();

        $this->asset_category->updated_by = auth()->user()->id;

        $this->asset_category->save();

        return redirect()->route('admin.asset_categories.index');
    }
    public function render()
    {
        return view('livewire.admin.asset-categories.edit');
    }
}
