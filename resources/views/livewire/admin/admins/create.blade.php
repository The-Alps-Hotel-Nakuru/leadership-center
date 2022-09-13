<div>
    <x-slot name="header">System Administrators</x-slot>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4>Create a new Administrator</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                          <label for="first_name" class="form-label">First Name</label>
                          <input type="text" wire:model='admin.first_name'
                            class="form-control" name="" id="" aria-describedby="name" placeholder="Enter the First Name">
                          @error('admin.first_name')
                              <small id="name" class="form-text text-danger">{{ $message }}</small>
                          @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
