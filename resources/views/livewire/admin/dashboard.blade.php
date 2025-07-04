<div>
    <x-slot name="header">Administrator's Dashboard</x-slot>

    <div class="row mb-5">
        <div class="col-md-4 col-12 ">
            <div class="card bg-gradient-maroon text-white mb-3 h-100" style="padding: 30px">
                <div class="d-flex">
                    <div class="align-self-center">
                        <h3 class="m-b-0">{{ $this->instance->format('F, Y') }}</h3><small>Total
                            {{ App\Models\Payroll::where('month', $this->instance->format('m'))->where('year', $this->instance->format('Y'))->exists() ? 'Gross' : 'Estimated Gross' }}
                            Payroll Amount</small>
                    </div>
                </div>
                <div class="d-flex h-100">
                    <div class=" ms-auto mt-auto text-success" style="font-size: xx-large">
                        @if ($estimated === null)
                            <span class="spinner-border text-right" role="status"></span>
                        @else
                            <sup>KES</sup>
                            <h2 class="">{{ number_format($estimated, 2) }}</h2>
                        @endif

                    </div>

                </div>
            </div>

        </div>
        <div class="col-md-8 col-12">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 col-sm-8 col-12 ">
                            <div class="card h-100 bg-gradient-black   text-white" style="min-height: 150px">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-baseline mb-3">
                                        <h6 class="card-title mb-0" style="font-weight: 400; font-size:14px">Total
                                            Overtimes</h6>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-12 col-xl-9">

                                            <small>KES</small>
                                            <div class="d-flex align-items-baseline ms-auto">
                                                <h4 class="mb-2">
                                                    {{ number_format($total_overtimes, 2) }}
                                                </h4>
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
                    <h3 class="text-center">Payroll Final Amounts</h3>
                </div>
                <div class="card-body" style="height: 32rem;">
                    <livewire:livewire-column-chart :column-chart-model="$chartModel" />
                </div>

            </div>
        </div>
    </div>


    <div class="row mb-5">
        <div class="col-md-6 col-12">
            @livewire('admin.dashboard.logs')

        </div>
        @if ($incompleteEmployees)
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
        @endif
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
