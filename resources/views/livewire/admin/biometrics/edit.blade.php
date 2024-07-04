<div>
    <x-slot:header>Edit Biometric Record</x-slot:header>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5>Edit this Biometric Record for an Employee</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <input type="text" class="form-control" wire:model="search" placeholder="Search employees">
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <ul class="list-group mt-2 w-100">
                                @if ($search != '')
                                    @foreach ($employees as $employee)
                                        <li wire:click="selectEmployee({{ $employee->id }})"
                                            class="list-group-item {{ $biometric->employees_detail_id == $employee->id ? 'active' : '' }}">
                                            {{ $employee->user->name }}
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                            @error('biometric.employees_detail_id')
                                <small id="time" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-3">
                            <label for="biometric.biometric_id" class="form-label">Biometric ID</label>
                            <input type="number" wire:model="biometric.biometric_id" class="form-control" />
                            @error('biometric.biometric_id')
                                <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <button wire:click="save" class="btn btn-dark">SAVE</button>
            </div>
        </div>
    </div>
</div>
