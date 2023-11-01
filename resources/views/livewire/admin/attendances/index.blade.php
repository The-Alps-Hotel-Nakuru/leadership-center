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
                @foreach (App\Models\Department::all() as $department)
                    <h3>{{ $department->title }}</h3>
                    <table class="table table-hover table-bordered align-middle mb-5">
                        <thead class="table-light">
                            <tr>
                                <th>Employee's Full Name</th>
                                <th>Days</th>
                                <th>Total Days Worked</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            @foreach ($employees as $employee)
                                @if (
                                    $employee->ActiveContractDuring($currentYear . '-' . $currentMonthName) &&
                                        $employee->designation->department_id == $department->id)
                                    <tr>
                                        <td class="">
                                            <img src="{{ $employee->user->profile_photo_url }}" alt="">
                                            {{ $employee->user->name }} <br>
                                            <small>{{ $employee->designation->title }}</small>
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
                                                <div
                                                    class="p-2 ms-1 {{ in_array($date, $employee->attended_dates) ? 'bg-success' : (in_array($date, $employee->leave_dates) ? 'bg-dark text-white' : ($today > $i + 1 ? 'bg-danger' : 'bg-secondary')) }}">
                                                    {{ sprintf('%02d', $i + 1) }}
                                                    @php
                                                        if (in_array($date, $employee->attended_dates)) {
                                                            $count++;
                                                        }
                                                    @endphp
                                                </div>
                                            @endfor
                                        </td>
                                        <td>{{ $count }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                @endforeach
            </div>

        </div>
    </div>
</div>
