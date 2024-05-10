<div wire:init='loadItems'>
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
                    <button class="btn btn-primary" wire:loading.attr="disabled" wire:target="generate"
                        wire:click="generate">
                        <span wire:loading.remove wire:target="generate">
                            Generate
                        </span>
                        <span wire:loading wire:target="generate">
                            Generating...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid" wire:loading.class='disabled'>
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
                            <th>Full Timers </th>
                            <th>Casuals</th>
                            <th>Interns</th>
                            <th>External Employees</th>
                            <th>Total Absence Penalty/Bonus</th>
                            <th>Total Advances</th>
                            <th>Total Bonuses</th>
                            <th>Total Fines</th>
                            <th>Total Loans</th>
                            <th>Staff Welfare Contributions</th>
                            <th>Total PAYE</th>
                            <th>Total NHIF</th>
                            <th>Total NSSF</th>
                            <th>Total Housing Levy</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        @if (!$payrolls)
                            <tr>
                                <th>
                                    <div class="spinner-grow" role="status"></div>
                                </th>
                                <th>
                                    <div class="spinner-grow" role="status"></div>
                                </th>
                                <th>
                                    <div class="spinner-grow" role="status"></div>
                                </th>

                                <th>
                                    <div class="spinner-grow" role="status"></div>
                                </th>
                                <th>
                                    <div class="spinner-grow" role="status"></div>
                                </th>
                                <th>
                                    <div class="spinner-grow" role="status"></div>
                                </th>
                                <th>
                                    <div class="spinner-grow" role="status"></div>
                                </th>
                                <th>
                                    <div class="spinner-grow" role="status"></div>
                                </th>
                                <th>
                                    <div class="spinner-grow" role="status"></div>
                                </th>
                                <th>
                                    <div class="spinner-grow" role="status"></div>
                                </th>
                                <th>
                                    <div class="spinner-grow" role="status"></div>
                                </th>
                                <th>
                                    <div class="spinner-grow" role="status"></div>
                                </th>
                                <th>
                                    <div class="spinner-grow" role="status"></div>
                                </th>
                                <th>
                                    <div class="spinner-grow" role="status"></div>
                                </th>
                                <th>
                                    <div class="spinner-grow" role="status"></div>
                                </th>
                                <th>
                                    <div class="spinner-grow" role="status"></div>
                                </th>
                                <th>
                                    <div class="spinner-grow" role="status"></div>
                                </th>
                                <th>
                                    <div class="spinner-grow" role="status"></div>
                                </th>
                            </tr>
                        @else
                            @foreach ($payrolls as $payroll)
                                <tr class="">
                                    <td scope="row">#{{ $payroll->id }}</td>
                                    <td>{{ Carbon\Carbon::parse($payroll->year . '-' . $payroll->month)->format('F Y') }}
                                    </td>
                                    <td>KES <span class="text-primary">{{ number_format($payroll->total, 2) }}</span>
                                    </td>
                                    <td>KES <span
                                            class="text-success">{{ number_format($payroll->full_time_gross, 2) }}</span>
                                    </td>
                                    <td>KES <span
                                            class="text-success">{{ number_format($payroll->casual_gross, 2) }}</span>
                                    </td>
                                    <td>KES <span
                                            class="text-success">{{ number_format($payroll->intern_gross, 2) }}</span>
                                    </td>
                                    <td>KES <span
                                            class="text-success">{{ number_format($payroll->external_gross, 2) }}</span>
                                    </td>
                                    <td>KES <span
                                            class="text-success">{{ number_format($payroll->penalty_total, 2) }}</span>
                                    </td>

                                    <td>
                                        KES
                                        <span class="text-success">{{ number_format($payroll->advances_total, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        KES
                                        <span class="text-success">{{ number_format($payroll->bonuses_total, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        KES
                                        <span class="text-success">{{ number_format($payroll->fines_total, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        KES
                                        <span class="text-success">{{ number_format($payroll->loans_total, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        KES
                                        <span
                                            class="text-success">{{ number_format($payroll->welfare_contributions_total, 2) }}
                                        </span>
                                    </td>
                                    <td>KES <span
                                            class="text-success">{{ number_format($payroll->paye_total, 2) }}</span>
                                    </td>
                                    <td>KES <span
                                            class="text-success">{{ number_format($payroll->nhif_total, 2) }}</span>
                                    </td>
                                    <td>KES <span
                                            class="text-success">{{ number_format($payroll->nssf_total, 2) }}</span>
                                    </td>
                                    <td>KES <span
                                            class="text-success">{{ number_format($payroll->housing_levy_total, 2) }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-row my-1 justify-content-center">

                                            <div class="flex-col m-3">
                                                <button class="btn btn-secondary" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Update Payroll"
                                                    wire:click="update({{ $payroll->id }})">
                                                    <i class="material-icons material-symbols-outlined">update</i>
                                                </button>
                                            </div>
                                            <div class="flex-col m-3">
                                                <button class="btn btn-secondary" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Download Excel Breakdown"
                                                    wire:click="downloadPayrollBreakdown({{ $payroll->id }})">
                                                    <i class="material-icons material-symbols-outlined">description</i>
                                                </button>
                                            </div>
                                            @if (!count($payroll->payments) > 0)
                                                <div class="flex-col m-3">
                                                    <button class="btn btn-dark" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Make Payments"
                                                        wire:click="makePayment({{ $payroll->id }})">
                                                        <i
                                                            class="material-icons material-symbols-outlined">monetization_on</i>
                                                    </button>
                                                </div>
                                            @else
                                                <div class="flex-col m-3">
                                                    <button class="btn btn-success" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Download Banking Guide"
                                                        wire:click="downloadBankSlip({{ $payroll->id }})">
                                                        <i
                                                            class="material-icons material-symbols-outlined">monetization_on</i>
                                                    </button>
                                                </div>
                                            @endif
                                            @if (count($payroll->payments) > 0)
                                                <div class="flex-col m-3">
                                                    <a href="{{ route('admin.payrolls.upload_payment', $payroll->id) }}"
                                                        class="btn
                                                    @if ($payroll->is_paid) btn-success
                                                    @else
                                                    btn-secondary @endif"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Upload Payment Slip">
                                                        <i class="material-icons material-symbols-outlined">
                                                            @if ($payroll->is_paid)
                                                                file_download_done
                                                            @else
                                                                upload_file
                                                            @endif
                                                        </i>
                                                    </a>
                                                </div>
                                            @endif
                                            <div class="flex-col m-3">
                                                <a href="{{ route('admin.payrolls.show', $payroll->id) }}"
                                                    class="btn btn-primary" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="View Payroll Breakdown">
                                                    <i class="material-icons material-symbols-outlined">list</i>
                                                </a>
                                            </div>

                                            @if (file_exists('/' . $payroll->month_string . '.pdf'))
                                                <a href="/{{ $payroll->month_string . '.pdf' }}">
                                                    <i class="material-icons material-symbols-outlined">download</i>

                                                </a>
                                            @endif
                                            <div class="flex-col m-3">
                                                <button wire:click="delete({{ $payroll->id }})"
                                                    class="btn btn-danger" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        @if ($payrolls)
            {{ $payrolls->links() }}
        @endif



    </div>
</div>
