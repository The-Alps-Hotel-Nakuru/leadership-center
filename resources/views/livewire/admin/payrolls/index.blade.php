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
                            <input wire:model.live="yearmonth" type="month" class="form-control" name=""
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
                            <th>Total PAYE</th>
                            <th>Total NSSF</th>
                            <th>Total NHIF</th>
                            <th>Total SHIF</th>
                            <th>Total NITA</th>
                            <th>Total Housing Levy</th>
                            <th>Total Advances</th>
                            <th>Total Overtimes</th>
                            <th>Total Bonuses</th>
                            <th>Total Fines</th>
                            <th>Total Loans</th>
                            <th>Staff Welfare Contributions</th>
                            <th>Total NET PAY</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">

                        @foreach ($payrolls as $payroll)
                            <tr class="">
                                <td scope="row">#{{ $payroll->id }}</td>
                                <td>{{ Carbon\Carbon::parse($payroll->year . '-' . $payroll->month)->format('F Y') }}
                                </td>
                                <td>KES <span class="text-primary">{{ number_format($payroll->total, 2) }}</span>
                                </td>
                                <td>KES <span class="text-success">{{ number_format($payroll->paye_total, 2) }}</span>
                                </td>
                                <td>KES <span class="text-success">{{ number_format($payroll->nssf_total, 2) }}</span>
                                </td>
                                <td>KES <span class="text-success">{{ number_format($payroll->nhif_total, 2) }}</span>
                                </td>
                                <td>KES <span class="text-success">{{ number_format($payroll->shif_total, 2) }}</span>
                                </td>
                                <td>KES <span class="text-success">{{ number_format($payroll->nita_total, 2) }}</span>
                                </td>
                                <td>KES <span
                                        class="text-success">{{ number_format($payroll->housing_levy_total, 2) }}</span>
                                </td>

                                <td>
                                    KES
                                    <span class="text-success">{{ number_format($payroll->advances_total, 2) }}
                                    </span>
                                </td>
                                <td>
                                    KES
                                    <span class="text-success">{{ number_format($payroll->overtimes_total, 2) }}
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
                                <td class="bg-dark text-white">KES <span
                                        class="text-success">{{ number_format($payroll->net_pay_total, 2) }}</span>
                                </td>
                                <td>
                                    <div class="d-flex flex-row my-1 justify-content-center">

                                        <div class="flex-col m-3">
                                            <button class="btn btn-secondary" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Update Payroll"
                                                wire:click="update({{ $payroll->id }})">
                                                <i wire:loading.remove wire:target='update({{ $payroll->id }})' class="bi bi-arrow-repeat"></i>
                                                <i wire:loading wire:target='update({{ $payroll->id }})' class="spinner-border spinner-border-sm"></i>
                                            </button>
                                        </div>
                                        <div class="flex-col m-3">
                                            <button class="btn btn-secondary" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Download Payroll Breakdown"
                                                wire:click="downloadPayrollBreakdown({{ $payroll->id }})">
                                                <i wire:loading.remove wire:target='downloadPayrollBreakdown({{ $payroll->id }})' class="bi bi-file-earmark-spreadsheet"></i>
                                                <i wire:loading wire:target='downloadPayrollBreakdown({{ $payroll->id }})' class="spinner-border spinner-border-sm"></i>
                                            </button>
                                        </div>
                                        @if (!count($payroll->payments) > 0)
                                            <div class="flex-col m-3">
                                                <button class="btn btn-dark" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Make Payments"
                                                    wire:click="makePayment({{ $payroll->id }})">
                                                    <i wire:loading.remove wire:target='makePayment({{ $payroll->id }})' class="bi bi-wallet2"></i>
                                                    <i wire:loading wire:target='makePayment({{ $payroll->id }})' class="spinner-border spinner-border-sm"></i>
                                                </button>
                                            </div>
                                        @else
                                            <div class="flex-col m-3">
                                                <button class="btn btn-primary" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Download Statutories Breakdown"
                                                    wire:click="downloadStatutoriesBreakdown({{ $payroll->id }})">
                                                    <i wire:loading.remove wire:target='downloadStatutoriesBreakdown({{ $payroll->id }})' class="bi bi-list-check"></i>
                                                    <i wire:loading wire:target='downloadStatutoriesBreakdown({{ $payroll->id }})' class="spinner-border spinner-border-sm"></i>
                                                </button>
                                            </div>
                                            <div class="flex-col m-3">
                                                <button class="btn btn-success" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Download Banking Bulk File"
                                                    wire:click="downloadBankSlip({{ $payroll->id }})">
                                                    <i wire:loading.remove wire:target='downloadBankSlip({{ $payroll->id }})' class="bi bi-file-earmark-arrow-down"></i>
                                                    <i wire:loading wire:target='downloadBankSlip({{ $payroll->id }})' class="spinner-border spinner-border-sm"></i>
                                                </button>
                                            </div>
                                        @endif
                                        @if (count($payroll->payments) > 0)
                                            <div class="flex-col m-3">
                                                <a href="{{ route('admin.payrolls.upload_payment', $payroll->id) }}"
                                                    class="btn btn-{{ $payroll->is_paid ? 'success' : 'secondary' }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Upload Payment Slip">
                                                    <i
                                                        class="bi bi-{{ $payroll->is_paid ? 'check-circle' : 'upload' }}">
                                                    </i>
                                                </a>
                                            </div>
                                        @endif
                                        <div class="flex-col m-3">
                                            <a href="{{ route('admin.payrolls.show', $payroll->id) }}"
                                                class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="View Payroll Breakdown">
                                                <i class="bi bi-list-columns"></i>
                                            </a>
                                        </div>

                                        @if (file_exists('/' . $payroll->month_string . '.pdf'))
                                            <a href="/{{ $payroll->month_string . '.pdf' }}">
                                                <i class="bi bi-download"></i>

                                            </a>
                                        @endif
                                        <div class="flex-col m-3">
                                            <button wire:click="delete({{ $payroll->id }})" class="btn btn-danger"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Payroll" wire:loading.attr="disabled" wire:target="delete({{ $payroll->id }})">
                                                <i wire:loading.remove wire:target="delete({{ $payroll->id }})" class="bi bi-trash"></i>
                                                <i wire:loading wire:target="delete({{ $payroll->id }})" class="spinner-border spinner-border-sm" ></i>

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

        @if ($payrolls)
            {{ $payrolls->links() }}
        @endif



    </div>
</div>
