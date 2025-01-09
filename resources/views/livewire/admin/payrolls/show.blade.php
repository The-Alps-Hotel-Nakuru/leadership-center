<div>
    <x-slot name="header"> Payroll Breakdown for
        {{ Carbon\Carbon::parse($payroll->year . '-' . $payroll->month)->format('F Y') }}</x-slot>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5>Employees</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table ">
                    <thead>
                        <tr>
                            <th scope="col">Employee ID</th>
                            <th scope="col">Full Name</th>
                            <th scope="col">Designation</th>
                            <th scope="col">Contract Type</th>
                            <th scope="col" colspan="2" class="text-center">Contract(s)</th>
                            <th scope="col">Days Worked</th>
                            <th scope="col">Days on Leave</th>
                            <th scope="col">Days Absent <span class="text-danger">(-)</span></th>
                            <th scope="col">Total Gross Pay</th>
                            <th scope="col">NSSF Contribution <span class="text-danger">(-)</span></th>
                            <th scope="col">PAYE <span class="text-danger">(-)</span></th>
                            @if ($payroll->monthlySalaries)
                            @endif
                            <th scope="col">NHIF Premium <span class="text-danger">(-)</span></th>
                            <th scope="col">SHA Premium <span class="text-danger">(-)</span></th>
                            <th scope="col">NITA <span class="text-danger">(-)</span></th>
                            <th scope="col">Housing Levy<span class="text-danger">(-)</span></th>
                            <th scope="col">Overtimes<span class="text-success">(+)</span></th>
                            <th scope="col">Bonuses<span class="text-success">(+)</span></th>
                            <th scope="col">Fines <span class="text-danger">(-)</span></th>
                            <th scope="col">Loan Repayment <span class="text-danger">(-)</span></th>
                            <th scope="col">Welfare Contributions <span class="text-danger">(-)</span></th>
                            <th scope="col">Additions <span class="text-success">(+)</span></th>
                            <th scope="col">Deductions <span class="text-success">(+)</span></th>
                            <th scope="col">Net Pay</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $count = 0;
                            $total_gross = 0;
                            $total_nhif = 0;
                            $total_shif = 0;
                            $total_paye = 0;
                            $total_nssf = 0;
                            $total_nita = 0;
                            $total_housing_levy = 0;
                            $total_overtimes = 0;
                            $total_pen = 0;
                            $total_additions = 0;
                            $total_deductions = 0;
                            $total_net = 0;
                            $total_rebate = 0;
                            $total_bonuses = 0;
                            $total_fines = 0;
                            $total_loans = 0;
                            $total_welfare = 0;
                        @endphp
                        @foreach ($payroll->monthlySalaries()->orderBy('basic_salary_kes', 'DESC')->get() as $salary)
                            <tr class="">
                                <td scope="row">{{ $salary->id }}</td>
                                <td>{{ $salary->employee->user->name }}</td>
                                <td>{{ $salary->employee->designation->title }}</td>
                                <td class="text-uppercase">
                                    <strong>{{ $salary->employee->ActiveContractDuring($salary->payroll->year . '-' . $salary->payroll->month)->employment_type->title }}</strong>
                                    <br>
                                    <small>({{ $salary->is_taxable ? 'Is Taxable' : 'Is Not Taxable' }})</small>
                                </td>
                                <td width="60px" colspan="2">
                                    <small>
                                        @foreach ($salary->employee->ActiveContractsDuring($salary->payroll->year . '-' . $salary->payroll->month) as $key => $contract)
                                            <li style="list-style-type: circle"> #{{ $contract->id }} <br>
                                                Value:
                                                <strong><small>KES </small>{{ number_format($contract->salary_kes) }}
                                                    {{ $contract->is_net ? 'Net ' : 'Gross ' }}
                                                    {{ $contract->is_casual() ? 'per day ' : 'per month ' }}</strong>
                                                with
                                                {{ $contract->netDaysWorked($salary->payroll->year . '-' . $salary->payroll->month) }}
                                                days worked
                                            </li>
                                        @endforeach
                                    </small>
                                </td>
                                <td>{{ $salary->days_worked }} days</td>
                                <td>{{ $salary->leave_days }} days</td>
                                <td>{{ $salary->days_missed }} days</td>
                                <td>KES {{ number_format($salary->gross_salary, 2) }} <small>(Daily Rate:
                                        KES{{ number_format($salary->daily_rate, 2) }})</small></td>
                                <td>KES {{ number_format($salary->nssf, 2) }}</td>
                                <td>KES {{ number_format($salary->paye, 2) }}</td>
                                <td>KES {{ number_format($salary->nhif, 2) }}</td>
                                <td>KES {{ number_format($salary->shif, 2) }}</td>
                                <td>KES {{ number_format($salary->nita, 2) }}</td>
                                <td>KES {{ number_format($salary->housing_levy, 2) }}</td>
                                <td>KES {{ number_format($salary->overtimes, 2) }}</td>
                                <td>KES {{ number_format($salary->bonuses, 2) }}</td>
                                <td>KES {{ number_format($salary->fines, 2) }}</td>
                                <td>KES {{ number_format($salary->loans, 2) }}</td>
                                <td>KES {{ number_format($salary->welfare_contributions, 2) }}</td>
                                <td>KES {{ number_format($salary->total_additions, 2) }}</td>
                                <td>KES {{ number_format($salary->total_deductions, 2) }}</td>
                                <td>
                                    <strong class="text-success">KES
                                        {{ number_format($salary->net_pay, 2) }}</strong>
                                </td>
                                <td>
                                    <div class="flex-col m-2">
                                        <a href="{{ route('doc.payslip', $salary->id) }}" class="btn btn-primary"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="View Payslip">
                                            <i class="bi bi-file-earmark-pdf">
                                            </i>
                                        </a>
                                    </div>
                                </td>
                                @php
                                    $count++;
                                    $total_gross += $salary->gross_salary;
                                    $total_nhif += $salary->nhif;
                                    $total_shif += $salary->shif;
                                    $total_paye += $salary->paye;
                                    $total_nssf += $salary->nssf;
                                    $total_nita += $salary->nita;
                                    $total_housing_levy += $salary->housing_levy;
                                    $total_overtimes += $salary->overtimes;
                                    $total_bonuses += $salary->bonuses;
                                    $total_fines += $salary->fines;
                                    $total_loans += $salary->loans;
                                    $total_welfare += $salary->welfare_contributions;
                                    $total_additions += $salary->total_additions;
                                    $total_deductions += $salary->total_deductions;
                                    $total_net += $salary->net_pay;
                                @endphp
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td><strong>TOTALS</strong></td>
                            <td class="text-primary"> <strong>{{ $count }} <br> Employees</strong>
                            </td>
                            <td></td>
                            <td colspan="2"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-primary"><strong>KES {{ number_format($total_gross, 2) }}</strong></td>
                            <td class="text-danger"><strong>KES {{ number_format($total_nssf, 2) }}</strong></td>
                            <td class="text-danger"><strong>KES {{ number_format($total_paye, 2) }}</strong></td>

                            <td class="text-danger"><strong>KES {{ number_format($total_nhif, 2) }}</strong></td>

                            <td class="text-danger"><strong>KES {{ number_format($total_shif, 2) }}</strong></td>

                            <td class="text-danger"><strong>KES {{ number_format($total_nita, 2) }}</strong></td>
                            <td class="text-danger"><strong>KES {{ number_format($total_housing_levy, 2) }}</strong>
                            </td>
                            <td class="text-success"><strong>KES {{ number_format($total_overtimes, 2) }}</strong>
                            </td>
                            <td class="text-success"><strong>KES {{ number_format($total_bonuses, 2) }}</strong></td>
                            <td class="text-danger"><strong>KES {{ number_format($total_fines, 2) }}</strong></td>
                            <td class="text-danger"><strong>KES {{ number_format($total_loans, 2) }}</strong></td>
                            <td class="text-danger"><strong>KES {{ number_format($total_welfare, 2) }}</strong></td>
                            <td class="text-success"><strong>KES {{ number_format($total_additions, 2) }}</strong></td>
                            <td class="text-success"><strong>KES {{ number_format($total_deductions, 2) }}</strong>
                            </td>
                            <td class="bg-dark text-white"><strong>KES <span
                                        class="text-success">{{ number_format($total_net, 2) }}</span></strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
