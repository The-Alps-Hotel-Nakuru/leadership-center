<div>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __("Employee's Dashboard") }}
        </h2>
    </x-slot>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-6 ">
                <div class="card bg-alps-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-0" style="fontweight:100">Total Fines</h6>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-5">
                                <h3 class="mb-2">KES {{ number_format($total_fines, 2) }}
                                </h3>
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
                <div class="card bg-alps-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-0" style="fontweight:100">Total Bonuses</h6>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-5">
                                <h3 class="mb-2">KES {{ number_format($total_bonuses, 2) }}
                                </h3>
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
                <div
                    class="card @if ($attendance_percentage >= 85) bg-alps-primary @elseif ($attendance_percentage < 85 && $attendance_percentage >= 55) bg-alps-warning @else  bg-alps-danger @endif">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-0" style="fontweight:100">% Attendance for
                                {{ Carbon\Carbon::now()->format('F, Y') }}</h6>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-5">
                                <h3 class="mb-2">{{ number_format($attendance_percentage, 2) }} %
                                </h3>
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
