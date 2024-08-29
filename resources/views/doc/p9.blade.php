<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $p9Data['employee_pin'] }} - P9A Form - {{ $p9Data['year'] }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: "Lexend", sans-serif;
            font-size: 8px;
            margin: 0;
            /* padding: 15px; */
        }

        .container {
            width: 100%;
            margin: 0 auto;
            /* padding: 10px; */
            /* border: 0.5px solid #000; */
        }

        .header,
        .footer {
            text-align: center;
            margin-bottom: 15px;
        }

        .header h1 {
            font-size: 14px;
            margin-bottom: 5px;
        }

        .header h2 {
            font-size: 12px;
            margin: 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .table th,
        .table td {
            border: 0.5px solid #1f1f1f;
            padding: 5px;
            text-align: center;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table th {
            padding: 5px;
            text-align: left;
            font-weight: 300;
        }

        .table th {
            background-color: #f0f0f0;
        }

        .info {
            margin-bottom: 15px;
        }

        .info p {
            margin: 5px 0;
        }

        .section-title {
            font-weight: bold;
            margin-top: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>P9A Form - {{ $p9Data['year'] }}</h1>
            <h2>Kenya Revenue Authority</h2>
            <p>DOMESTIC TAXES DEPARTMENT</p>
            <p>INCOME TAX DEDUCTION CARD YEAR {{ $p9Data['year'] }}</p>
        </div>

        <table class="info-table">
            <thead>
                <tr>
                    <th>
                        <p><strong>Employer's Name:</strong> {{ env('COMPANY_NAME') }}</p>

                        <p><strong>Employer's P.I.N:</strong> {{ env('COMPANY_PIN', 'NOT SET') }}</p>
                    </th>
                    <th>
                        <p><strong>Employee's Main Name:</strong> {{ $p9Data['employee_main_name'] }}</p>

                        <p><strong>Employee's Other Names:</strong> {{ $p9Data['employee_other_names'] }}</p>
                    </th>
                    <th>
                        <p><strong>Employee's P.I.N:</strong> {{ $p9Data['employee_pin'] }}</p>
                    </th>
                </tr>
            </thead>
        </table>

        {{-- <div class="info">
            <p><strong>Employer's Name:</strong> {{ env('COMPANY_NAME') }}</p>
            <p><strong>Employer's P.I.N:</strong> {{ env('COMPANY_PIN', 'NOT SET') }}</p>
            <p><strong>Employee's Main Name:</strong> {{ $p9Data['employee_main_name'] }}</p>
            <p><strong>Employee's Other Names:</strong> {{ $p9Data['employee_other_names'] }}</p>
            <p><strong>Employee's P.I.N:</strong> {{ $p9Data['employee_pin'] }}</p>
        </div> --}}

        <table class="table">
            <thead>
                <tr>
                    <th>MONTH</th>
                    <th>BASIC SALARY</th>
                    <th>BENEFITS NONCASH</th>
                    <th>VALUE OF QUARTERS</th>
                    <th>TOTAL GROSS PAY</th>
                    <th>DEFINED CONTRIBUTION RETIREMENT SCHEME</th>
                    <th>OWNER-OCCUPIED INTEREST / DISABILITY TAX EXEMPT</th>
                    <th>RETIREMENT CONTR. & OWNER OCCUPIED INTEREST</th>
                    <th>CHARGEABLE PAY KSHS.</th>
                    <th>TAX ON H KSHS.</th>
                    <th>RELIEF KSHS.</th>
                    <th>P.A.Y.E TAX (J-K) K KSHS.</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($p9Data['monthly_data'] as $data)
                    @if ($data['earnings'] > 0)
                        <tr>
                            <td>{{ $data['month'] }}</td>
                            <td>{{ number_format($data['earnings'], 2) }}</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>{{ number_format($data['earnings'], 2) }}</td>
                            <td>{{ number_format($data['nssf'], 2) }}</td>
                            <td>{{ number_format(0, 2) }}</td>
                            <td>{{ number_format($data['nssf'], 2) }}</td>
                            <td>{{ number_format($data['earnings'] - $data['nssf'], 2) }}</td>
                            <td>{{ number_format($data['incomeTax'], 2) }}</td>
                            <td>{{ number_format($data['personalRelief'] + $data['insuranceRelief'], 2) }}</td>
                            <td>{{ number_format($data['paye'], 2) }}</td>
                        </tr>
                    @endif
                @endforeach

                <tr style="background-color: #f0f0f0">
                    <td><strong>TOTALS</strong></td>
                    <td><strong>{{ number_format($p9Data['total_earnings'], 2) }}</strong></td>
                    <td><strong>0.00</strong></td>
                    <td><strong>0.00</strong></td>
                    <td><strong>{{ number_format($p9Data['total_earnings'], 2) }}</strong></td>
                    <td><strong>{{ number_format($p9Data['total_nssf'], 2) }}</strong></td>
                    <td><strong>{{ number_format(0, 2) }}</strong></td>
                    <td><strong>{{ number_format($p9Data['total_nssf'], 2) }}</strong></td>
                    <td><strong>{{ number_format($p9Data['total_earnings'] - $p9Data['total_nssf'], 2) }}</strong></td>
                    <td><strong>{{ number_format($p9Data['total_income_tax'], 2) }}</strong></td>
                    <td><strong>
                            {{ number_format($p9Data['total_personal_relief'] + $p9Data['total_insurance_relief'], 2) }}</strong>
                    </td>
                    <td><strong>{{ number_format($p9Data['total_paye'], 2) }}</strong></td>
                </tr>
                <!-- Additional rows as necessary -->
            </tbody>
        </table>

        <p style="font-size: 12px"><strong>Total Chargeable Pay (Col. H) KSHS.:</strong>
            {{ number_format($p9Data['total_earnings'] - $p9Data['total_nssf'], 2) }}</p>
        <p style="font-size: 12px"><strong>Total Tax Pay (Col. L) KSHS.:</strong>
            {{ number_format($p9Data['total_paye'], 2) }}</p>

        <div class="footer">
            <p>Important: Use P9A for all liable employees and where director/employee receives benefits in addition to
                cash emoluments.</p>
        </div>
    </div>
</body>

</html>
