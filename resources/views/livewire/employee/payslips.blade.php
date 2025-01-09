<div>
    <x-slot name="header">
        Your Payslips
    </x-slot>

    <div class="my-5">
        @livewire('employee.p9-forms')
    </div>
    <div class="row">
        <div class="card">
            <div class="card-header">
                <h5>My Payslips</h5>
            </div>
            <div class="card-body table-responsive">
                @if (count($payslips) > 0)
                    <table class="table">
                        <thead class="">
                            <tr>
                                <th class="">ID</th>
                                <th class="">Month</th>
                                <th scope="col">Designation</th>
                                <th scope="col">Contract Type</th>
                                <th scope="col" colspan="2" class="text-center">Contract(s)</th>
                                <th scope="col">Days Worked</th>
                                <th scope="col">Days on Leave</th>
                                <th scope="col">Days Absent <span class="text-danger">(-)</span></th>
                                <th scope="col">Total Gross Pay</th>
                                <th scope="col">NSSF Contribution <span class="text-danger">(-)</span></th>
                                <th scope="col">PAYE <span class="text-danger">(-)</span></th>
                                <th scope="col">NHIF Premium <span class="text-danger">(-)</span></th>
                                <th scope="col">SHA Premium <span class="text-danger">(-)</span></th>
                                <th scope="col">NITA <span class="text-danger">(-)</span></th>
                                <th scope="col">Housing Levy<span class="text-danger">(-)</span></th>
                                <th scope="col">Overtimes<span class="text-success">(+)</span></th>
                                <th scope="col">Bonuses<span class="text-success">(+)</span></th>
                                <th scope="col">Fines <span class="text-danger">(-)</span></th>
                                <th scope="col">Loan Repayment <span class="text-danger">(-)</span></th>
                                <th scope="col">Additions <span class="text-success">(+)</span></th>
                                <th scope="col">Deductions <span class="text-success">(+)</span></th>
                                <th scope="col">Net Pay</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payslips as $payslip)
                                <tr class="">
                                    <td class="text-black" scope="row">{{ $payslip->id }}</td>
                                    <td class="text-success">{{ $payslip->month_string }}</td>
                                    <td>{{ $payslip->employee->designation->title }}</td>
                                    <td class="text-uppercase">
                                        <strong>{{ $payslip->employee->ActiveContractDuring($payslip->payroll->year . '-' . $payslip->payroll->month)->employment_type->title }}</strong>
                                        <br>
                                        <small>({{ $payslip->is_taxable ? 'Is Taxable' : 'Is Not Taxable' }})</small>
                                    </td>
                                    <td width="45px" colspan="2">
                                        <small>
                                            @foreach ($payslip->employee->ActiveContractsDuring($payslip->payroll->year . '-' . $payslip->payroll->month) as $key => $contract)
                                                <li style="list-style-type: circle"> #{{ $contract->id }} <br>
                                                    Value: KES
                                                    <strong>{{ number_format($contract->salary_kes) }}
                                                        {{ $contract->is_casual() ? 'per day' : 'per month' }}</strong>
                                                    with
                                                    {{ $contract->netDaysWorked($payslip->payroll->year . '-' . $payslip->payroll->month) }}
                                                    days worked
                                                </li>
                                            @endforeach
                                        </small>
                                    </td>
                                    <td>{{ $payslip->days_worked }} days</td>
                                    <td>{{ $payslip->leave_days }} days</td>
                                    <td>{{ $payslip->days_missed }} days</td>
                                    <td>KES {{ number_format($payslip->gross_salary, 2) }} <small>(Daily Rate:
                                            KES{{ number_format($payslip->daily_rate, 2) }})</small></td>
                                    <td>KES {{ number_format($payslip->nssf, 2) }}</td>
                                    <td>KES {{ number_format($payslip->paye, 2) }}</td>
                                    <td>KES {{ number_format($payslip->nhif, 2) }}</td>
                                    <td>KES {{ number_format($payslip->shif, 2) }}</td>
                                    <td>KES {{ number_format($payslip->nita, 2) }}</td>
                                    <td>KES {{ number_format($payslip->housing_levy, 2) }}</td>
                                    <td>KES {{ number_format($payslip->overtimes, 2) }}</td>
                                    <td>KES {{ number_format($payslip->bonuses, 2) }}</td>
                                    <td>KES {{ number_format($payslip->fines, 2) }}</td>
                                    <td>KES {{ number_format($payslip->loans, 2) }}</td>
                                    <td>KES {{ number_format($payslip->total_additions, 2) }}</td>
                                    <td>KES {{ number_format($payslip->total_deductions, 2) }}</td>
                                    <td>
                                        <strong class="text-success">KES
                                            {{ number_format($payslip->net_pay, 2) }}</strong>
                                    </td>
                                    <td class="text-center">
                                        @if ($payslip->payroll->payments)
                                            <a href="{{ route('employee.payslips.view', $payslip->payroll_id) }}"
                                                target="_blank" class="btn btn-dark">
                                                <i class="material-icons material-symbols-outlined">
                                                    receipt_long
                                                </i>
                                            </a>
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
