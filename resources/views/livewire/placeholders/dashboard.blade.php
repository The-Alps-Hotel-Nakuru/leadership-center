<div>
    <x-slot name="header">Administrator's Dashboard</x-slot>

    <div class="row mb-5">
        <div class="col-md-4 col-12 ">
            <div class="card bg-gradient-maroon text-white mb-3 h-100" style="padding: 30px">
                <div class="d-flex">
                    <div class="align-self-center">
                        <h3 class="m-b-0 placeholder-glow">
                            <span class="placeholder bg-white"></span>
                        </h3>
                        <small class="placeholder-glow">
                            <span class="placeholder"></span>
                        </small>
                    </div>
                </div>
                <div class="d-flex h-100">
                    <div class=" ms-auto mt-auto text-success" style="font-size: xx-large">
                        <sup>KES</sup>
                        <h2 class="">
                            <span class="placeholder bg-success"></span>
                        </h2>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-8 col-12">
            <div class="card mb-3 shadow">
                <div class="card-header bg-transparent border-0  ">
                    <div class="d-flex flex-row justify-content-center align-items-center">
                        <input class="form-control" type="month" wire:model.live="month">
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
                                            Overtimes</h6>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-12 col-xl-9">
                                            <small>KES</small>
                                            <div class="d-flex align-items-baseline ms-auto">
                                                <h4 class="mb-2">
                                                    <span class="placeholder"></span>
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
                                                    <span class="placeholder"></span>
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
                                                    <span class="placeholder"></span>
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
                                                <h4 class="mb-2">
                                                    <span class="placeholder"></span>
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
                <div style="height: 25rem;">
                    <div class="card-body d-flex justify-content-center m-auto">
                        <strong>Loading...</strong>
                        <span class="spinner-border text-right ml   -auto" role="status"></span>
                    </div>
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
                                <th scope="col"><span class="placeholder"></span></th>
                                <th scope="col"><span class="placeholder"></span></th>
                                <th scope="col"><span class="placeholder"></span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="">
                                <td scope="row">
                                    <span class="placeholder"></span>
                                </td>
                                <td colspan="1">
                                    <span class="placeholder"></span>
                                </td>
                                <td>
                                    <span class="placeholder"></span>
                                </td>
                            </tr>
                            <tr class="">
                                <td scope="row">
                                    <span class="placeholder"></span>
                                </td>
                                <td colspan="1">
                                    <span class="placeholder"></span>
                                </td>
                                <td>
                                    <span class="placeholder"></span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                @if ($logs)
                    <div class="card-footer">
                        {{ $logs->links() }}
                    </div>
                @endif
            </div>

        </div>
        @if ($incompleteEmployees)
            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="text-center">Incomplete Full Time Employees</h5>
                    </div>
                    <div class="table-responsive card-body" style="max-height: 450px">
                        <table class="table">
                            @if ($incompleteEmployees === null)
                                <div class="card-body d-flex justify-content-center">
                                    <strong>Loading...</strong>
                                    <span class="spinner-border text-right ml-auto" role="status"></span>
                                </div>
                            @else
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
                            @endif
                        </table>
                    </div>

                </div>
            </div>
        @endif
        <div class="card mt-3">
            <div class="card-body">
                <div class="row">
                    <button class="btn btn-primary disabled placeholder">

                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
