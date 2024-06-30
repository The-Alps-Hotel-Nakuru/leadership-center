html
Copy code
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KRA P9 Form</title>
    <style>
        body {
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
            font-size: small;
        }

        .row {
            display: flex;
            flex-wrap: nowrap;
            background-color: DodgerBlue;

        }

        .row>.col {
            background-color: #f1f1f1;
            width: 100px;
            margin: 10px;
            text-align: center;
            line-height: 75px;
            font-size: 30px;
        }


        table,
        th,
        td {
            border: 1px solid #000;
            border-collapse: collapse;
        }

        th,
        td {
            /* padding: 10px; */
            text-align: center;
        }

        th {
            background-color: #f0f0f0;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2 style="text-align: center">Kenya Revenue Authority</h2>
        <h2 style="text-align: center">Tax Deduction Card 2024</h2>
        <div class="row">
            <div class="col">
                1
            </div>
            <div class="col">
                2
            </div>
        </div>

        <div class="form-group">
            <label for="employer-pin">Employer's PIN</label>
            <input type="text" id="employer-pin" name="employer_pin">
        </div>
        <div class="form-group">
            <label for="employee-main-name">Employee's Main Name</label>
            <input type="text" id="employee-main-name" name="employee_main_name">
        </div>
        <div class="form-group">
            <label for="employee-other-names">Employee's Other Names</label>
            <input type="text" id="employee-other-names" name="employee_other_names">
        </div>
        <div class="form-group">
            <label for="employee-pin">Employee's PIN</label>
            <input type="text" id="employee-pin" name="employee_pin">
        </div>

        <!-- Table Section -->
        <table>
            <thead>
                <tr>
                    <th>Month</th>
                    <th>Basic Salary</th>
                    <th>Benefits Non-Cash</th>
                    <th>Value of Quarters</th>
                    <th>Defined Contribution Retirement Scheme</th>
                    <th>Owner Occupied Interest</th>
                    <th>Chargeable Pay</th>
                    <th>Tax Charged</th>
                    <th>Personal Relief</th>
                    <th>Insurance Relief</th>
                    <th>PAYE Tax</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>January</td>
                    <td><input type="text" name="basic_salary_jan"></td>
                    <td><input type="text" name="benefits_non_cash_jan"></td>
                    <td><input type="text" name="value_of_quarters_jan"></td>
                    <td><input type="text" name="defined_contribution_jan"></td>
                    <td><input type="text" name="owner_occupied_interest_jan"></td>
                    <td><input type="text" name="chargeable_pay_jan"></td>
                    <td><input type="text" name="tax_charged_jan"></td>
                    <td><input type="text" name="personal_relief_jan"></td>
                    <td><input type="text" name="insurance_relief_jan"></td>
                    <td><input type="text" name="paye_tax_jan"></td>
                </tr>
                <!-- Repeat for other months -->
                <!-- ... -->
                <tr>
                    <td>December</td>
                    <td><input type="text" name="basic_salary_dec"></td>
                    <td><input type="text" name="benefits_non_cash_dec"></td>
                    <td><input type="text" name="value_of_quarters_dec"></td>
                    <td><input type="text" name="defined_contribution_dec"></td>
                    <td><input type="text" name="owner_occupied_interest_dec"></td>
                    <td><input type="text" name="chargeable_pay_dec"></td>
                    <td><input type="text" name="tax_charged_dec"></td>
                    <td><input type="text" name="personal_relief_dec"></td>
                    <td><input type="text" name="insurance_relief_dec"></td>
                    <td><input type="text" name="paye_tax_dec"></td>
                </tr>
            </tbody>
        </table>

        <div class="form-group">
            <label for="total-chargeable-pay">Total Chargeable Pay (COL H)</label>
            <input type="text" id="total-chargeable-pay" name="total_chargeable_pay">
        </div>
        <div class="form-group">
            <label for="total-tax">Total Tax (COL L)</label>
            <input type="text" id="total-tax" name="total_tax">
        </div>

    </div>
</body>

</html>
