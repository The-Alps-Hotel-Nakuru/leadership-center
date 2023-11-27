<div>
    <x-slot name="header">
        Your Payslips
    </x-slot>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body table-responsive">
                @if (count($payslips) > 0)
                    <table class="table">
                        <thead class="">
                            <tr>
                                <th class="">ID</th>
                                <th class="">Month</th>
                                <th class="">Gross Salary</th>
                                <th class="">NSSF</th>
                                <th class="">Taxable Income</th>
                                <th class="">Income Tax</th>
                                <th class="">Tax Relief</th>
                                <th class="">General Insurance Relief</th>
                                <th class="">Attendance Penalty</th>
                                <th class="">Total Tax Rebates</th>
                                <th class="bg-black text-white">PAYE</th>
                                <th class="bg-black text-white">NHIF</th>
                                <th class="bg-black text-white">Housing Levy</th>
                                <th class="">Total Bonuses</th>
                                <th class="">Total Fines</th>
                                <th class="bg-black text-white">Welfare Contribution</th>
                                <th></th>
                                <th class="bg-success text-white">NET SALARY</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payslips as $payslip)
                                <tr class="">
                                    <td class="text-black" scope="row">{{ $payslip->id }}</td>
                                    <td class="text-success">{{ $payslip->month_string }}</td>
                                    <td class="text-success">KES {{ number_format($payslip->gross_salary, 2) }}</td>
                                    <td class="text-danger">KES {{ number_format($payslip->nssf, 2) }}</td>
                                    <td class="text-secondary">KES {{ number_format($payslip->taxable_income, 2) }}</td>
                                    <td class="text-secondary">KES {{ number_format($payslip->income_tax, 2) }}</td>
                                    <td class="text-success">KES {{ number_format($payslip->tax_relief, 2) }}</td>
                                    <td class="text-success">KES {{ number_format($payslip->general_relief, 2) }}</td>
                                    <td class="text-danger">KES {{ number_format($payslip->attendance_penalty, 2) }}
                                    </td>
                                    <td class="text-success">KES {{ number_format($payslip->rebate, 2) }}</td>
                                    <td class="text-danger">KES {{ number_format($payslip->paye, 2) }}</td>
                                    <td class="text-danger">KES {{ number_format($payslip->nhif, 2) }}</td>
                                    <td class="text-danger">KES {{ number_format($payslip->housing_levy, 2) }}</td>
                                    <td class="text-success">KES {{ number_format($payslip->bonuses, 2) }}</td>
                                    <td class="text-danger">KES {{ number_format($payslip->fines, 2) }}</td>
                                    <td class="text-danger">KES {{ number_format($payslip->welfare_contributions, 2) }}
                                    </td>
                                    <td></td>
                                    <td class="text-black" style="font-weight:bold">KES
                                        {{ number_format($payslip->net_pay, 2) }}</td>
                                    <td class="d-flex flex-row">
                                        @if ($payslip->payroll->payment)
                                            <div class="flex-col mx-2">
                                                <a href="{{ route('employee.payslips.view', $payslip->id) }}"
                                                    target="_blank" class="btn btn-dark">
                                                    <i class="material-icons material-symbols-outlined">
                                                        receipt_long
                                                    </i>
                                                </a>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>

                        </tfoot>
                    </table>
                @else
                    <h1 class="text-center my-5">
                        No Payslips to Download
                    </h1>
                @endif
            </div>
        </div>

    </div>
</div>
