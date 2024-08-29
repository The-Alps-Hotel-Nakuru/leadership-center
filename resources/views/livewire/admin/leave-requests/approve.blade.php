<div>
    <x:slot:header>Approval of Leave Request # {{ $leave_request->id }} - {{ $leave->employee->user->name }}</x:slot:header>

    <div class="card">
        <div class="card-header">
            <h5>Approval Form</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                      <label for="leave_type">Leave Type</label>
                      <select class="form-control" wire:model='leave.leave_type_id' name="leave_type" id="leave_type">
                        <option selected> Please choose the leave Type you wish to allocate</option>
                        @foreach ($leave_types as $type)
                            <option value="{{ $type->id }}">{{ $type->title }}</option>
                        @endforeach
                      </select>
                      @error('leave.leave_type_id')
                          <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                      @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="start_date">Starting Date</label>
                      <input type="date"
                        class="form-control" name="start_date" id="start_date" wire:model='leave.start_date' aria-describedby="helpId">
                      @error('leave.start_date')
                          <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                      @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="end_date">Ending Date</label>
                      <input type="date" wire:model='leave.end_date'
                        class="form-control" name="end_date" id="end_date" aria-describedby="helpId">
                      @error('leave.end_date')
                          <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                      @enderror
                    </div>
                </div>
            </div>
            <button class="btn btn-dark text-uppercase" wire:click='save'>Save</button>
        </div>
    </div>
</div>
