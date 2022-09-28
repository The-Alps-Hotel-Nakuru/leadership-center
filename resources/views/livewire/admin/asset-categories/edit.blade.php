<div>
    <x-slot name="header">Asset Categories</x-slot>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5>Edit Category</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8 col-12">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" wire:model="asset_category.title" name="title"
                                id="title" aria-describedby="asset_category.title" placeholder="Enter your title">
                            @error('asset_category.title')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="asset_category.description" class="form-label">Description <small class="text-muted">(optional)</small></label>
                            <textarea class="form-control" wire:model="asset_category.description" name="asset_category.description" id="asset_category.description" rows="3"
                                placeholder="Enter the Description"></textarea>
                            @error('asset_category.description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
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
