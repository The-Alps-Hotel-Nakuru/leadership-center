<div>
    <x-slot name="header">Asset Subcategories</x-slot>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5>Create a new Asset Subcategory</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8 col-12">
                        <div class="mb-3">
                          <label for="asset_subcategory.title" class="form-label">Title</label>
                          <input wire:model="asset_subcategory.title" type="text"
                            class="form-control" name="asset_subcategory.title" id="asset_subcategory.title" aria-describedby="title" placeholder="Enter the Title of your Subcategory">
                          @error('asset_subcategory.title')
                          <small id="title" class="form-text text-danger">{{ $message }}</small>
                          @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                          <label for="asset_category_id" class="form-label">Asset Category</label>
                          <select wire:model="asset_subcategory.asset_category_id" class="form-control" name="asset_category_id" id="asset_category_id">
                            <option>Select The Asset Category it belongs to</option>
                            @foreach (App\Models\AssetCategory::all() as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                            @endforeach

                          </select>
                        </div>
                    </div>
                </div>
                <button wire:click="save" class="btn btn-dark text-uppercase">
                    Save
                </button>
            </div>
        </div>
    </div>
</div>
