<div>
    <x-slot:header>{{ $employee->user->name }} - {{ Carbon\Carbon::parse($instance)->format('F,Y') }}</x-slot:header>

    <div class="row">
        <div class="col-md-4 col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Extra Works Updator</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label for="date">Date</label>
                                <input type="date"
                                    min="{{ Carbon\Carbon::parse($instance)->firstOfMonth()->format('Y-m-d') }}"
                                    max="{{ Carbon\Carbon::parse($instance)->lastOfMonth()->format('Y-m-d') }}"
                                    wire:model.live='date' class="form-control" name="date" id="date"
                                    aria-describedby="date" placeholder="Select the Date">
                                @error('date')
                                    <small id="date" class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label for="">Double Shift</label>
                                <select wire:model.live="double_shift" class="form-control" name=""
                                    id="">
                                    <option selected>Is this Extra Hour Record a Double Shift Record?
                                    </option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
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
                        $current = App\Models\ExtraWork::where('employees_detail_id', $employee->id)
                            ->where(
                                'date',
                                Carbon\Carbon::parse($instance)->format('Y-m') . '-' . sprintf('%02d', $i + 1),
                            )
                            ->first();
                    @endphp
                    <button @if ($current) wire:click="deleteExtraWork({{ $current->id }})" @endif
                        class="btn rounded-0 p-2 {{ in_array($date1, $employee->extra_work_dates) ? 'bg-success' : (in_array($date1, $employee->leave_dates) ? 'bg-dark text-white' : (Carbon\Carbon::now()->greaterThan(Carbon\Carbon::parse($instance)->format('Y-m') . '-' . sprintf('%02d', $i + 1)) ? 'bg-danger' : 'bg-secondary')) }}">
                        {{ sprintf('%02d', $i + 1) }} @if ($current?->double_shift) <small>D</small>  @endif
                        @php
                            if (in_array($date1, $employee->extra_work_dates)) {
                                $count++;
                            }
                        @endphp
                    </button>
                @endfor
            </div>

            @if (count($extraWorksList) > 0)
                <div class="card mt-4">
                    <div class="card-header">
                        <h5>Attendances to be uploaded</h5>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-hover ">
                                <thead class="">
                                    <tr>
                                        <th>ID</th>
                                        <th>Employee Name</th>
                                        <th>Date</th>
                                        <th>Double Shift</th>
                                        <th class="text-center">Actions</th>
                                        <th>Notifications</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($extraWorksList as $key => $overtime)
                                        <tr>
                                            <td scope="row">{{ $key + 1 }}</td>
                                            <td>{{ App\Models\EmployeesDetail::find($overtime[0])->user->name }}</td>
                                            <td>{{ Carbon\Carbon::parse($overtime[1])->format('jS F, Y') }}</td>
                                            <td>{!! $overtime[2] ? '<span class="text-success">True</span>' : '<span class="text-danger">False</span>' !!}</td>
                                            <td class="d-flex flex-row justify-content-center">
                                                <div class="flex-col ml-1">
                                                    <button wire:click="removeFromList({{ $key }})"
                                                        class="btn btn-xs btn-danger"><i
                                                            class="bi bi-trash"></i></button>
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
