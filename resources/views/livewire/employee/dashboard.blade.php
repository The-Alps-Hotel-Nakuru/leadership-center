<div>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __("Employee's Dashboard") }}
        </h2>
    </x-slot>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="card bg-gradient-black text-white mb-3" style="padding: 30px">
                    <div class="d-flex">
                        <div class="align-self-center">
                            <h3 class="m-b-0">{{ $instance->format('F, Y') }}</h3><small>Total
                                {{ App\Models\Payroll::where('month', $instance->format('m'))->where('year', $instance->format('Y'))->exists()? '': 'Estimated' }}
                                Earning</small>
                        </div>
                        <div class="ms-auto align-self-center text-success">
                            <sup>KES</sup>
                            <h2 class="">{{ number_format($this->estimated_earnings(), 2) }}</h2>
                        </div>
                    </div>
                </div>
                <div class="card shadow">
                    <div class="card-header bg-transparent border-0">
                        <h5 class="text-capitalize"><strong>your attendance</strong> </h5>
                    </div>
                    <div class="card-body table-responsive">
                        <div class="d-flex flex-row">
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
                                <div class="p-2 m-1 {{ in_array($date, $employee->attended_dates) ? 'bg-success' : (in_array($date, $employee->leave_dates) ? 'bg-dark text-white' : ($today > $i + 1 ? 'bg-danger' : 'bg-secondary')) }}"
                                    @if ($employee->ActiveContractOn($date) && !$curr) data-bs-toggle="modal"
                                                data-bs-target="#modal-{{ $date }}-{{ $employee->id }}"

                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="{{ $currentMonthName . ' ' . sprintf('%02d', $i + 1) . ', ' . '2022' }}" @endif>
                                    {{ sprintf('%02d', $i + 1) }}
                                    @php
                                        if (in_array($date, $employee->attended_dates)) {
                                            $count++;
                                        }
                                    @endphp
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="card mb-3 shadow">
                    <div class="card-header bg-transparent border-0  ">
                        <div class="d-flex flex-row justify-content-center align-items-center">
                            <button wire:click="getPreviousMonth" class="btn btn-xs btn-dark mx-4">
                                <i class="fas fa-caret-left"></i>
                            </button>
                            <h4>{{ $currentMonthName }}, {{ $currentYear }}</h4>
                            <button wire:click="getNextMonth" class="btn btn-xs btn-dark mx-4">
                                <i class="fas fa-caret-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 col-6 ">
                                <div class="card bg-alps-primary" style="min-height: 150px">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-baseline mb-3">
                                            <h6 class="card-title mb-0" style="font-weight: 900">Total Fines</h6>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 col-md-12 col-xl-7">
                                                <small>KES</small>
                                                <h4 class="mb-2">
                                                    {{ number_format($total_fines, 2) }}
                                                </h4>
                                                <div class="d-flex align-items-baseline">
                                                    {{-- <p class="text-success">
                                        <span>+3.3%</span>
                                        <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                                    </p> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-6 ">
                                <div class="card bg-alps-primary" style="min-height: 150px">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-baseline mb-3">
                                            <h6 class="card-title mb-0" style="font-weight: 900">Total Bonuses</h6>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 col-md-12 col-xl-7">
                                                <small>KES</small>
                                                <h4 class="mb-2"> {{ number_format($total_bonuses, 2) }}
                                                </h4>
                                                <div class="d-flex align-items-baseline">
                                                    {{-- <p class="text-success">
                                        <span>+3.3%</span>
                                        <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                                    </p> --}}
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-12 col-xl-7">
                                                <div id="customersChart" class="mt-md-3 mt-xl-0"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-6 ">
                                <div class="card @if ($attendance_percentage >= 85) bg-alps-primary @elseif ($attendance_percentage < 85 && $attendance_percentage >= 55) bg-alps-warning @else  bg-alps-danger @endif"
                                    style="min-height: 150px">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-baseline mb-3">
                                            <h6 class="card-title mb-0" style="font-weight: 900">% Attendance for
                                                {{ $instance->format('F, Y') }}</h6>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 col-md-12 col-xl-7">
                                                <h4 class="mb-2">{{ number_format($attendance_percentage, 2) }} %
                                                </h4>
                                                <div class="d-flex align-items-baseline">
                                                    {{-- <p class="text-success">
                                        <span>+3.3%</span>
                                        <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                                    </p> --}}
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-12 col-xl-7">
                                                <div id="customersChart" class="mt-md-3 mt-xl-0"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
