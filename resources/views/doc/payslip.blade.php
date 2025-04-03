<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,height=auto, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payslip for {{ $salary->employee->user->name }} - {{ $salary->month_string }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: "Lexend", sans-serif;
            font-size: 13px;
        }

        table {
            border: 1px solid black;
            width: 100%;
            line-height: 0.5;
            padding: 10px;
            font-size: 15px;
        }
    </style>
</head>

<body>
    <table width="100%" style="border: 0">
        <tr>
            <td style="vertical-align: text-top; ">
                <div
                    style="background: transparent url({{ env('APP_URL') }}/company_logo.png);width: 120px;height: 120px;background-position: center; margin:auto;background-size: 120px;">
                </div>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; text-transform:uppercase">
                <h2><strong>{{ env('COMPANY_NAME') }}</strong></h2>
            </td>
        </tr>
    </table>
    <table style="border:0">
        <thead>
            <h2 style="text-transform:uppercase; text-align:center">Payslip for
                {{ Carbon\Carbon::parse($salary->payroll->year . '-' . $salary->payroll->month)->format('F, Y') }}
            </h2>
        </thead>
    </table>
    @php
    $active_contracts = $salary->employee->ActiveContractsDuring(
    $salary->payroll->year . '-' . $salary->payroll->month,
    );
    $active_contract = $salary->employee->ActiveContractDuring(
    Carbon\Carbon::createFromFormat(
    'Y-m',
    $salary->payroll->year . '-' . $salary->payroll->month,
    )->firstOfMonth(),
    Carbon\Carbon::createFromFormat(
    'Y-m',
    $salary->payroll->year . '-' . $salary->payroll->month,
    )->lastOfMonth(),
    );
    @endphp
    <table>
        <thead>
            <small>Name: </small><strong>{{ $salary->employee->user->name }}</strong><br><br>
            <small>Designation: </small><strong>{{ $salary->employee->designation->title }}</strong><br><br>
            <small>Employee No.: </small><strong>{{ $salary->employee->id }}</strong><br><br>
            @if ($salary->employee->ActiveContractDuring($salary->getMonth()->format('Y-m'))->is_full_time())
            <small>KRA PIN: </small><strong
                style="text-transform: uppercase">{{ $salary->employee->kra_pin }}</strong><br><br>
            <small>NSSF No.: </small><strong>{{ $salary->employee->nssf }}</strong><br><br>
            <small>NHIF No.: </small><strong>{{ $salary->employee->nhif }}</strong><br><br>
            @endif

        </thead>
    </table>
    <br>
    <table>
        <thead style="width: 100%">
            @if ($salary->employee->designation->is_penalizable)
            <small>Days Worked: </small>
            <strong>{{ $salary->days_worked }} days</strong>
            <br><br>
            <small>Days On Leave: </small><strong>{{ $salary->leave_days }} days</strong><br><br>
            <small>Days Absent/Off: </small><strong>{{ $salary->days_missed }} days</strong><br><br>
            <small>Off Days Earned: </small><strong>{{ $salary->earned_off_days }} days</strong><br><br><br>
            @endif
            <small style="text-decoration: underline">Contract(s) Value: </small><br>
            <ul>
                @foreach ($salary->contracts() as $contract)
                <li style="font-size: 11px"> Cont. #{{ $contract->id }}
                    Value: {{ $contract->is_net ? 'NET SALARY of ' : 'GROSS SALARY of ' }}KES
                    <strong>{{ number_format($contract->salary_kes) }}
                        {{ $contract->is_casual() ? 'per day' : 'per month' }}</strong>
                    <br><br>
                    {{ $contract->netDaysWorked($salary->payroll->year . '-' . $salary->payroll->month) }}
                    days worked
                </li>
                @endforeach
            </ul>
            <br>

        </thead>
    </table>
    <table style="margin-bottom: 20px; margin-top:20px; background-color:#f0f0f0">
        <thead style="width: 100%; ">
            <th colspan="2" style="text-align: left; text-decoration: underline;">Description</th>
            <th colspan="1" style="text-align: right; text-decoration: underline;">Amount</th>
        </thead>

    </table>

    <table>
        <thead style="width: 100%;">
            <th colspan="2" style="text-align: left">Gross Salary Earned</th>
            <th colspan="1" style="text-align: right">
                <small>KES</small>
                {{ number_format($salary->gross_salary, 2) }}
            </th>
        </thead>
    </table>
    <br>
    <table>
        <thead style="width: 100%;">
            <td colspan="2" style="text-align: left">NSSF Contribution <span style="font-size: 11px">( 6% of
                    Gross)</span></td>
            <td colspan="1" style="text-align: right; text-underline:1px solid black">
                (<small>KES </small>{{ number_format($salary->nssf, 2) }})</td>
        </thead>
    </table>
    <table>
        <thead style="width: 100%;">
            <th colspan="2" style="text-align: left">Taxable Income <br><br>
                @if (now()->isBefore('2025-01-01'))
                <small style="font-size: 11px">KES
                    {{ number_format($salary->gross_salary, 2) }} - KES {{ number_format($salary->nssf, 2) }}</small>
                @else
                <small style="font-size: 11px; width: 50%;">KES
                    {{ number_format($salary->gross_salary, 2) }} - KES {{ number_format($salary->nssf, 2) }}<br><br> - KES {{ number_format($salary->shif) }} - KES {{ number_format($salary->housing_levy) }}</small>

                @endif
            </th>
            <th colspan="1" style="text-align: right"><small>KES
                </small>{{ number_format($salary->taxable_income, 2) }}</th>
        </thead>
    </table>

    <table>
        <thead style="width: 100%;">
            <td colspan="2" style="text-align: left">Income Tax</td>
            <td colspan="1" style="text-align: right">(<small>KES
                </small>{{ number_format($salary->income_tax, 2) }})
            </td>
        </thead>
        <br>
        <thead style="width: 100%;">
            <td colspan="2" style="text-align: left">Tax Relief</td>
            <td colspan="1" style="text-align: right"><small>KES
                </small>{{ number_format($salary->tax_relief, 2) }}
            </td>
        </thead>
        <br>
        <thead style="width: 100%;">
            <td colspan="2" style="text-align: left">General Relief <br><br>

            </td>
            <td colspan="1" style="text-align: right"><small>KES
                </small>{{ number_format($salary->general_relief, 2) }}
            </td>
        </thead>
    </table>
    <table>
        <thead style="width: 100%;">
            <th colspan="2" style="text-align: left">Total PAYE </th>
            <th colspan="1" style="text-align: right"><small>KES
                </small>({{ number_format($salary->paye, 2) }})</th>
        </thead>
    </table>
    <table>
        <thead style="width: 100%;">
            <td colspan="2" style="text-align: left">PAYE</td>
            <td colspan="1" style="text-align: right">(<small>KES </small>{{ number_format($salary->paye, 2) }})
            </td>
        </thead>
        <br>
        @if ($salary->nhif)
        <thead style="width: 100%;">
            <td colspan="2" style="text-align: left">NHIF Premium</td>
            <td colspan="1" style="text-align: right">(<small>KES </small>{{ number_format($salary->nhif, 2) }})
            </td>
        </thead>
        <br>
        @endif
        @if ($salary->shif)
        <thead style="width: 100%;">
            <td colspan="2" style="text-align: left">SHA Premium <br><br><small style="font-size: 11px">(2.75% of Gross)</small></td>
            <td colspan="1" style="text-align: right">(<small>KES </small>{{ number_format($salary->shif, 2) }})
            </td>
        </thead>
        <br>
        @endif

        <thead style="width: 100%;">
            <td colspan="2" style="text-align: left">Affordable Housing Levy</td>
            <td colspan="1" style="text-align: right">({{ number_format($salary->housing_levy, 2) }})</td>
        </thead>
        <br>
        <thead style="width: 100%;">
            <td colspan="2" style="text-align: left">
                Advances
                @if (count($salary->employee->advances) > 0)
                <br>
                <ul>
                    @foreach ($salary->employee->advances as $advance)
                    @if ($advance->year == $salary->payroll->year && $advance->month == $salary->payroll->month)
                    <li style="font-size: 8px">{{ $advance->reason }}: <br><br><strong>KES
                            {{ number_format($advance->amount_kes, 2) }}</strong>
                    </li>
                    <br>
                    @endif
                    @endforeach
                </ul>
                @endif
            </td>
            <td colspan="1" style="text-align: right">({{ number_format($salary->advances, 2) }})</td>
        </thead>
        <br>
        <thead style="width: 100%;">
            <td colspan="2" style="text-align: left">
                Fines
                @if (count($salary->employee->fines) > 0)
                <br>
                <ul>
                    @foreach ($salary->employee->fines as $fine)
                    @if ($fine->year == $salary->payroll->year && $fine->month == $salary->payroll->month)
                    <li style="font-size: 8;">{{ $fine->reason }}: <br><br><strong>KES
                            {{ number_format($fine->amount_kes, 2) }}</strong>
                    </li>
                    <br>
                    @endif
                    @endforeach
                </ul>
                @endif
            </td>
            <td colspan="1" style="text-align: right">({{ number_format($salary->fines, 2) }})</td>
        </thead>
        <br>
        <thead style="width: 100%;">
            <td colspan="2" style="text-align: left">
                Loan Repayments
                @if (count($salary->employee->loans) > 0)
                <br>
                <ul>
                    @foreach ($salary->employee->loans as $loan)
                    @if ($loan->year == $salary->payroll->year && $loan->month == $salary->payroll->month)
                    <li style="font-size: 8;">{{ $loan->reason }}: <br><br><strong>KES
                            {{ number_format($loan->amount, 2) }}</strong>
                    </li>
                    <br>
                    @endif
                    @endforeach
                </ul>
                @endif
            </td>
            <td colspan="1" style="text-align: right">({{ number_format($salary->loans, 2) }})</td>
        </thead>
        <br>

        @if ($salary->employee->welfare_contributions != 0)
        <thead style="width: 100%;">
            <td colspan="2" style="text-align: left">
                Staff Welfare Contribution
                @if (count($salary->employee->welfareContributions) > 0)
                <br>
                <ul>
                    @foreach ($salary->employee->welfareContributions as $welfare_contribution)
                    @if ($welfare_contribution->year == $salary->payroll->year && $welfare_contribution->month == $salary->payroll->month)
                    <li style="font-size: 8;">{{ $welfare_contribution->reason }} <br><br><strong>KES
                            {{ number_format($welfare_contribution->amount_kes, 2) }}</strong>
                    </li>
                    <br>
                    @endif
                    @endforeach
                </ul>
                @endif
            </td>
            <td colspan="1" style="text-align: right">(<small>KES
                </small>{{ number_format($salary->welfare_contributions, 2) }})</td>
        </thead>
        <br>
        @endif

    </table>
    <table>
        <thead style="width: 100%;">
            <th colspan="2" style="text-align: left">Total Deductions <small style="font-size: 10px">(incl. NSSF
                    Contribution)</small><br><br>
                <small style="font-size: 10px">
                    KES {{ number_format($salary->total_deductions - $salary->nssf, 2) }}+ KES
                    {{ number_format($salary->nssf, 2) }}</small>
            </th>
            <th colspan="1" style="text-align: right"><small>KES
                </small>({{ number_format($salary->total_deductions, 2) }})</th>
        </thead>
    </table>
    <table>
        <br>
        <thead style="width: 100%;">
            <td colspan="2" style="text-align: left">Total Bonuses
                @if (count($salary->employee->bonuses) > 0)
                <br>
                <ul>
                    @foreach ($salary->employee->bonuses as $bonus)
                    @if ($bonus->year == $salary->payroll->year && $bonus->month == $salary->payroll->month)
                    <li style="font-size: 8;">{{ $bonus->reason }} <br><br><strong>KES
                            {{ number_format($bonus->amount_kes, 2) }}</strong>
                    </li>
                    <br>
                    @endif
                    @endforeach
                </ul>
                @endif
            </td>
            <td colspan="1" style="text-align: right"><small>KES
                </small>{{ number_format($salary->bonuses, 2) }}</td>
        </thead>
        <br>
        <thead style="width: 100%;">
            <td colspan="2" style="text-align: left">Extra Hours <br> <br><small style="font-size: 11px">
                    (Overtimes, Double Shifts & Holidays)</small></td>
            <td colspan="1" style="text-align: right">{{ number_format($salary->overtimes, 2) }}</td>
        </thead>
    </table>
    <table>
        <thead style="width: 100%;">
            <th colspan="2" style="text-align: left">Total Additions</th>
            <th colspan="1" style="text-align: right"><small>KES
                </small>{{ number_format($salary->total_additions, 2) }}</th>
        </thead>
    </table>
    <h3 style="text-align: center">Summary</h3>
    <table>
        <thead style="width: 100%;">
            <td colspan="2" style="text-align: left">Gross Pay</td>
            <td colspan="1" style="text-align: right"><small>KES
                </small>{{ number_format($salary->gross_salary, 2) }}</td>
        </thead>
        <br>
        <thead style="width: 100%;">
            <td colspan="2" style="text-align: left">Total Additions</td>
            <td colspan="1" style="text-align: right"><small>KES
                </small>{{ number_format($salary->total_additions, 2) }}</td>
        </thead>
        <br>
        <thead style="width: 100%;">
            <td colspan="2" style="text-align: left">Total Deductions</td>
            <td colspan="1" style="text-align: right">(<small>KES
                </small>{{ number_format($salary->total_deductions, 2) }})</td>
        </thead>
        <br>
    </table>
    <table style="background-color:#f0f0f0">
        <thead style="width: 100%;">
            <th colspan="2" style="text-align: left; color:green">Net Pay</th>
            <th colspan="1" style="text-align: right;  font-size:22px"><small>KES
                </small>{{ number_format($salary->net_pay, 2) }}</th>
        </thead>
    </table>

    <div style="text-align: center; margin-top: 80px;">
        <img src="{{ env('APP_URL') }}/logo.png" alt="Force HRM Logo" style="width: 70px; height: auto;">
        <p style="font-size: 12px; color: #555;">Generated by <br><br> <span style="font-size: 16px; color: #242464;">Force HRM</span></p>
    </div>

</body>

</html>
