<div>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __("Employee's Dashboard") }}
        </h2>
    </x-slot>

    <div class="container-fluid">
        <div class="row mb-5">
            <div class="col-md-4 col-12 ">
                <div class="card bg-gradient-black text-white mb-3 h-100" style="padding: 30px">
                    <div class="d-flex">
                        <div class="align-self-center">
                            <h3 class="m-b-0">{{ $this->instance->format('F, Y') }}</h3><small>Total
                                {{ App\Models\Payroll::where('month', $this->instance->format('m'))->where('year', $this->instance->format('Y'))->exists()? 'Gross': 'Estimated Gross' }}
                                Earning</small>
                        </div>
                    </div>
                    <div class="d-flex h-100">
                        <div class=" ms-auto mt-auto {{ $estimated >= 0 ? 'text-success' : 'text-danger' }}"
                            style="font-size: xx-large">
                            <sup>KES</sup>
                            <h2 class="">{{ number_format($estimated, 2) }}</h2>
                        </div>

                    </div>
                </div>

            </div>
            <div class="col-md-8 col-12">
                <div class="card mb-3 shadow">
                    <div class="card-header bg-transparent border-0  ">
                        <div class="d-flex flex-row justify-content-center align-items-center">
                            <input class="form-control" type="month" wire:model="month">
                        </div>
                    </div>
                </div>
                <div class="card shadow">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-3 col-sm-8 col-12 ">
                                <div class="card h-100 bg-alps-primary" style="min-height: 150px">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-baseline mb-3">
                                            <h6 class="card-title mb-0" style="font-weight: 400; font-size:14px">Total
                                                Advances</h6>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-12 col-xl-9">
                                                <small>KES</small>
                                                <div class="d-flex align-items-baseline ms-auto">
                                                    <h4 class="mb-2">
                                                        {{ number_format($total_advances, 2) }}
                                                    </h4>
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
                            <div class="col-md-3 col-sm-8 col-12 ">
                                <div class="card h-100 bg-alps-primary" style="min-height: 150px">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-baseline mb-3">
                                            <h6 class="card-title mb-0" style="font-weight: 400; font-size:14px">Total
                                                Fines</h6>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-12 col-xl-9">
                                                <small>KES</small>
                                                <div class="d-flex align-items-baseline ms-auto">
                                                    <h4 class="mb-2">
                                                        {{ number_format($total_fines, 2) }}
                                                    </h4>
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
                            <div class="col-md-3 col-sm-8 col-12 ">
                                <div class="card bg-alps-primary h-100" style="min-height: 150px">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-baseline mb-3">
                                            <h6 class="card-title mb-0" style="font-weight: 400; font-size:14px">Total
                                                Bonuses</h6>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-12 col-xl-9">
                                                <small>KES</small>
                                                <div class="d-flex align-items-baseline ms-auto">
                                                    <h4 class="mb-2"> {{ number_format($total_bonuses, 2) }}
                                                    </h4>

                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12 col-xl-9">
                                                <div id="customersChart" class="mt-md-3 mt-xl-0"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-8 col-12 ">
                                <div class="card h-100 @if ($attendance_percentage >= 85) bg-alps-primary @elseif ($attendance_percentage < 85 && $attendance_percentage >= 55) bg-alps-warning @else  bg-alps-danger @endif"
                                    style="min-height: 150px">
                                    <div class="card-body">
                                        <div class=" align-items-baseline mb-3">
                                            <h6 class="card-title mb-0" style="font-weight: 400; font-size:14px">
                                                Attendance
                                            </h6>
                                            <small>{{ $this->instance->format('F, Y') }}</small>
                                        </div>
                                        <div class="row">
                                            <div class="d-flex align-items-baseline ms-auto">
                                                <div class="col-12 col-md-12 col-xl-9">
                                                    <h4 class="mb-2">{{ number_format($attendance_percentage, 2) }} %
                                                    </h4>
                                                    {{-- <p class="text-success">
                                        <span>+3.3%</span>
                                        <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                                    </p> --}}
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12 col-xl-9">
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
        <div class="row mb-3">
            <div class="col-md-10 col-12 h-100">
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
                                <div class="p-3 m-1  {{ in_array($date, $employee->attended_dates) ? 'bg-success' : (in_array($date, $employee->leave_dates) ? 'bg-dark text-white' : ($today > $currentYear . '-' . $currentMonth . '-' . sprintf('%02d', $i + 1) ? 'bg-danger' : 'bg-secondary')) }}"
                                    @if ($employee->ActiveContractOn($date) && !$curr) data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="{{ $currentMonthName . ' ' . sprintf('%02d', $i + 1) . ', ' . $currentYear }}" @endif>
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
                    <div class="card-footer">
                        <h4>{{ $count }} Days</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-12 h-100">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6 col-12">
                                <button class="btn btn-primary m-1 btn-xs">Download Recent Payslip</button>
                            </div>
                            <div class="col-md-6 col-12">
                                <button class="btn btn-primary m-1 btn-xs">Download Recent Payslip</button>
                            </div>
                            <div class="col-md-6 col-12 ">
                                <button class="btn btn-primary m-1 btn-xs">Download Recent Payslip</button>
                            </div>
                            <div class="col-md-6 col-12">
                                <button class="btn btn-primary m-1 btn-xs">Download Recent Payslip</button>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
