<div>
    <x-slot name="header">
        Attendance Register
    </x-slot>

    <div class="container-fluid">
        <div class="card mb-3">
            <div class="card-header d-flex flex-row">

                <h5 >Sign In for {{ Carbon\Carbon::parse($attendance->date)->format('jS F, Y') }}</h5>
                <h5 class="ml-auto">
                    <input type="date" wire:model="attendance.date" class="form-control" name="date" id="date">
                </h5>

            </div>
            <div class="card-body table-responsive">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="mb-3">
                            <label for="employees_detail_id" class="form-label">Employee's Name</label>
                            <select wire:model="attendance.employees_detail_id" class="form-control form-control"
                                name="employees_detail_id" id="employees_detail_id">
                                <option selected>Select an Employee</option>

                                @foreach ($employees as $employee)
                                    <option @if ($employee->hasSignedOn($attendance->date)) disabled @endif
                                        value="{{ $employee->id }}">{{ $employee->user->name }}</option>
                                @endforeach
                            </select>
                            @error('attendance.employees_detail_id')
                                <small id="time" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    {{-- <div class="col-md-6 col-12">
                        <div class="mb-3">
                            <label for="sign_in" class="form-label">Sign In Time</label>
                            <input wire:model="check_in" type="check_in" class="form-control" name="time"
                                id="time" aria-describedby="time" placeholder="Enter the time signed in">
                            @error('check_in')
                                <small id="time" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div> --}}
                    <div class="col-md-6 col-12">
                        <div class="mb-3">
                            <label for="sign_in" class="form-label">Sign In Time</label>
                            <input wire:model="check_in" type="time" class="form-control" name="time"
                                id="time" aria-describedby="time" placeholder="Enter the time signed in">
                            @error('check_in')
                                <small id="time" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <button wire:click="save" class="btn btn-dark text-uppercase">Save</button>
            </div>
        </div>

        @if ($attendance->employee)
            <div class="container">
                <div class="card flex-md-row mb-4 box-shadow h-md-250">
                    <div class="card-body d-flex flex-column align-items-start">
                        <strong
                            class="d-inline-block mb-2 text-primary">ALPS/EMP/{{ sprintf('%04d', $attendance->employee->id) }}</strong>
                        <h3 class="mb-0">
                            <a class="text-dark" href="#">{{ $attendance->employee->title }}
                                {{ $attendance->employee->user->name }}</a>
                        </h3>
                        <div class="mb-1 text-muted">{{ $attendance->employee->designation->title }}</div>
                        <p class="card-text mb-auto">{{ $attendance->employee->designation->department->title }}
                            Department <br><br>
                            <b>Age:</b> {{ $attendance->employee->age }} years
                            <br>
                            <b>Phone Number:</b> {{ $attendance->employee->phone_number }}
                            <br>
                            <b>Email Address:</b> {{ $attendance->employee->user->email }}
                        </p>
                        <p>
                            <h5>Attendance Record</h5>
                            <div class="d-flex flex-row">
                                @foreach ($attendance->employee->attendances as $record)
                                <div class="flex-col m-1 bg-secondary">

                                </div>
                                @endforeach
                            </div>
                        </p>
                    </div>
                    <img class="card-img-right flex-auto d-none d-md-block"
                        data-src="{{ $attendance->employee->user->profile_photo_url }}" alt="Thumbnail [200x250]"
                        style="width: 500px; height: 100%;" src="{{ $attendance->employee->user->profile_photo_url }}"
                        data-holder-rendered="true">
                </div>
            </div>
        @endif
    </div>

</div>
