<div>
    <x-slot:header>Extra Hours Register</x-slot:header>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Extra Hours List Updator</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <input type="text" class="form-control" wire:model.live="search"
                                    placeholder="Search employees">
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <ul class="list-group mt-2 w-100">
                                        @if ($search != '')
                                            @foreach ($employees as $employee)
                                                <li wire:click="selectEmployee({{ $employee->id }})"
                                                    class="list-group-item {{ $employee_id == $employee->id ? 'active' : '' }}">
                                                    {{ $employee->user->name }}
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                    @error('employee_id')
                                        <small id="time" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-check mb-3">
                                    <label class="form-check-label">
                                        <input type="checkbox" wire:model.live='full' class="form-check-input" name=""
                                            id="" checked>
                                        Add Range of Days
                                    </label>
                                </div>
                            </div>

                            @if (!$full)
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="date">Date</label>
                                        <input type="date" wire:model.live='date' class="form-control" name="date"
                                            id="date" aria-describedby="date" placeholder="Select the Date">
                                        @error('date')
                                            <small id="date" class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            @else
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date">Start Date</label>
                                        <input type="date" wire:model.live='date' class="form-control" name="date"
                                            id="date" aria-describedby="date" placeholder="Select the Start Date">
                                        @error('date')
                                            <small id="date" class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date">End Date</label>
                                        <input type="date" wire:model.live='second_date' class="form-control"
                                            name="date" id="date" aria-describedby="date"
                                            placeholder="Select the End Date">
                                        @error('second_date')
                                            <small id="date" class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            @endif


                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Double Shift</label>
                                    <select wire:model.live="double_shift" class="form-control" name=""
                                        id="">
                                        <option selected disabled>Is this Extra Hour Record a Double Shift Record?
                                        </option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button
                            @if ($full) wire:click="addFullMonth"
                        @else
                            wire:click="addToList" @endif
                            class="btn btn-dark text-uppercase">Add</button>
                    </div>
                </div>
            </div>
            @if (count($overtimesList) > 0)
                <div class="col-md-8 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Extra Hours to be uploaded</h5>
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
                                    @foreach ($overtimesList as $key => $overtime)
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

                </div>
            @endif
        </div>


    </div>

</div>
