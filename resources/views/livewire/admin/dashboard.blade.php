<div>
    <x-slot name="header">Administrator's Dashboard</x-slot>

    <div class="row mb-5">
        <div class="col-md-4 col-12 ">
            <div class="card bg-gradient-maroon text-white mb-3 h-100" style="padding: 30px">
                <div class="d-flex">
                    <div class="align-self-center">
                        <h3 class="m-b-0">{{ $this->instance->format('F, Y') }}</h3><small>Total
                            {{ App\Models\Payroll::where('month', $this->instance->format('m'))->where('year', $this->instance->format('Y'))->exists()? 'Gross': 'Estimated Gross' }}
                            Payroll Amount</small>
                    </div>
                </div>
                <div class="d-flex h-100">
                    <div class=" ms-auto mt-auto text-success" style="font-size: xx-large">
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
                    <div class="row">
                        <div class="col-md-3 col-sm-8 col-12 ">
                            <div class="card h-100 bg-gradient-black   text-white" style="min-height: 150px">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-baseline mb-3">
                                        <h6 class="card-title mb-0" style="font-weight: 400; font-size:14px">Total
                                            Penalties</h6>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-12 col-xl-9">
                                            <small>KES</small>
                                            <div class="d-flex align-items-baseline ms-auto">
                                                <h4 class="mb-2">
                                                    {{ number_format($total_penalties, 2) }}
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
                            <div class="card h-100 bg-gradient-black   text-white" style="min-height: 150px">
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
                            <div class="card h-100 bg-gradient-black   text-white" style="min-height: 150px">
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
                            <div class="card bg-gradient-black text-white h-100" style="min-height: 150px">
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-transparent border-0">
                    <h5 class="text-center">Payroll Final Amounts</h5>
                </div>
                <div class="card-body" wire:ignore>
                    <canvas id="payroll-chart" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>


    <div class="row mb-5">
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Event Log</h5>
                </div>
                <div class="table-responsive card-body" style="max-height: 450px">
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
                </div>

                <div class="card-footer">
                    {{ $logs->links() }}
                </div>
            </div>

        </div>
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="text-center">Incomplete Full Time Employees</h5>
                </div>
                <div class="table-responsive card-body" style="max-height: 450px">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Employee ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Missing Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($incompleteEmployees as $key => $employee)
                                <tr class="">
                                    <td scope="row">{{ $key + 1 }}</td>
                                    <td scope="row">{{ $employee->id }}</td>
                                    <td>{{ $employee->user->name }}</td>
                                    <td class="text-danger">
                                        @if (!$employee->kra_pin)
                                            KRA Pin
                                            @if (!$employee->nssf || !$employee->nhif)
                                                ,
                                                @if ($employee->nhif)
                                                    and
                                                @endif
                                            @endif
                                        @endif
                                        @if (!$employee->nssf)
                                            NSSF
                                            @if (!$employee->nhif)
                                                , and
                                            @endif
                                        @endif
                                        @if (!$employee->nhif)
                                            NHIF Pin
                                        @endif
                                        missing
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <div class="card mt-3">
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



@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script>
        var ticksStyle = {
            fontColor: '#495057',
            fontStyle: 'bold'
        }

        var mode = 'index'
        var intersect = true
        var labels = [];
        var data = [];
    </script>
    @foreach ($labels as $label)
        <script>
            labels.push('{{ $label }}')
        </script>
    @endforeach
    @foreach ($data as $d)
        <script>
            data.push('{{ $d }}')
        </script>
    @endforeach

    <script>
        // var $salesChart = $('#sales-chart')

        document.addEventListener("livewire:load", function() {
            var payrollChart = new Chart(document.getElementById('payroll-chart').getContext('2d'), {
                type: 'line',
                data: {
                    labels,
                    datasets: [{
                        backgroundColor: '#242464',
                        borderColor: '#90151a',
                        data,
                    }, ]
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        mode: mode,
                        intersect: intersect,
                        callbacks: {
                            label: function(tooltipItem, data) {
                                // Format the number as you need (e.g., with commas)
                                var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem
                                    .index];
                                return 'Value: KES ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g,
                                    ',');
                            }
                        }
                    },
                    hover: {
                        mode: mode,
                        intersect: intersect
                    },
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            // display: false,
                            gridLines: {
                                display: true,
                                lineWidth: '3px',
                                color: 'rgba(0, 0, 0, .8)',
                                zeroLineColor: 'black'
                            },
                            ticks: $.extend({
                                beginAtZero: true,

                                // Include a dollar sign in the ticks
                                callback: function(value) {
                                    if (value >= 1000) {
                                        if (value >= 1000000) {
                                            value /= 1000000
                                            value += 'm'

                                        } else {

                                            value /= 1000
                                            value += 'k'
                                        }
                                    }

                                    return 'KES' + value
                                }
                            }, ticksStyle)
                        }],
                        xAxes: [{
                            // display: true,
                            gridLines: {
                                display: true,
                                lineWidth: '3px',
                                color: 'rgba(0, 0, 0, .8)',
                                zeroLineColor: 'transparent'
                            },
                            ticks: ticksStyle
                        }]
                    }
                }
            })
        });
    </script>
@endpush
