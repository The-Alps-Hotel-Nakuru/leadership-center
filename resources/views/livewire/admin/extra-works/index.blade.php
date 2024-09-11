<div>
    <x-slot name="header">
        Extra Hours Register
    </x-slot>

    <div class="container-fluid">
        <div class="card mb-5">
            <div class="card-header d-flex flex-row">
                <h3 class="text-success">
                    {{ $instance->format('F, Y') }}
                </h3>
                <div class="ms-auto">
                    <input class="form-control" type="month" wire:model="month">
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover table-bordered align-middle mb-5">
                    <thead class="table-light">
                        <tr>
                            <th>Employee's Full Name</th>
                            <th>Days</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        @foreach ($employees as $employee)
                            <tr>
                                <td class="">
                                    <img class="img-thumb img-circle shadow" width="50px" height="50px"
                                        src="{{ $employee->user->profile_photo_url }}" alt="">
                                    {{ $employee->user->name }} <br>
                                    <small>{{ $employee->designation->title }}</small>
                                    <br>
                                    @if ($employee->ActiveContractDuring($currentYear . '-' . $currentMonthName))
                                        <small class="text-success">Has Contract</small>
                                    @else
                                        <small class="text-danger">No Active Contract</small>
                                    @endif
                                </td>
                                <td class="d-flex flex-row">
                                    @php
                                        $count = 0;

                                    @endphp
                                    @for ($i = 0; $i < $days; $i++)
                                        @php
                                            $date = $currentYear . '-' . $currentMonth . '-' . sprintf('%02d', $i + 1);
                                            $curr = App\Models\ExtraWork::where('employees_detail_id', $employee->id)
                                                ->where('date', $date)
                                                ->first();
                                        @endphp
                                        <div
                                            class="p-2   {{ in_array($date, $employee->extra_work_dates) ? 'bg-success' : 'bg-danger' }}">
                                            {{ sprintf('%02d', $i + 1) }}
                                            @php
                                                if (in_array($date, $employee->extra_work_dates)) {
                                                    $count++;
                                                }
                                            @endphp
                                        </div>
                                    @endfor
                                </td>
                                <td class="d-flex flex-row">
                                    <div class="flex-col m-1">
                                        <div class="btn btn-dark">
                                            {{ $count }} day{{ $count != 1 ? 's' : '' }}
                                        </div>
                                    </div>
                                    {{-- <div class="flex-col m-1">
                                        <a href="{{ route('admin.extra-works.edit', [$employee->id, $instance->format('Y-m-d')]) }}"
                                            class="btn btn-secondary"><i class="fas fa-edit"></i></a>
                                    </div> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
