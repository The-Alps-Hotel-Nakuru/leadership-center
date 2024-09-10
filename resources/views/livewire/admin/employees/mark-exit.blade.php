<div>
    <x-slot:header>Mark Exit of Employee</x-slot:header>

    <div class="card">
        <div class="card-header">
            <h5>Choose the Date of Exit for {{ $employee->user->name }}</h5>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" class="form-control" name="date" id="date" aria-describedby="date"
                    wire:model='date' placeholder="">
                @error('date')
                    <small id="date" class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-dark text-uppercase" wire:click='save'>Save</button>
        </div>
    </div>
</div>
