<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,height=auto, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        table {
            border: 1px solid black;
            width: 100%;
            line-height: 0.5;
            padding: 10px;
            font-size: 15px
        }
    </style>
</head>

<body>
    <table width="100%" style="border: 0">
        <tr>
            <td style="vertical-align: text-top; ">
                <div
                    style="background: transparent url({{ env('APP_URL') }}/logo.png);width: 120px;height: 120px;background-position: center; margin:auto;background-size: 120px;">
                </div>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; text-transform:uppercase">
                <h1><strong>The Alps Hotel Nakuru</strong></h1>
            </td>
        </tr>
    </table>
    <table style="border:0">
        <thead>
            <h1 style="text-transform:uppercase; text-align:center">Payslip for
                {{ Carbon\Carbon::parse($salary->payroll->year . '-' . $salary->payroll->month)->format('F, Y') }}</h1>
        </thead>
    </table>
    @php
        $active_contract = $salary->employee->ActiveContractDuring(Carbon\Carbon::createFromFormat('Y-m', $salary->payroll->year . '-' . $salary->payroll->month)->firstOfMonth(), Carbon\Carbon::createFromFormat('Y-m', $salary->payroll->year . '-' . $salary->payroll->month)->lastOfMonth());
    @endphp
    <table>
        <thead>
            <small>Name: </small><strong>{{ $salary->employee->user->name }}</strong><br><br>
            <small>Designation: </small><strong>{{ $salary->employee->designation->title }}</strong><br><br>
            <small>Employee No.: </small><strong>{{ $salary->employee->id }}</strong><br><br>
            @if ($active_contract->is_full_time())
                <small>KRA PIN: </small><strong
                    style="text-transform: uppercase">{{ $salary->employee->kra_pin }}</strong><br><br>
                <small>NSSF No.: </small><strong>{{ $salary->employee->nssf }}</strong><br><br>
                <small>NHIF No.: </small><strong>{{ $salary->employee->nhif }}</strong><br><br>
            @endif

        </thead>
    </table>
    <table style="margin-bottom: 20px; margin-top:20px; background-color:#1575bb">
        <thead style="width: 100%; color:#fff; ">
            <th colspan="2" style="text-align: left; text-decoration: underline;">Description</th>
            <th colspan="1" style="text-align: right; text-decoration: underline;">Amount</th>
        </thead>

    </table>
    <table>
        <thead style="width: 100%;">
            <td colspan="2" style="text-align: left">Basic Salary</td>
            <td colspan="1" style="text-align: right"><small>KES
                </small>{{ number_format($salary->basic_salary_kes, 2) }}</td>
        </thead>
        <br>
        <thead style="width: 100%;">
            <td colspan="2" style="text-align: left">House Allowance</td>
            <td colspan="1" style="text-align: right"><small>KES
                </small>{{ number_format($salary->house_allowance_kes, 2) }}</td>
        </thead>
    </table>
    <table>
        <thead style="width: 100%;">
            <th colspan="2" style="text-align: left">Gross Salary</th>
            <th colspan="1" style="text-align: right"><small>KES
                </small>{{ number_format($salary->gross_salary, 2) }}</th>
        </thead>
    </table>
    <table>
        <thead style="width: 100%;">
            <td colspan="2" style="text-align: left">NSSF Contribution</td>
            <td colspan="1" style="text-align: right; text-underline:1px solid black">
                (<small>KES </small>{{ number_format($salary->nssf, 2) }})</td>
        </thead>
    </table>
    <table>
        <thead style="width: 100%;">
            <th colspan="2" style="text-align: left">Taxable Income</th>
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
            <td colspan="1" style="text-align: right"><small>KES </small>{{ number_format($salary->tax_relief, 2) }}
            </td>
        </thead>
        <br>
        <thead style="width: 100%;">
            <td colspan="2" style="text-align: left">Insurance Relief</td>
            <td colspan="1" style="text-align: right"><small>KES
                </small>{{ number_format($salary->general_relief, 2) }}
            </td>
        </thead>
    </table>
    <table>
        <thead style="width: 100%;">
            <th colspan="2" style="text-align: left">Total PAYE</th>
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
        <thead style="width: 100%;">
            <td colspan="2" style="text-align: left">NHIF Premium</td>
            <td colspan="1" style="text-align: right">(<small>KES </small>{{ number_format($salary->nhif, 2) }})
            </td>
        </thead>
        <br>
        <thead style="width: 100%;">
            <td colspan="2" style="text-align: left">Housing Levy</td>
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
                                <li style="font-size: 8">{{ $fine->reason }}: <br><br><strong>KES
                                        {{ number_format($fine->amount_kes, 2) }}</strong>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @endif
            </td>
            <td colspan="1" style="text-align: right">({{ number_format($salary->fines, 2) }})</td>
        </thead>
        <br>
        <thead style="width: 100%;">
            <td colspan="2" style="text-align: left">Attendance Penalty</td>
            <td colspan="1" style="text-align: right">(<small>KES
                </small>{{ number_format($salary->attendance_penalty, 2) }})</td>
        </thead>
        <br>
        <thead style="width: 100%;">
            <td colspan="2" style="text-align: left">
                Staff Welfare Contribution
                @if (count($salary->employee->welfareContributions) > 0)
                    <br>
                    <ul>
                        @foreach ($salary->employee->welfareContributions as $welfare_contribution)
                            @if ($welfare_contribution->year == $salary->payroll->year && $welfare_contribution->month == $salary->payroll->month)
                                <li style="font-size: 8">{{ $welfare_contribution->reason }} <br><br><strong>KES
                                        {{ number_format($welfare_contribution->amount_kes, 2) }}</strong>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @endif
            </td>
            <td colspan="1" style="text-align: right">(<small>KES
                </small>{{ number_format($salary->welfare_contributions, 2) }})</td>
        </thead>
        <br>

    </table>
    <table>
        <thead style="width: 100%;">
            <th colspan="2" style="text-align: left">Total Deductions <small style="font-size: 10px">(incl. NSSF
                    Contribution)</small></th>
            <th colspan="1" style="text-align: right"><small>KES
                </small>({{ number_format($salary->total_deductions, 2) }})</th>
        </thead>
    </table>
    <table>
        <thead style="width: 100%;">
            <td colspan="2" style="text-align: left">Total Bonuses
                @if (count($salary->employee->bonuses) > 0)
                    <br>
                    <ul>
                        @foreach ($salary->employee->bonuses as $bonus)
                            @if ($bonus->year == $salary->payroll->year && $bonus->month == $salary->payroll->month)
                                <li style="font-size: 8">{{ $bonus->reason }} <br><br><strong>KES
                                        {{ number_format($bonus->amount_kes, 2) }}</strong>
                                </li>
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
            <td colspan="2" style="text-align: left">Tax Rebates</td>
            <td colspan="1" style="text-align: right"><small>KES
                </small>{{ number_format($salary->rebate, 2) }}</td>
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
    <table>
        <thead style="width: 100%;">
            <th colspan="2" style="text-align: left; color:#1575bb">Net Pay</th>
            <th colspan="1" style="text-align: right; color:black; font-size:24px"><small>KES
                </small>{{ number_format($salary->net_pay, 2) }}</th>
        </thead>
    </table>

</body>

</html>
