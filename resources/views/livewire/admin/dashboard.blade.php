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
            </div>
        </div>
    </div> <!-- row -->

    <div class="row mt-3">
        <div class="col-md-10 col-12">
            <div class="card table-responsive">
                <div class="card-header">
                    <h5>Event Log</h5>
                </div>
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
        <div class="col-md-2 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <button class="btn btn-primary" wire:loading.attr="disabled" wire:target="downloadEmployeesData"
                            wire:click="downloadEmployeesData">
                            <span wire:loading.remove wire:target="downloadEmployeesData">
                               Download Employees Data
                            </span>
                            <span wire:loading wire:target="downloadEmployeesData">
                                Downloading...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
