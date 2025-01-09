<div>
    <x-slot:header>
        Leaves
    </x-slot:header>

    <div class="card">
        <div class="card-header">
            <h5>Edit this Leave Record</h5>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
                        <ul class="list-group mt-2 w-100">
                            <li class="list-group-item active">
                                {{ $leave->employee->user->name }}
                            </li>
                        </ul>

                    </div>
                </div>
                <div class="col-12">
                    <div class="mb-3">
                        <label for="" class="form-label">City</label>
                        <select wire:model.live='leave.leave_type_id' class="form-control" name="" id="">
                            <option selected>Select one</option>
                            @foreach ($leave_types as $type)
                                <option value="{{ $type->id }}">{{ $type->title }}</option>
                            @endforeach
                        </select>
                        @error('leave.leave_type_id')
                            <small id="time" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input wire:model.live="leave.start_date" type="date" class="form-control" name="time"
                            id="time" aria-describedby="time" placeholder="Enter the Start Date Applied For">
                        @error('leave.start_date')
                            <small id="time" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input wire:model.live="leave.end_date" type="date" class="form-control" name="time"
                            id="time" aria-describedby="time" placeholder="Enter the End Date Applied For">
                        @error('leave.end_date')
                            <small id="time" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <button wire:click="save" class="btn btn-dark text-uppercase">Save</button>
        </div>
    </div>
</div>
