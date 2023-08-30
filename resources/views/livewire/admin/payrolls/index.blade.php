<div>
    <x-slot name="header">
        Payrolls
    </x-slot>
    <div class="container-fluid my-3">
        <div class="card">
            <div class="card-header">
                <h5>Generate Payroll</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="" class="form-label">Year</label>
                            <input wire:model="yearmonth" type="month" class="form-control" name=""
                                id="" aria-describedby="helpId" placeholder="Choose the Year">
                            @error('yearmonth')
                                <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <button wire:click="generate" class="btn btn-primary">Generate</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5>List of Generated Payrolls</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table
                table-hover
                align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Period</th>
                            <th>This Payroll Total</th>
                            <th>Total Gross Salary to Fixed Term Employees</th>
                            <th>Total Absence Penalty</th>
                            <th class="bg-dark text-white">Net Salary</th>
                            <th></th>
                            <th class="bg-dark text-white" >Casual Total Salary</th>
                            <th>Total PAYE</th>
                            <th>Total NHIF</th>
                            <th>Total NSSF</th>
                            <th>Total Housing Levy</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        @foreach ($payrolls as $payroll)
                            <tr class="">
                                <td scope="row">#{{ $payroll->id }}</td>
                                <td>{{ Carbon\Carbon::parse($payroll->year . '-' . $payroll->month)->format('F Y') }}
                                </td>
                                <td>KES <span class="text-primary">{{ number_format($payroll->total, 2) }}</span></td>
                                <td>KES <span
                                        class="text-success">{{ number_format($payroll->full_time_gross, 2) }}</span>
                                </td>
                                <td>KES <span class="text-success">{{ number_format($payroll->penalty_total, 2) }}</span>
                                </td>
                                <td class="text-white bg-secondary" style="font-size: 20px">KES <strong>{{ number_format($payroll->full_time_net, 2) }}</strong>
                                </td>
                                <td></td>
                                <td class="text-white bg-secondary" style="font-size: 20px">KES <strong >{{ number_format($payroll->casual_total, 2) }}</strong>
                                </td>
                                <td>KES <span class="text-success">{{ number_format($payroll->paye_total, 2) }}</span>
                                </td>
                                <td>KES <span class="text-success">{{ number_format($payroll->nhif_total, 2) }}</span>
                                </td>
                                <td>KES <span class="text-success">{{ number_format($payroll->nssf_total, 2) }}</span>
                                </td>
                                <td>KES <span class="text-success">{{ number_format($payroll->housing_levy_total, 2) }}</span>
                                </td>
                                <td>
                                    <div class="d-flex flex-row justify-content-center">
                                        <div class="flex-col m-3">
                                            <button wire:click="update({{ $payroll->id }})" class="btn btn-warning"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Update Current Payroll">
                                                <i class="material-icons material-symbols-outlined">update</i>
                                            </button>
                                        </div>
                                        <div class="flex-col m-3">
                                            <button class="btn btn-secondary" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Download Excel Breakdown" wire:click="downloadPayrollBreakdown({{ $payroll->id }})">
                                                <i class="material-icons material-symbols-outlined">description</i>
                                            </button>
                                        </div>
                                        <div class="flex-col m-3">
                                            <button class="btn btn-dark" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Make Payments" wire:click="makePayment({{ $payroll->id }})">
                                                <i class="material-icons material-symbols-outlined">monetization_on</i>
                                            </button>
                                        </div>
                                        <div class="flex-col m-3">
                                            <a href="{{ route('admin.payrolls.show', $payroll->id) }}"
                                                class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="View Payroll Breakdown">
                                                <i class="material-icons material-symbols-outlined">list</i>
                                            </a>
                                        </div>
                                        <div class="flex-col m-3">
                                            <button wire:click="delete({{ $payroll->id }})" class="btn btn-danger" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>



    </div>
</div>
