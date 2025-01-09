<div>
    <x-slot name="header">Security</x-slot>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4>Create a new Security guard</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" wire:model.live='security_guard.first_name' class="form-control" name=""
                                id="" aria-describedby="name" placeholder="Enter the First Name">
                            @error('security_guard.first_name')
                                <small id="name" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" wire:model.live='security_guard.last_name' class="form-control" name=""
                                id="" aria-describedby="name" placeholder="Enter the Last Name">
                            @error('security_guard.last_name')
                                <small id="name" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" wire:model.live='security_guard.email' class="form-control" name=""
                                id="" aria-describedby="email" placeholder="Enter the Email Address">
                            @error('security_guard.email')
                                <small id="name" class="form-text text-danger">{{ $message }}</small>
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
