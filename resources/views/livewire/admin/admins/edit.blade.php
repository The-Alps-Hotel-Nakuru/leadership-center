<div>
    <x-slot name="header">System Administrators</x-slot>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4>Edit {{$admin->name}}'s Details</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" wire:model='admin.first_name' class="form-control" name=""
                                id="" aria-describedby="name" placeholder="Enter the First Name">
                            @error('admin.first_name')
                                <small id="name" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" wire:model='admin.last_name' class="form-control" name=""
                                id="" aria-describedby="name" placeholder="Enter the Last Name">
                            @error('admin.last_name')
                                <small id="name" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" wire:model='admin.email' class="form-control" name=""
                                id="" aria-describedby="email" placeholder="Enter the Email Address">
                            @error('admin.email')
                                <small id="name" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="admin.role_id" class="form-label">Administrator Type</label>
                            <select class="form-control" wire:model="admin.role_id" name="admin.role_id" id="admin.role_id">
                                <option selected>Select the Type of Administrator</option>
                                @if (auth()->user()->is_super)
                                    <option value="1">Super Administrator</option>
                                @endif
                                <option value="2">Junior Administrator</option>
                            </select>

                            @error('admin.role_id')
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
