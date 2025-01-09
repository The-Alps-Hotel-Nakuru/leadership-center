<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    <x-slot name="header">
        Edit this Designation
    </x-slot>

    <div class="">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="" class="form-label">Department</label>
                            <select wire:model.live="designation.department_id" class="form-control " name=""
                                id="">
                                <option selected>Select a Department</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->title }}</option>
                                @endforeach
                            </select>
                            @error('designation.department_id')
                                <small id="title" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" wire:model.live="designation.title" class="form-control" name="title"
                                id="title" aria-describedby="title" placeholder="Enter your Designation Title">
                            @error('designation.title')
                                <small id="title" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="" class="form-label">Legible for Attendance Penalty</label>
                            <select wire:model.live='designation.is_penalizable' class="form-control" name=""
                                id="">
                                <option selected>Select one</option>
                                <option value="1">True</option>
                                <option value="0">False</option>
                            </select>
                            @error('designation.is_penalizable')
                                <small id="title" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                </div>
                <button class="btn btn-primary" wire:click="save">SAVE</button>
            </div>
        </div>
    </div>
</div>
