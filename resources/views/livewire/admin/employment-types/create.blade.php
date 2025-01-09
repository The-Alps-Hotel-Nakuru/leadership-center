<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    <x-slot:header>Employment Types</x-slot:header>

    <div class="card">
        <div class="card-header">
            <h5>Create Employment Type</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="title">Title</label>
                      <input type="text"
                        class="form-control" wire:model.live='type.title' name="title" id="title" aria-describedby="title" placeholder="Enter your Title">
                      @error('type.title')
                          <small id="title" class="form-text text-danger">{{ $message }}</small>
                      @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="">Rate Type</label>
                      <select wire:model.live='type.rate_type' class="form-control" name="rate_type" id="">
                        <option>Select a Compensation Accumulative Rate Type</option>
                        <option value="daily">Daily</option>
                        <option value="monthly">Monthly</option>
                      </select>
                      @error('type.rate_type')
                          <small id="title" class="form-text text-danger">{{ $message }}</small>
                      @enderror
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                      <label for="">Penalizable on Attendance</label>
                      <select wire:model.live='type.is_penalizable' class="form-control" name="rate_type" id="">
                        <option>Is your Salary penalizable on Attendance Absence?</option>
                        <option value="1">True</option>
                        <option value="0">False</option>
                      </select>
                      @error('type.is_penalizable')
                          <small id="title" class="form-text text-danger">{{ $message }}</small>
                      @enderror
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                      <label for="description">Description</label>
                      <textarea wire:model.live='type.description' class="form-control" name="description" id="description" rows="3"></textarea>
                      @error('type.description')
                          <small id="title" class="form-text text-danger">{{ $message }}</small>
                      @enderror
                    </div>
                </div>
            </div>
            <button class="btn btn-dark text-uppercase" wire:click='save'>Save</button>
        </div>
    </div>
</div>
