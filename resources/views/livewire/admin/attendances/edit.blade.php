<div>
    <x-slot:header>{{ $employee->user->name }} - {{ Carbon\Carbon::parse($instance)->format('F,Y') }}</x-slot:header>

    <div class="row">
        <div class="col-md-4 col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Attendance Updator</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="date">Date</label>
                                <input type="date"
                                    min="{{ Carbon\Carbon::parse($instance)->firstOfMonth()->format('Y-m-d') }}"
                                    max="{{ Carbon\Carbon::parse($instance)->lastOfMonth()->format('Y-m-d') }}"
                                    wire:model='date' class="form-control" name="date" id="date"
                                    aria-describedby="date" placeholder="Select the Date">
                                @error('date')
                                    <small id="date" class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="check_in">Check In</label>
                                <input type="time" wire:model="check_in" class="form-control" name="check_in"
                                    id="check_in" aria-describedby="check_in" placeholder="Enter the check in time">
                                @error('check_in')
                                    <small id="date" class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="check_out">Check Out</label>
                                <input type="time" wire:model="check_out" class="form-control" name="check_out"
                                    id="check_out" aria-describedby="check_out" placeholder="Enter the check out time">
                                @error('check_out')
                                    <small id="date" class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-12"></div>
                    </div>
                    <button wire:click="addToList" class="btn btn-dark text-uppercase">Add</button>
                </div>
            </div>


        </div>
        <div class="col-md-8 col-12 container-fluid">
            <div class="d-flex flex-row table-responsive">
                @php
                    $count = 0;
                    $days = Carbon\Carbon::parse($instance)->daysInMonth;

                @endphp
                @for ($i = 0; $i < $days; $i++)
                    @php
                        $date1 = Carbon\Carbon::parse($instance)->format('Y-m') . '-' . sprintf('%02d', $i + 1);
                        $current = App\Models\Attendance::where('employees_detail_id', $employee->id)
                            ->where(
                                'date',
                                Carbon\Carbon::parse($instance)->format('Y-m') . '-' . sprintf('%02d', $i + 1),
                            )
                            ->first();
                    @endphp
                    <button @if ($current) wire:click="deleteAttendance({{ $current->id }})" @endif
                        class="btn rounded-0 p-2 {{ in_array($date1, $employee->attended_dates) ? 'bg-success' : (in_array($date1, $employee->leave_dates) ? 'bg-dark text-white' : (Carbon\Carbon::now()->greaterThan(Carbon\Carbon::parse($instance)->format('Y-m') . '-' . sprintf('%02d', $i + 1)) ? 'bg-danger' : 'bg-secondary')) }}">
                        {{ sprintf('%02d', $i + 1) }}
                        @php
                            if (in_array($date1, $employee->attended_dates)) {
                                $count++;
                            }
                        @endphp
                    </button>
                @endfor
            </div>

            @if (count($attendanceList) > 0)
                <div class="card mt-4">
                    <div class="card-header">
                        <h5>Attendances to be uploaded</h5>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-hover ">
                            <thead class="">
                                <tr>
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Check In Time</th>
                                    <th>Check Out Time</th>
                                    <th class="text-center">Actions</th>
                                    <th>Notifications</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attendanceList as $key => $attendance)
                                    <tr>
                                        <td scope="row">{{ $key + 1 }}</td>
                                        <td>{{ Carbon\Carbon::parse($attendance[1])->format('jS F, Y') }}</td>
                                        <td>{{ Carbon\Carbon::parse($attendance[2])->format('h:i A') }}</td>
                                        <td>{{ Carbon\Carbon::parse($attendance[3])->format('h:i A') }}</td>
                                        <td class="d-flex flex-row justify-content-center">
                                            <div class="flex-col ml-1">
                                                <button wire:click="removeFromList({{ $key }})"
                                                    class="btn btn-xs btn-danger"><i class="fas fa-trash"></i></button>
                                            </div>
                                        </td>
                                        <td>
                                            @error('list' . $key)
                                                <small id="date"
                                                    class="form-text text-danger">{{ $message }}</small>
                                            @enderror
                                        </td>
                                    </tr>
                                @endforeach
                                <button wire:click="save" class="btn btn-dark text-uppercase">Save</button>

                            </tbody>

                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
