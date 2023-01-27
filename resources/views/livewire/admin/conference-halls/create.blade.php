<div>
    <x-slot name="header">
        Conference Halls
    </x-slot>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5>Create a new Conference Hall</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Hall name</label>
                            <input type="text" wire:model="hall.name" class="form-control" name="name" id="name"
                                aria-describedby="name" placeholder="Enter the name of the Conference Hall">
                            @error('hall.name')
                                <small id="name" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="location" class="form-label">Hall Location</label>
                            <select class="form-select" wire:model="hall.location_id" name="location" id="location">
                                <option selected>Select a location</option>
                                @foreach (App\Models\Location::all() as $location)
                                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                                @endforeach
                            </select>
                            @error('hall.location_id')
                                <small id="name" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <button class="btn btn-dark" wire:click="save">SAVE</button>
            </div>
        </div>
    </div>
</div>
