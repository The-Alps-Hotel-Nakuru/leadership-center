<div>
    <x-slot name="header">Administrator's Dashboard</x-slot>

    <div class="row">
        <div class="col-12 col-xl-12 stretch-card">
            <div class="row flex-grow-1">
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card bg-alps-primary">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0" style="fontweight:100">No. of Employees</h6>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2">{{ number_format(count(App\Models\EmployeesDetail::all())) }}
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
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card bg-alps-primary">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0" style="fontweight:100">Event Earnings of {{ Carbon\Carbon::now()->format('F, Y') }}</h6>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2">KES {{ number_format($monthearnings, 2)}}</h3>
                                    <div class="d-flex align-items-baseline">
                                        {{-- <p class="text-danger">
                                            <span>-2.8%</span>
                                            <i data-feather="arrow-down" class="icon-sm mb-1"></i>
                                        </p> --}}
                                    </div>
                                </div>
                                <div class="col-6 col-md-12 col-xl-7">
                                    <div id="ordersChart" class="mt-md-3 mt-xl-0"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card bg-alps-primary">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0" style="fontweight:100">Activities Today</h6>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    @php
                                        $count = 0;
                                        foreach (App\Models\Log::all() as $log) {
                                            if (Carbon\Carbon::parse($log->created_at)->toDateString() == Carbon\Carbon::now()->toDateString()) {
                                                $count++;
                                            }
                                        }

                                    @endphp
                                    <h3 class="mb-2">{{ number_format($count) }}</h3>
                                    <div class="d-flex align-items-baseline">
                                        {{-- <p class="text-success">
                                            <span>+2.8%</span>
                                            <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                                        </p> --}}
                                    </div>
                                </div>
                                <div class="col-6 col-md-12 col-xl-7">
                                    <div id="growthChart" class="mt-md-3 mt-xl-0"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card bg-alps-primary">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0" style="fontweight:100">Event Orders for Today</h6>
                            </div>
                            <div class="row">

                                @php
                                    $event_counter = 0;

                                    foreach (App\Models\EventOrder::all() as $event) {
                                        if (Carbon\Carbon::now()->isBetween($event->start_date, $event->end_date)) {
                                            $event_counter++;
                                        }
                                    }
                                @endphp
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2">{{ number_format($event_counter) }}</h3>
                                    <div class="d-flex align-items-baseline">
                                        {{-- <p class="text-success">
                                            <span>+2.8%</span>
                                            <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                                        </p> --}}
                                    </div>
                                </div>
                                <div class="col-6 col-md-12 col-xl-7">
                                    <div id="growthChart" class="mt-md-3 mt-xl-0"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- row -->

    <div class="row mt-3">
        <div class="col-md-10 col-12">
            <div class="card table-responsive">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">User</th>
                            <th scope="col">Activity</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($logs as $log)
                            <tr class="">
                                <td scope="row">{{ $log->id }}</td>
                                <td colspan="1">{!! $log->payload !!}</td>
                                <td>
                                    {{ Carbon\Carbon::parse($log->created_at)->toDateTimeString() }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="card-footer">
                    {{ $logs->links() }}
                </div>
            </div>

        </div>
    </div>
</div>
