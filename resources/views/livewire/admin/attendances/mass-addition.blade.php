<div>
    <x-slot:header>
        Mass Addition of Attendances
    </x-slot:header>

    <div class="card" style="max-height: 500px">
        <div class="card-header">
            <h5>Upload Attendance File</h5>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label for="" class="form-label">Mass Attendances Upload</label>
                <input type="file" wire:model='attendanceFile' class="form-control" name="" id=""
                    aria-describedby="helpId" placeholder="">
                @error('attendanceFile')
                    <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button class="btn btn-primary" wire:loading.attr="disabled" wire:target="checkData" wire:click="checkData">
                <span wire:loading.remove wire:target="checkData">
                    Check Data
                </span>
                <span wire:loading wire:target="checkData">
                    Checking...
                </span>
            </button>
        </div>
    </div>
    <div class="mt-3"></div>

    <div class="row">
        @if ($validAttendances)
            <div class="col-md-4 col-12 mb-3">
                <div class="card" style="max-height: 500px">
                    <div class="card-header">
                        <h5><strong>Attendances to Be Uploaded</strong></h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th scope="col">Employee Name</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Clock In Time</th>
                                    <th scope="col">Clock Out Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($validAttendances as $attendance)
                                    <tr class="">
                                        <td scope="row">
                                            {{ App\Models\EmployeesDetail::where('national_id', $attendance[0])->first()->user->name }}
                                        </td>
                                        <td scope="row">
                                            {{ Carbon\Carbon::createFromFormat('d/m/Y', $attendance[1])->format('jS F,Y') }}
                                        </td>
                                        <td scope="row">
                                            {{ Carbon\Carbon::parse($attendance[2])->format('h:i:s A') }}
                                        </td>
                                        <td scope="row">
                                            {{ $attendance[3] ? Carbon\Carbon::parse($attendance[3])->format('h:i:s A') : "Didn't Check Out" }}
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <button class="btn btn-primary" wire:click="uploadAttendances">Upload Attendances</button>
                </div>
            </div>
        @endif
        @if ($alreadyExisting)
            <div class="col-md-4 col-12 mb-3">
                <div class="card" style="max-height: 500px">
                    <div class="card-header">
                        <h5><strong>Already Existing Attendances</strong></h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th scope="col">User ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($alreadyExisting as $attendance)
                                    <tr class="">
                                        <td scope="row">
                                            {{ App\Models\EmployeesDetail::where('national_id', $attendance[0])->first()->user->id }}
                                        </td>
                                        <td scope="row">
                                            {{ App\Models\EmployeesDetail::where('national_id', $attendance[0])->first()->user->name }}
                                        </td>
                                        <td scope="row">
                                            {{ Carbon\Carbon::createFromFormat('d/m/Y', $attendance[1])->format('jS F,Y') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
        @if ($invalidAttendances)
            <div class="col-md-4 col-12 mb-3">
                <div class="card" style="max-height: 500px">
                    <div class="card-header">
                        <h5><strong>Invalid Attendances</strong></h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th scope="col">User ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Invalidity Reason</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invalidAttendances as $attendance)
                                    <tr class="">
                                        <td scope="row">
                                            {{ App\Models\EmployeesDetail::where('national_id', $attendance[0][0])->first() ? App\Models\EmployeesDetail::where('national_id', $attendance[0][0])->first()->user->id : 'User Not found (' . $attendance[0][0] . ')' }}
                                        </td>
                                        <td scope="row">
                                            {{ App\Models\EmployeesDetail::where('national_id', $attendance[0][0])->first() ? App\Models\EmployeesDetail::where('national_id', $attendance[0][0])->first()->user->name : 'User not found' }}
                                        </td>
                                        <td scope="row">
                                            {{ Carbon\Carbon::createFromFormat(env('ATTENDANCE_DATE_FORMAT'), $attendance[0][1])->format('jS F,Y') }}
                                        </td>
                                        <td scope="row">
                                            {{ $attendance[1] }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

    </div>

</div>
