<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        /* body{
        } */
        table {
            border: 1px solid black;
            width: 100%;
            line-height: 0.5;
            padding: 10px;
        }
    </style>
</head>

<body>
    <table style="background-color:#1575bb; color:#fff">
        <thead>
            <strong style="text-align: right">The Alps Hotel Nakuru</strong>
            <h2 style="color: #8cf040">Payslip - {{ Carbon\Carbon::parse($salary->payroll->month)->format('F') }}
                {{ Carbon\Carbon::parse($salary->payroll->year)->format('Y') }}</h2>
        </thead>
    </table>
    <table>
        <thead>
            <small>Name: </small><strong>{{ $salary->employee->user->name }}</strong><br><br>
            <small>Designation: </small><strong>{{ $salary->employee->designation->title }}</strong><br><br>
            <small>Employee No.: </small><strong>{{ $salary->employee->id }}</strong><br><br>
            @if ($salary->employee->is_full_time)
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
            <td colspan="2" style="text-align: left">Amounts Already Paid (loans, OT, etc.)</td>
            <td colspan="1" style="text-align: right">(<small>KES </small>{{ number_format(0, 2) }})</td>
        </thead>
        <br>
        <thead style="width: 100%;">
            <td colspan="2" style="text-align: left">Attendance Penalty</td>
            <td colspan="1" style="text-align: right">(<small>KES
                </small>{{ number_format($salary->attendance_penalty, 2) }})</td>
        </thead>
        <br>

    </table>
    <table>
        <thead style="width: 100%;">
            <th colspan="2" style="text-align: left">Total Deductions</th>
            <th colspan="1" style="text-align: right"><small>KES
                </small>{{ number_format($salary->total_deductions, 2) }}</th>
        </thead>
    </table>
    <table>
        <thead style="width: 100%;">
            <td colspan="2" style="text-align: left">Tax Relief</td>
            <td colspan="1" style="text-align: right"><small>KES </small>{{ number_format($salary->tax_relief, 2) }}
            </td>
        </thead>
        <br>
        <thead style="width: 100%;">
            <td colspan="2" style="text-align: left">General Relief (Insurance, etc.)</td>
            <td colspan="1" style="text-align: right"><small>KES
                </small>{{ number_format($salary->general_relief, 2) }}</td>
        </thead>
        <br>
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
