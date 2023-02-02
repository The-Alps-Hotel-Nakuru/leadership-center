<div>
    <x-slot name="header">
        Attendance Register
    </x-slot>

    <div class="container-fluid">
        <div class="card mb-5">
            <div class="card-header d-flex flex-row justify-content-center align-items-center">
                <button wire:click="getPreviousMonth" class="btn-xs btn-dark p-2 mx-4">
                    <i class="fas fa-caret-left"></i>
                </button>
                <h3>{{ $currentMonthName }}, {{ $currentYear }}</h3>
                <button wire:click="getNextMonth" class="btn-xs btn-dark p-2 mx-4">
                    <i class="fas fa-caret-right"></i>
                </button>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Employee's Full Name</th>
                            <th>Days</th>
                            <th>Total Days Worked</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        @foreach ($employees as $employee)
                            <tr>
                                <td class="">
                                    <img src="{{ $employee->user->profile_photo_url }}" alt="">
                                    {{ $employee->user->name }}
                                </td>
                                <td class="d-flex flex-row">
                                    @php
                                        $count = 0;

                                    @endphp
                                    @for ($i = 0; $i < $days; $i++)
                                        @php
                                            $date = $currentYear . '-' . $currentMonth . '-' . sprintf('%02d', $i + 1);
                                            $curr = App\Models\Attendance::where('employees_detail_id', $employee->id)
                                                ->where('date', $date)
                                                ->first();
                                        @endphp
                                        <div data-bs-toggle="modal"
                                            data-bs-target="#modal-{{ $date }}-{{ $employee->id }}"
                                            class="p-2 ms-1 {{ in_array($date, $employee->attended_dates) ? 'bg-success' : ($today > $i + 1 ? 'bg-danger' : 'bg-secondary') }}"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="{{ $currentMonthName . ' ' . sprintf('%02d', $i + 1) . ', ' . '2022' }}">
                                            {{ sprintf('%02d', $i + 1) }}
                                            @php
                                                if (in_array($date, $employee->attended_dates)) {
                                                    $count++;
                                                }
                                            @endphp
                                        </div>

                                        <!-- Modal -->
                                        <div class="modal fade" id="modal-{{ $date }}-{{ $employee->id }}"
                                            tabindex="-1" role="dialog"
                                            aria-labelledby="modalTitleId{{ $i + 1 }}" aria-hidden="true"
                                            wire:ignore>
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <span class="modal-title" id="modalTitleId">For
                                                            <strong>{{ $employee->user->name }}</strong> on
                                                            <strong>{{ $date }}</strong>
                                                        </span>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="container-fluid">
                                                            <div class="col-12">
                                                                <div class="mb-3">
                                                                    <label for="shift_id"
                                                                        class="form-label">Shift</label>
                                                                    <select wire:model="shift_id" class="form-select"
                                                                        name="shift_id" id="shift_id">
                                                                        <option selected>Select one</option>
                                                                        @foreach ($shifts as $shift)
                                                                            <option value="{{ $shift->id }}">
                                                                                {{ $shift->title }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('shift_id')
                                                                        <small
                                                                            class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <button
                                                                wire:click="clockIn({{ $employee->id }},'{{ $date }}')"
                                                                class="btn btn-dark text-uppercase">
                                                                Clock In
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endfor
                                </td>
                                <td>{{ $count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
