<div>
    <x-slot name="header">Designation Responsibilities </x-slot>
    <div class="container-fluid">
        <div class="card ">
            <div class="card-header">
                <h5>Edit a  Responsibility</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="responsibility" class="form-label">Responsibility Definition</label>
                    <textarea wire:model="responsibility.responsibility" class="form-control" name="responsibility" id="responsibility"
                        rows="3"></textarea>
                    @error('responsibility.responsibility')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <button wire:click="save" class="btn btn-dark text-uppercase">Save</button>
            </div>
        </div>
    </div>
    </div>
</div>
