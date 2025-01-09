<div>
    <x-slot:header>
        Payroll Payments List
    </x-slot:header>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5>List of Payroll Payments -
                    {{ Carbon\Carbon::parse($payroll->year . '-' . $payroll->month)->format('F, Y') }}</h5>
            </div>

            <div class="card-body table-responsive">

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Full Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Gross Salary</th>
                            <th scope="col">NSSF Contribution</th>
                            <th scope="col">NHIF Premium</th>
                            <th scope="col">Housing Levy</th>
                            <th scope="col">PAYE</th>
                            <th scope="col">Attendance Bonuses/Penalty</th>
                            <th scope="col">Tax Additions/Rebates</th>
                            <th scope="col">Advances</th>
                            <th scope="col">Bonuses</th>
                            <th scope="col">Welfare Contributions</th>
                            <th scope="col">Fines</th>
                            <th scope="col">Loans</th>
                            <th scope="col" class="bg-dark text-white">NET PAY</th>
                            <th scope="col">Bank Account</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payments as $key => $payment)
                            @if ($payment->net_pay > 0)
                                <tr class="">
                                    <td scope="row">{{ $key + 1 }}</td>
                                    <td>{{ $payment->employee->user->name }}</td>
                                    <td>{{ $payment->employee->user->email }}</td>
                                    <td>KES {{ number_format($payment->gross_salary, 2) }}</td>
                                    <td>KES {{ number_format($payment->nssf) }}</td>
                                    <td>KES {{ number_format($payment->nhif) }}</td>
                                    <td>KES {{ number_format($payment->housing_levy, 4) }}</td>
                                    <td>KES {{ number_format($payment->paye, 4) }}</td>
                                    <td>KES {{ number_format($payment->attendance_penalty, 2) }}</td>
                                    <td>KES {{ number_format($payment->tax_rebate, 4) }}</td>
                                    <td>KES {{ number_format($payment->total_advances) }}</td>
                                    <td>KES {{ number_format($payment->total_bonuses, 2) }}</td>
                                    <td>KES {{ number_format($payment->total_welfare_contributions, 2) }}</td>
                                    <td>KES {{ number_format($payment->total_fines, 2) }}</td>
                                    <td>KES {{ number_format($payment->total_loans, 2) }}</td>
                                    <td class="bg-success text-white">KES
                                        <strong>{{ number_format($payment->net_pay, 2) }}</strong>
                                    </td>
                                    <td>
                                        {{ $payment->bank->name }}
                                        <br>
                                        {{ $payment->account_number }}
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
