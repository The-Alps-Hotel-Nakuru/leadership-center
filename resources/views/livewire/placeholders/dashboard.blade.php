<div>
    <x-slot name="header">Administrator's Dashboard</x-slot>

    <div class="row mb-5">
        <div class="col-md-4 col-12 ">
            <div class="card bg-gradient-maroon text-white mb-3 h-100" style="padding: 30px">
                <div class="d-flex">
                    <div class="placeholder">
                        <h3 class="placeholder">
                            January 2024
                        </h3>
                        <small class="text-white">
                            test text for placeholder
                        </small>
                    </div>
                </div>
                <div class="d-flex h-100">
                    <div class=" ms-auto mt-auto text-success" style="font-size: xx-large">

                        <sup class="placeholder col-7"></sup>
                        <h2 class="placeholder col-7">100,000</h2>

                    </div>

                </div>
            </div>

        </div>
        <div class="col-md-8 col-12">
            <div class="card mb-3 shadow">
                <div class="card-header bg-transparent border-0  ">
                    <div class="d-flex flex-row justify-content-center align-items-center">
                        <input class="form-control" type="month">
                    </div>
                </div>
            </div>
            <div class="card shadow">
                <div class="card-body">
                    <div class="row">
                        @for ($i = 0; $i < 4; $i++)
                            <div class="col-md-3 col-sm-8 col-12 ">
                                <div class="card h-100 bg-gradient-black   text-white" style="min-height: 150px">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-baseline mb-3">
                                            <h6 class="card-title mb-0 placeholder"
                                                style="font-weight: 400; font-size:14px">Total
                                                Overtimes</h6>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-12 col-xl-9">

                                                <small class="placeholder">KES</small>
                                                <div class="d-flex align-items-baseline ms-auto placeholder">
                                                    <h4 class="mb-2">
                                                        {{ number_format($total_overtimes, 2) }}
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endfor
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
                    <div class="row placeholder-glow" style="height: 25rem">
                        <div class="col-1 m-3">

                        </div>
                        <div class="col-1 placeholder m-3">

                        </div>
                        <div class="col-1 placeholder m-3">

                        </div>
                        <div class="col-1 placeholder m-3">

                        </div>
                        <div class="col-1 placeholder m-3">

                        </div>
                        <div class="col-1 placeholder m-3">

                        </div>
                        <div class="col-1 placeholder m-3">

                        </div>
                        <div class="col-1 placeholder m-3">

                        </div>
                        <div class="col-1 placeholder m-3">

                        </div>
                        <div class="col-1 placeholder m-3">

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="row mb-5">
        <div class="col-md-6 col-12">
            @livewire('admin.dashboard.logs')

        </div>
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="text-center">Incomplete Full Time Employees</h5>
                </div>
                <div class="table-responsive card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="" scope="col">#</th>
                                <th class="" scope="col">Employee ID</th>
                                <th class="" scope="col">Name</th>
                                <th class="" scope="col">Missing Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < 10; $i++)
                                <tr>
                                    <td class="placeholder-wave" scope="row">
                                        <span class="placeholder placeholder-lg col-12"></span>
                                    </td>
                                    <td class="placeholder-wave" scope="row">
                                        <span class="placeholder placeholder-lg col-12"></span>
                                    </td>
                                    <td class="placeholder-wave" scope="row">
                                        <span class="placeholder placeholder-lg col-12"></span>
                                    </td>
                                    <td class="placeholder-wave" scope="row">
                                        <span class="placeholder placeholder-lg bg-danger col-8"></span>
                                    </td>

                                </tr>
                            @endfor
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
