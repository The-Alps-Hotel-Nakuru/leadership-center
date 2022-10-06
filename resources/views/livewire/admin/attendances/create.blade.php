<div>
    <x-slot name="header">
        Attendance Register
    </x-slot>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">

                <h5>Sign In for {{ Carbon\Carbon::now()->format('jS F, Y') }}</h5>

            </div>
            <div class="card-body table-responsive">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="mb-3">
                            <label for="employees_detail_id" class="form-label">Employee's Name</label>
                            <select wire:model="attendance.employees_detail_id" class="form-select form-select-lg" name="employees_detail_id"
                                id="employees_detail_id">
                                <option selected>Select an Employee</option>

                                @foreach (App\Models\EmployeesDetail::all() as $employee)
                                    <option @if ($employee->hasSignedInToday())
                                        disabled
                                    @endif value="{{ $employee->id }}">{{ $employee->user->name }}</option>
                                @endforeach
                            </select>
                            @error('attendance.employees_detail_id')
                                <small id="time" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="mb-3">
                            <label for="sign_in" class="form-label">Sign In Time</label>
                            <input wire:model="attendance.sign_in" type="sign_in" class="form-control" name="time" id="time"
                                aria-describedby="time" placeholder="Enter the time signed in">
                            @error('attendance.sign_in')
                                <small id="time" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <button wire:click="save" class="btn btn-dark text-uppercase">Save</button>
            </div>
        </div>
    </div>

</div>
