<div>
    <x-slot name="header"> Payroll Breakdown for
        {{ Carbon\Carbon::parse($payroll->year . '-' . $payroll->month)->format('F Y') }}</x-slot>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5>Full Time Employees</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table ">
                    <thead>
                        <tr>
                            <th scope="col">Employee ID</th>
                            <th scope="col">Full Name</th>
                            <th scope="col">Designation</th>
                            <th scope="col">Contract Type</th>
                            <th scope="col">Net Pay</th>
                            <th scope="col">NHIF Premium</th>
                            <th scope="col">NSSF Contribution</th>
                            <th scope="col">Total Gross Pay</th>
                            <th scope="col">Additions</th>
                            <th scope="col">Absence Penalty </th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payroll->monthlySalaries as $salary)
                            @if ($salary->employee->active_contract)
                                <tr class="">
                                    <td scope="row">{{ $salary->id }}</td>
                                    <td>{{ $salary->employee->user->name }}</td>
                                    <td>{{ $salary->employee->designation->title }}</td>
                                    <td>{{ $salary->employee->active_contract->employment_type->title }}</td>
                                    <td>KES {{ number_format($salary->net_pay, 2) }}</td>
                                    <td>KES {{ number_format($salary->nhif) }}</td>
                                    <td>KES {{ number_format($salary->nssf, 2) }}</td>
                                    <td>KES {{ number_format($salary->gross_salary, 2) }}</td>
                                    <td>KES {{ number_format($salary->total_additions, 2) }}</td>
                                    <td>KES {{ number_format($salary->attendance_penalty, 2) }} @if ($salary->employee->is_full_time)
                                            for {{ $salary->days_missed }} Days Missed'
                                        @endif
                                    </td>
                                    <td class="d-flex flex-row justify-content-center">
                                        <div class="flex-col m-2">
                                            <button wire:click="payslip({{ $salary->id }})" class="btn btn-secondary">
                                                <i class="material-icons material-symbols-outlined" data-bs-toggle="tooltip" data-bs-placement="top" title="Generate Payslip">
                                                    list
                                                </i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
