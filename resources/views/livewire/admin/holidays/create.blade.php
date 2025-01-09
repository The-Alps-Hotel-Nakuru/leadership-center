<div>
    <x-slot:header>Holidays</x-slot:header>

    <div class="card">
        <div class="card-header">
            <h5>Create a new Holiday</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="name">Name of Holiday</label>
                      <input wire:model.live='holiday.name' type="text"
                        class="form-control" name="name" id="name" aria-describedby="name" placeholder="Enter the name of the holiday">
                      @error('holiday.name')
                          <small id="name" class="form-text text-danger">{{ $message }}</small>
                      @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="date">Date of Holiday</label>
                      <input wire:model.live='holiday.date' type="date"
                        class="form-control" name="date" id="date" aria-describedby="date" placeholder="Enter the date of the holiday">
                      @error('holiday.date')
                          <small id="date" class="form-text text-danger">{{ $message }}</small>
                      @enderror
                    </div>
                </div>
            </div>
            <button wire:click='save' class="btn btn-dark text-uppercase">
                Save
            </button>
        </div>
    </div>
</div>
