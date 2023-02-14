<div>
    <x-slot name="header">
        Your Payslips
    </x-slot>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table">
                    <thead class="">
                        <tr>
                            <th>ID</th>
                            <th>Month</th>
                            <th>Gross Salary</th>
                            <th>NSSF</th>
                            <th class="bg-dark">Taxable Income</th>
                            <th>PAYE</th>
                            <th>NHIF</th>
                            <th class="bg-dark">After Deductions</th>
                            <th>Tax Relief</th>
                            <th>General Relief</th>
                            <th class="bg-dark">After Relief</th>
                            <th>Attendance Penalty</th>
                            <th>Total Bonuses</th>
                            <th>Total Fines</th>
                            <th>Total Rebates</th>
                            <th class="bg-primary text-white">Net Income</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payslips as $payslip)
                            <tr class="">
                                <td scope="row">{{ $payslip->id }}</td>
                                <td>{{ $payslip->month_string }}</td>
                                <td>KES {{ number_format($payslip->gross_salary, 2) }}</td>
                                <td>KES {{ number_format($payslip->nssf, 2) }}</td>
                                <td>KES {{ number_format($payslip->taxable_income, 2) }}</td>
                                <td>KES {{ number_format($payslip->paye, 2) }}</td>
                                <td>KES {{ number_format($payslip->nhif, 2) }}</td>
                                @php
                                    $after = $payslip->taxable_income - ($payslip->paye + $payslip->nhif);
                                    $after2 = $after + ($payslip->tax_relief + $payslip->general_relief);
                                @endphp
                                <td>KES {{ number_format($after, 2) }}</td>
                                <td>KES {{ number_format($payslip->tax_relief, 2) }}</td>
                                <td>KES {{ number_format($payslip->general_relief, 2) }}</td>
                                <td>KES {{ number_format($after2, 2) }}</td>
                                <td>KES {{ number_format($payslip->attendance_penalty, 2) }}</td>
                                <td>KES {{ number_format($payslip->bonuses, 2) }}</td>
                                <td>KES {{ number_format($payslip->fines, 2) }}</td>
                                <td>KES {{ number_format($payslip->rebate, 2) }}</td>
                                <td class="bg-primary text-white" style="font-weight:bold">KES
                                    {{ number_format($payslip->net_pay, 2) }}</td>
                                <td class="d-flex flex-row">
                                    <div class="flex-col mx-2">
                                        <a href="{{ route('employee.payslips.view', $payslip->id) }}"
                                            class="btn btn-dark">
                                            <i class="material-icons material-symbols-outlined">
                                                receipt_long
                                            </i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>

                    </tfoot>
                </table>
            </div>
        </div>

    </div>
</div>
