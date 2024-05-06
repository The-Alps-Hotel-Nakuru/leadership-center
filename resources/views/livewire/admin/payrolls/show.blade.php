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
                            <th scope="col">Days Worked</th>
                            <th scope="col">Total Gross Pay</th>
                            <th scope="col">NSSF Contribution <span class="text-danger">(-)</span></th>
                            <th scope="col">PAYE <span class="text-danger">(-)</span></th>
                            <th scope="col">NHIF Premium <span class="text-danger">(-)</span></th>
                            <th scope="col">Housing Levy<span class="text-danger">(-)</span></th>
                            <th scope="col">Absence Penalty <span class="text-danger">(-)</span></th>
                            <th scope="col"> Bonuses <span class="text-success">(+)</span></th>
                            <th scope="col">Fines <span class="text-danger">(-)</span></th>
                            <th scope="col">Loan Repayment<span class="text-danger">(-)</span></th>
                            <th scope="col">Tax Rebate <span class="text-success">(+)</span></th>
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
                            $total_paye = 0;
                            $total_nssf = 0;
                            $total_housing_levy = 0;
                            $total_pen = 0;
                            $total_additions = 0;
                            $total_deductions = 0;
                            $total_net = 0;
                            $total_rebate = 0;
                            $total_bonuses = 0;
                            $total_fines = 0;
                            $total_loans = 0;
                        @endphp
                        @foreach ($payroll->monthlySalaries()->orderBy('basic_salary_kes', 'DESC')->get() as $salary)
                            @if (
                                $salary->employee->ActiveContractBetween(Carbon\Carbon::parse($payroll->year . '-' . $payroll->month)->firstOfMonth(),
                                        Carbon\Carbon::parse($payroll->year . '-' . $payroll->month)->lastOfMonth())->is_full_time())
                                <tr class="">
                                    <td scope="row">{{ $salary->id }}</td>
                                    <td>{{ $salary->employee->user->name }}</td>
                                    <td>{{ $salary->employee->designation->title }}</td>
                                    <td>{{ $salary->employee->daysWorked($salary->payroll->year . '-' . $salary->payroll->month) }}
                                        Days</td>
                                    <td>KES {{ number_format($salary->gross_salary, 2) }} <small>(Daily Rate:
                                            KES{{ number_format($salary->daily_rate, 2) }})</small></td>
                                    <td>KES {{ number_format($salary->nssf, 2) }}</td>
                                    <td>KES {{ number_format($salary->paye, 2) }}</td>
                                    <td>KES {{ number_format($salary->nhif, 2) }}</td>
                                    <td>KES {{ number_format($salary->housing_levy, 2) }}</td>
                                    <td>KES {{ number_format($salary->attendance_penalty, 2) }}
                                        @if (
                                            $salary->employee->isFullTimeBetween(Carbon\Carbon::parse($payroll->year . '-' . $payroll->month)->firstOfMonth(),
                                                    Carbon\Carbon::parse($payroll->year . '-' . $payroll->month)->lastOfMonth()))
                                            <br><small class="text-muted"> for {{ $salary->days_missed }} Days
                                                Missed</small>
                                        @endif
                                    </td>
                                    <td>KES {{ number_format($salary->bonuses, 2) }}</td>
                                    <td>KES {{ number_format($salary->fines, 2) }}</td>
                                    <td>KES {{ number_format($salary->loans, 2) }}</td>
                                    <td>KES {{ number_format($salary->rebate, 2) }}</td>
                                    <td>KES {{ number_format($salary->total_additions, 2) }}</td>
                                    <td>KES {{ number_format($salary->total_deductions, 2) }}</td>
                                    <td>
                                        <strong class="text-success">KES
                                            {{ number_format($salary->net_pay, 2) }}</strong>
                                    </td>
                                    <td class="d-flex flex-row justify-content-center">
                                        <div class="flex-col m-2">
                                            <a href="{{ route('doc.payslip', $salary->id) }}" class="btn btn-primary">
                                                <i class="material-icons material-symbols-outlined"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="View Payslip">
                                                    receipt_long
                                                </i>
                                            </a>
                                        </div>
                                    </td>
                                    @php
                                        $count++;
                                        $total_gross += $salary->gross_salary;
                                        $total_nhif += $salary->nhif;
                                        $total_paye += $salary->paye;
                                        $total_nssf += $salary->nssf;
                                        $total_housing_levy += $salary->housing_levy;
                                        $total_pen += $salary->attendance_penalty;
                                        $total_bonuses += $salary->bonuses;
                                        $total_fines += $salary->fines;
                                        $total_loans += $salary->loans;
                                        $total_rebate += $salary->rebate;
                                        $total_additions += $salary->total_additions;
                                        $total_deductions += $salary->total_deductions;
                                        $total_net += $salary->net_pay;
                                    @endphp
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td><strong>TOTALS</strong></td>
                            <td class="text-primary"> <strong>{{ $count }} <br> Full Time Employees</strong>
                            </td>
                            <td></td>
                            <td class="text-primary"><strong>KES {{ number_format($total_gross, 2) }}</strong></td>
                            <td class="text-danger"><strong>KES {{ number_format($total_nssf, 2) }}</strong></td>
                            <td class="text-danger"><strong>KES {{ number_format($total_paye, 2) }}</strong></td>
                            <td class="text-danger"><strong>KES {{ number_format($total_nhif, 2) }}</strong></td>
                            <td class="text-danger"><strong>KES {{ number_format($total_housing_levy, 2) }}</strong>
                            </td>
                            <td class="text-danger"><strong>KES {{ number_format($total_pen, 2) }}</strong></td>
                            <td class="text-success"><strong>KES {{ number_format($total_bonuses, 2) }}</strong></td>
                            <td class="text-danger"><strong>KES {{ number_format($total_fines, 2) }}</strong></td>
                            <td class="text-danger"><strong>KES {{ number_format($total_loans, 2) }}</strong></td>
                            <td class="text-success"><strong>KES {{ number_format($total_rebate, 2) }}</strong></td>
                            <td class="text-success"><strong>KES {{ number_format($total_additions, 2) }}</strong></td>
                            <td class="text-success"><strong>KES {{ number_format($total_deductions, 2) }}</strong>
                            </td>
                            <td class="bg-dark text-white"><strong>KES {{ number_format($total_net, 2) }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="container-fluid mt-5">
        <div class="card">
            <div class="card-header">
                <h5>Casual Employees</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table ">
                    <thead>
                        <tr>
                            <th scope="col">Employee ID</th>
                            <th scope="col">Full Name</th>
                            <th scope="col">Designation</th>
                            <th scope="col">Days Worked</th>
                            <th scope="col">Total Gross Pay</th>
                            <th scope="col">NSSF Contribution <span class="text-danger">(-)</span></th>
                            <th scope="col">PAYE <span class="text-danger">(-)</span></th>
                            <th scope="col">NHIF Premium <span class="text-danger">(-)</span></th>
                            <th scope="col">Housing Levy<span class="text-danger">(-)</span></th>
                            <th scope="col">Absence Penalty <span class="text-danger">(-)</span></th>
                            <th scope="col"> Bonuses <span class="text-success">(+)</span></th>
                            <th scope="col">Fines <span class="text-danger">(-)</span></th>
                            <th scope="col">Loan Repayments <span class="text-danger">(-)</span></th>
                            <th scope="col">Tax Rebate <span class="text-success">(+)</span></th>
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
                            $total_paye = 0;
                            $total_nssf = 0;
                            $total_housing_levy = 0;
                            $total_pen = 0;
                            $total_additions = 0;
                            $total_deductions = 0;
                            $total_net = 0;
                            $total_rebate = 0;
                            $total_bonuses = 0;
                            $total_fines = 0;
                            $total_loans = 0;
                        @endphp
                        @foreach ($payroll->monthlySalaries()->orderBy('basic_salary_kes', 'DESC')->get() as $salary)
                            @if (
                                $salary->employee->ActiveContractBetween(Carbon\Carbon::parse($payroll->year . '-' . $payroll->month)->firstOfMonth(),
                                        Carbon\Carbon::parse($payroll->year . '-' . $payroll->month)->lastOfMonth())->is_casual())
                                <tr class="">
                                    <td scope="row">{{ $salary->id }}</td>
                                    <td>{{ $salary->employee->user->name }}</td>
                                    <td>{{ $salary->employee->designation->title }}</td>
                                    <td>{{ $salary->employee->daysWorked($salary->payroll->year . '-' . $salary->payroll->month) }}
                                        Days</td>
                                    <td>KES {{ number_format($salary->gross_salary, 2) }} <small>(Daily Rate:
                                            KES{{ number_format($salary->daily_rate, 2) }})</small></td>
                                    <td>KES {{ number_format($salary->nssf, 2) }}</td>
                                    <td>KES {{ number_format($salary->paye, 2) }}</td>
                                    <td>KES {{ number_format($salary->nhif, 2) }}</td>
                                    <td>KES {{ number_format($salary->housing_levy, 2) }}</td>
                                    <td>KES {{ number_format($salary->attendance_penalty, 2) }}
                                        @if ($salary->employee->is_full_time)
                                            <br><small class="text-muted"> for {{ $salary->days_missed }} Days
                                                Missed</small>
                                        @endif
                                    </td>
                                    <td>KES {{ number_format($salary->bonuses, 2) }}</td>
                                    <td>KES {{ number_format($salary->fines, 2) }}</td>
                                    <td>KES {{ number_format($salary->loans, 2) }}</td>
                                    <td>KES {{ number_format($salary->rebate, 2) }}</td>
                                    <td>KES {{ number_format($salary->total_additions, 2) }}</td>
                                    <td>KES {{ number_format($salary->total_deductions, 2) }}</td>
                                    <td>
                                        <strong class="text-success">KES
                                            {{ number_format($salary->net_pay, 2) }}</strong>
                                    </td>
                                    <td class="d-flex flex-row justify-content-center">
                                        <div class="flex-col m-2">
                                            <a href="{{ route('doc.payslip', $salary->id) }}" class="btn btn-primary">
                                                <i class="material-icons material-symbols-outlined"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="View Payslip">
                                                    receipt_long
                                                </i>
                                            </a>
                                        </div>
                                    </td>
                                    @php
                                        $count++;
                                        $total_gross += $salary->gross_salary;
                                        $total_nhif += $salary->nhif;
                                        $total_paye += $salary->paye;
                                        $total_nssf += $salary->nssf;
                                        $total_housing_levy += $salary->housing_levy;
                                        $total_pen += $salary->attendance_penalty;
                                        $total_bonuses += $salary->bonuses;
                                        $total_fines += $salary->fines;
                                        $total_loans += $salary->loans;
                                        $total_rebate += $salary->rebate;
                                        $total_additions += $salary->total_additions;
                                        $total_deductions += $salary->total_deductions;
                                        $total_net += $salary->net_pay;
                                    @endphp
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td><strong>TOTALS</strong></td>
                            <td class="text-primary"> <strong>{{ $count }} <br> Full Time Employees</strong>
                            </td>
                            <td></td>
                            <td class="text-primary"><strong>KES {{ number_format($total_gross, 2) }}</strong></td>
                            <td class="text-danger"><strong>KES {{ number_format($total_nssf, 2) }}</strong></td>
                            <td class="text-danger"><strong>KES {{ number_format($total_paye, 2) }}</strong></td>
                            <td class="text-danger"><strong>KES {{ number_format($total_nhif, 2) }}</strong></td>
                            <td class="text-danger"><strong>KES {{ number_format($total_housing_levy, 2) }}</strong>
                            </td>
                            <td class="text-danger"><strong>KES {{ number_format($total_pen, 2) }}</strong></td>
                            <td class="text-success"><strong>KES {{ number_format($total_bonuses, 2) }}</strong></td>
                            <td class="text-danger"><strong>KES {{ number_format($total_fines, 2) }}</strong></td>
                            <td class="text-danger"><strong>KES {{ number_format($total_loans, 2) }}</strong></td>
                            <td class="text-success"><strong>KES {{ number_format($total_rebate, 2) }}</strong></td>
                            <td class="text-success"><strong>KES {{ number_format($total_additions, 2) }}</strong>
                            </td>
                            <td class="text-success"><strong>KES {{ number_format($total_deductions, 2) }}</strong>
                            </td>
                            <td class="bg-dark text-white"><strong>KES {{ number_format($total_net, 2) }}</strong>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5>External Employees</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table ">
                    <thead>
                        <tr>
                            <th scope="col">Employee ID</th>
                            <th scope="col">Full Name</th>
                            <th scope="col">Designation</th>
                            <th scope="col">Days Worked</th>
                            <th scope="col">Total Gross Pay</th>
                            <th scope="col">NSSF Contribution <span class="text-danger">(-)</span></th>
                            <th scope="col">PAYE <span class="text-danger">(-)</span></th>
                            <th scope="col">NHIF Premium <span class="text-danger">(-)</span></th>
                            <th scope="col">Housing Levy<span class="text-danger">(-)</span></th>
                            <th scope="col">Absence Penalty <span class="text-danger">(-)</span></th>
                            <th scope="col"> Bonuses <span class="text-success">(+)</span></th>
                            <th scope="col">Fines <span class="text-danger">(-)</span></th>
                            <th scope="col">Loan Repayment<span class="text-danger">(-)</span></th>
                            <th scope="col">Tax Rebate <span class="text-success">(+)</span></th>
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
                            $total_paye = 0;
                            $total_nssf = 0;
                            $total_housing_levy = 0;
                            $total_pen = 0;
                            $total_additions = 0;
                            $total_deductions = 0;
                            $total_net = 0;
                            $total_rebate = 0;
                            $total_bonuses = 0;
                            $total_fines = 0;
                            $total_loans = 0;
                        @endphp
                        @foreach ($payroll->monthlySalaries()->orderBy('basic_salary_kes', 'DESC')->get() as $salary)
                            @if (
                                $salary->employee->ActiveContractBetween(Carbon\Carbon::parse($payroll->year . '-' . $payroll->month)->firstOfMonth(),
                                        Carbon\Carbon::parse($payroll->year . '-' . $payroll->month)->lastOfMonth())->is_external())
                                <tr class="">
                                    <td scope="row">{{ $salary->id }}</td>
                                    <td>{{ $salary->employee->user->name }}</td>
                                    <td>{{ $salary->employee->designation->title }}</td>
                                    <td>{{ $salary->employee->daysWorked($salary->payroll->year . '-' . $salary->payroll->month) }}
                                        Days</td>
                                    <td>KES {{ number_format($salary->gross_salary, 2) }} <small>(Daily Rate:
                                            KES{{ number_format($salary->daily_rate, 2) }})</small></td>
                                    <td>KES {{ number_format($salary->nssf, 2) }}</td>
                                    <td>KES {{ number_format($salary->paye, 2) }}</td>
                                    <td>KES {{ number_format($salary->nhif, 2) }}</td>
                                    <td>KES {{ number_format($salary->housing_levy, 2) }}</td>
                                    <td>KES {{ number_format($salary->attendance_penalty, 2) }}
                                        @if (
                                            $salary->employee->isFullTimeBetween(Carbon\Carbon::parse($payroll->year . '-' . $payroll->month)->firstOfMonth(),
                                                    Carbon\Carbon::parse($payroll->year . '-' . $payroll->month)->lastOfMonth()))
                                            <br><small class="text-muted"> for {{ $salary->days_missed }} Days
                                                Missed</small>
                                        @endif
                                    </td>
                                    <td>KES {{ number_format($salary->bonuses, 2) }}</td>
                                    <td>KES {{ number_format($salary->fines, 2) }}</td>
                                    <td>KES {{ number_format($salary->loans, 2) }}</td>
                                    <td>KES {{ number_format($salary->rebate, 2) }}</td>
                                    <td>KES {{ number_format($salary->total_additions, 2) }}</td>
                                    <td>KES {{ number_format($salary->total_deductions, 2) }}</td>
                                    <td>
                                        <strong class="text-success">KES
                                            {{ number_format($salary->net_pay, 2) }}</strong>
                                    </td>
                                    <td class="d-flex flex-row justify-content-center">
                                        <div class="flex-col m-2">
                                            <a href="{{ route('doc.payslip', $salary->id) }}" class="btn btn-primary">
                                                <i class="material-icons material-symbols-outlined"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="View Payslip">
                                                    receipt_long
                                                </i>
                                            </a>
                                        </div>
                                    </td>
                                    @php
                                        $count++;
                                        $total_gross += $salary->gross_salary;
                                        $total_nhif += $salary->nhif;
                                        $total_paye += $salary->paye;
                                        $total_nssf += $salary->nssf;
                                        $total_housing_levy += $salary->housing_levy;
                                        $total_pen += $salary->attendance_penalty;
                                        $total_bonuses += $salary->bonuses;
                                        $total_fines += $salary->fines;
                                        $total_loans += $salary->loans;
                                        $total_rebate += $salary->rebate;
                                        $total_additions += $salary->total_additions;
                                        $total_deductions += $salary->total_deductions;
                                        $total_net += $salary->net_pay;
                                    @endphp
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td><strong>TOTALS</strong></td>
                            <td class="text-primary"> <strong>{{ $count }} <br> Full Time Employees</strong>
                            </td>
                            <td></td>
                            <td class="text-primary"><strong>KES {{ number_format($total_gross, 2) }}</strong></td>
                            <td class="text-danger"><strong>KES {{ number_format($total_nssf, 2) }}</strong></td>
                            <td class="text-danger"><strong>KES {{ number_format($total_paye, 2) }}</strong></td>
                            <td class="text-danger"><strong>KES {{ number_format($total_nhif, 2) }}</strong></td>
                            <td class="text-danger"><strong>KES {{ number_format($total_housing_levy, 2) }}</strong>
                            </td>
                            <td class="text-danger"><strong>KES {{ number_format($total_pen, 2) }}</strong></td>
                            <td class="text-success"><strong>KES {{ number_format($total_bonuses, 2) }}</strong></td>
                            <td class="text-danger"><strong>KES {{ number_format($total_fines, 2) }}</strong></td>
                            <td class="text-danger"><strong>KES {{ number_format($total_loans, 2) }}</strong></td>
                            <td class="text-success"><strong>KES {{ number_format($total_rebate, 2) }}</strong></td>
                            <td class="text-success"><strong>KES {{ number_format($total_additions, 2) }}</strong></td>
                            <td class="text-success"><strong>KES {{ number_format($total_deductions, 2) }}</strong>
                            </td>
                            <td class="bg-dark text-white"><strong>KES {{ number_format($total_net, 2) }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5>Intern Employees</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table ">
                    <thead>
                        <tr>
                            <th scope="col">Employee ID</th>
                            <th scope="col">Full Name</th>
                            <th scope="col">Designation</th>
                            <th scope="col">Days Worked</th>
                            <th scope="col">Total Gross Pay</th>
                            <th scope="col">NSSF Contribution <span class="text-danger">(-)</span></th>
                            <th scope="col">PAYE <span class="text-danger">(-)</span></th>
                            <th scope="col">NHIF Premium <span class="text-danger">(-)</span></th>
                            <th scope="col">Housing Levy<span class="text-danger">(-)</span></th>
                            <th scope="col">Absence Penalty <span class="text-danger">(-)</span></th>
                            <th scope="col"> Bonuses <span class="text-success">(+)</span></th>
                            <th scope="col">Fines <span class="text-danger">(-)</span></th>
                            <th scope="col">Loan Repayments <span class="text-danger">(-)</span></th>
                            <th scope="col">Tax Rebate <span class="text-success">(+)</span></th>
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
                            $total_paye = 0;
                            $total_nssf = 0;
                            $total_housing_levy = 0;
                            $total_pen = 0;
                            $total_additions = 0;
                            $total_deductions = 0;
                            $total_net = 0;
                            $total_rebate = 0;
                            $total_bonuses = 0;
                            $total_fines = 0;
                            $total_loans = 0;
                        @endphp
                        @foreach ($payroll->monthlySalaries()->orderBy('basic_salary_kes', 'DESC')->get() as $salary)
                            @if (
                                $salary->employee->ActiveContractBetween(Carbon\Carbon::parse($payroll->year . '-' . $payroll->month)->firstOfMonth(),
                                        Carbon\Carbon::parse($payroll->year . '-' . $payroll->month)->lastOfMonth())->is_intern())
                                <tr class="">
                                    <td scope="row">{{ $salary->id }}</td>
                                    <td>{{ $salary->employee->user->name }}</td>
                                    <td>{{ $salary->employee->designation->title }}</td>
                                    <td>{{ $salary->employee->daysWorked($salary->payroll->year . '-' . $salary->payroll->month) }}
                                        Days</td>
                                    <td>KES {{ number_format($salary->gross_salary, 2) }} <small>(Daily Rate:
                                            KES{{ number_format($salary->daily_rate, 2) }})</small></td>
                                    <td>KES {{ number_format($salary->nssf, 2) }}</td>
                                    <td>KES {{ number_format($salary->paye, 2) }}</td>
                                    <td>KES {{ number_format($salary->nhif, 2) }}</td>
                                    <td>KES {{ number_format($salary->housing_levy, 2) }}</td>
                                    <td>KES {{ number_format($salary->attendance_penalty, 2) }}
                                        @if ($salary->employee->is_full_time)
                                            <br><small class="text-muted"> for {{ $salary->days_missed }} Days
                                                Missed</small>
                                        @endif
                                    </td>
                                    <td>KES {{ number_format($salary->bonuses, 2) }}</td>
                                    <td>KES {{ number_format($salary->fines, 2) }}</td>
                                    <td>KES {{ number_format($salary->loans, 2) }}</td>
                                    <td>KES {{ number_format($salary->rebate, 2) }}</td>
                                    <td>KES {{ number_format($salary->total_additions, 2) }}</td>
                                    <td>KES {{ number_format($salary->total_deductions, 2) }}</td>
                                    <td>
                                        <strong class="text-success">KES
                                            {{ number_format($salary->net_pay, 2) }}</strong>
                                    </td>
                                    <td class="d-flex flex-row justify-content-center">
                                        <div class="flex-col m-2">
                                            <a href="{{ route('doc.payslip', $salary->id) }}" class="btn btn-primary">
                                                <i class="material-icons material-symbols-outlined"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="View Payslip">
                                                    receipt_long
                                                </i>
                                            </a>
                                        </div>
                                    </td>
                                    @php
                                        $count++;
                                        $total_gross += $salary->gross_salary;
                                        $total_nhif += $salary->nhif;
                                        $total_paye += $salary->paye;
                                        $total_nssf += $salary->nssf;
                                        $total_housing_levy += $salary->housing_levy;
                                        $total_pen += $salary->attendance_penalty;
                                        $total_bonuses += $salary->bonuses;
                                        $total_fines += $salary->fines;
                                        $total_loans += $salary->loans;
                                        $total_rebate += $salary->rebate;
                                        $total_additions += $salary->total_additions;
                                        $total_deductions += $salary->total_deductions;
                                        $total_net += $salary->net_pay;
                                    @endphp
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td><strong>TOTALS</strong></td>
                            <td class="text-primary"> <strong>{{ $count }} <br> Full Time Employees</strong>
                            </td>
                            <td></td>
                            <td class="text-primary"><strong>KES {{ number_format($total_gross, 2) }}</strong></td>
                            <td class="text-danger"><strong>KES {{ number_format($total_nssf, 2) }}</strong></td>
                            <td class="text-danger"><strong>KES {{ number_format($total_paye, 2) }}</strong></td>
                            <td class="text-danger"><strong>KES {{ number_format($total_nhif, 2) }}</strong></td>
                            <td class="text-danger"><strong>KES {{ number_format($total_housing_levy, 2) }}</strong>
                            </td>
                            <td class="text-danger"><strong>KES {{ number_format($total_pen, 2) }}</strong></td>
                            <td class="text-success"><strong>KES {{ number_format($total_bonuses, 2) }}</strong></td>
                            <td class="text-danger"><strong>KES {{ number_format($total_fines, 2) }}</strong></td>
                            <td class="text-danger"><strong>KES {{ number_format($total_loans, 2) }}</strong></td>
                            <td class="text-success"><strong>KES {{ number_format($total_rebate, 2) }}</strong></td>
                            <td class="text-success"><strong>KES {{ number_format($total_additions, 2) }}</strong>
                            </td>
                            <td class="text-success"><strong>KES {{ number_format($total_deductions, 2) }}</strong>
                            </td>
                            <td class="bg-dark text-white"><strong>KES {{ number_format($total_net, 2) }}</strong>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
