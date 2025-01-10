<div>
    <x-slot name="header">
        Attendance Register
    </x-slot>

    <div class="container-fluid">
        <div class="card mb-5">
            <div class="card-header d-flex flex-row">
                <h3 class="text-success">
                    {{ $instance->format('F, Y') }}
                </h3>
                <div class="ms-auto">
                    <input class="form-control" type="month" wire:model.live="month">
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover table-bordered align-middle mb-5">
                    <thead>
                        <tr>
                            <th>Employee's Details</th>
                            <th>Days</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $employee)
                            <tr>
                                <td>
                                    <div class="d-flex flex-row">
                                        <div class="flex-col m-2">
                                            <img class="img-thumbnail rounded-circle shadow" width="80px"
                                                height="80px" width="80px" src="{{ $employee->user->profile_photo_url }}"
                                                alt="">
                                        </div>
                                        <div class="flex-col m-2">

                                            <h4>{{ $employee->user->name }}</h4>

                                            <small>National ID: <strong>{{ $employee->national_id }}</strong></small>
                                            <br>
                                            <small>Des: <strong>{{ $employee->designation->title }}</small>
                                            <br>
                                            <br>
                                            @if ($employee->ActiveContractDuring($currentYear . '-' . $currentMonthName))
                                                <small class="text-success">Has Contract</small>
                                            @else
                                                <small class="text-danger">No Active Contract</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-row">

                                        @php
                                            $count = 0;

                                        @endphp
                                        @for ($i = 0; $i < $days; $i++)
                                            @php
                                                $date =
                                                    $currentYear . '-' . $currentMonth . '-' . sprintf('%02d', $i + 1);
                                                $curr = App\Models\Attendance::where(
                                                    'employees_detail_id',
                                                    $employee->id,
                                                )
                                                    ->where('date', $date)
                                                    ->first();
                                            @endphp
                                            <div
                                                class="p-2   {{ in_array($date, $employee->attended_dates) ? 'bg-success' : (in_array($date, $employee->leave_dates) ? 'bg-dark text-white' : ($today > $currentYear . '-' . $currentMonth . '-' . sprintf('%02d', $i + 1) ? 'bg-danger' : 'bg-secondary')) }}">
                                                {{ sprintf('%02d', $i + 1) }}
                                                @php
                                                    if (in_array($date, $employee->attended_dates)) {
                                                        $count++;
                                                    }
                                                @endphp
                                            </div>
                                        @endfor
                                        <div class="flex-col m-1">
                                            <div class="btn btn-dark">
                                                {{ $count }} day{{ $count != 1 ? 's' : '' }}
                                            </div>
                                        </div>
                                        <div class="flex-col m-1">
                                            <a href="{{ route('admin.attendances.edit', [$employee->id, $instance->format('Y-m-d')]) }}"
                                                class="btn btn-secondary"><i class="bi bi-pencil"></i></a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
