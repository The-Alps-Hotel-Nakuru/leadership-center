<div>
    <x-slot:header>Edit this Bank</x-slot:header>

    <div class="card">
        <div class="card-header bg-transparent border-0">
            <h5>Edit this Bank</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 col-12">
                    <div class="mb-3">
                        <label for="" class="form-label">Bank Full Name</label>
                        <input type="text" class="form-control" name="" id="" aria-describedby="helpId"
                            placeholder="Enter the name of the Bank" wire:model='bank.name' />
                        @error('bank.name')
                            <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="mb-3">
                        <label for="" class="form-label">Bank Short Name</label>
                        <input type="text" class="form-control" name="" id=""
                            aria-describedby="helpId" placeholder="Enter the Short Name" wire:model='bank.short_name' />
                        @error('bank.short_name')
                            <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="mb-3">
                        <label for="" class="form-label">Bank Code</label>
                        <input type="text" class="form-control" name="" id=""
                            aria-describedby="helpId" placeholder="Enter the SORT Code" wire:model='bank.bank_code' />
                        @error('bank.bank_code')
                            <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="mb-3">
                        <label for="" class="form-label">Minimum Transfer Amount</label>
                        <input type="number" step="0.01" min="0.01" class="form-control" name=""
                            id="" aria-describedby="helpId" wire:model='bank.min_transfer' />
                        @error('bank.min_transfer')
                            <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="mb-3">
                        <label for="" class="form-label">Bank Code</label>
                        <input type="number" step="0.01" min="0.01" class="form-control" name=""
                            id="" aria-describedby="helpId" wire:model='bank.max_transfer' />
                        @error('bank.max_transfer')
                            <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <button class="btn btn-primary" wire:click='save'>Save</button>
        </div>
    </div>
</div>
