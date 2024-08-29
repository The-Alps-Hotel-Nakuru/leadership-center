<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <x-slot:header>My Leave Requests</x-slot:header>

    <div class="card">
        <div class="card-header">
            <h5>Edit Leave Request No. {{ $leaveRequest->id }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Leave Type</label>
                        <select class="form-control" name="" id="" wire:model='leaveRequest.leave_type_id'>
                            <option selected>Please select your Leave Type</option>
                            @foreach ($leaveTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->title }}</option>
                            @endforeach
                        </select>
                        @error('leaveRequest.leave_type_id')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="date" wire:model="leaveRequest.start_date" class="form-control"
                            name="start_date" id="start_date" aria-describedby="start_date"
                            placeholder="Enter the date you wish to start the leave">
                        @error('leaveRequest.start_date')
                            <small id="start_date" class="form-text text-muted">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="end_date">end Date</label>
                        <input type="date" wire:model="leaveRequest.end_date" class="form-control"
                            name="end_date" id="end_date" aria-describedby="end_date"
                            placeholder="Enter the date you wish to end the leave">
                        @error('leaveRequest.end_date')
                            <small id="end_date" class="form-text text-muted">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                      <label for="reason">Reason for Leave</label>
                      <textarea wire:model='leaveRequest.reason' class="form-control" name="reason" id="reason" rows="3"></textarea>
                      @error('leaveRequest.reason')
                          <small id="end_date" class="form-text text-muted">{{ $message }}</small>
                      @enderror
                    </div>
                </div>
            </div>
            <button wire:click='save' class="btn btn-dark text-uppercase">Save</button>
        </div>
    </div>
</div>
