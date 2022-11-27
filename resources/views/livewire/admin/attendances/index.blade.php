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
                                        <div  @if ($curr) data-bs-toggle="modal" data-bs-target="#modal-{{ $date }}-{{ $employee->id }}" @endif
                                            class="p-2 ms-1 {{ in_array($date, $employee->attended_dates) ? ($curr->sign_out ? 'bg-success' : 'bg-warning') : ($today > $i + 1 ? 'bg-danger' : 'bg-secondary') }}"
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
                                        <div class="modal fade" id="modal-{{ $date }}-{{ $employee->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="modalTitleId{{ $i + 1 }}"
                                            aria-hidden="true" wire:ignore>
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <span class="modal-title"
                                                            id="modalTitleId">For
                                                            <strong>{{ $employee->user->name }}</strong> on
                                                            <strong>{{ $date }}</strong>
                                                        </span>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="container-fluid">
                                                            <div class="mb-3">
                                                                <label for="sign_out" class="form-label">Sign Out
                                                                    Time</label>
                                                                <input type="datetime-local" wire:model="sign_out"
                                                                    class="form-control" name="sign_out" id="sign_out"
                                                                    aria-describedby="helpId">
                                                                @error('sign_out')
                                                                    <small id="helpId"
                                                                        class="form-text text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                            <button wire:click="signOut({{ $curr->id??null }})" class="btn btn-dark text-uppercase">
                                                                Sign Out
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
