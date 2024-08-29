<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contract: {{ $contract->employee->user->name }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Lexend:wght@100;200;300;400;500;600;700;800;900&display=swap">
    <style>
        body {
            font-family: "Lexend", sans-serif;
            font-size: 12px;
            /* margin-top: 99px; */
            display: flex;
            justify-content: center;
        }

        .logo-container {
            width: 50px;
            height: 50px;
            background-image: url("/company_logo.png");
            /* background-repeat: no-repeat; */
            /* background-position: center; */
            /* margin-top: 20px; */
        }

        body>p {
            margin: 20px
        }

        ul {
            list-style-type: dot;
        }

        ul>li {
            margin-bottom: 10px
        }

        ol>li {
            margin-bottom: 15px
        }

        table {
            width: 50%
        }

        tr,
        th,
        td {
            border: 1px solid black;
            padding: 3px;
            margin: 3px;
        }
    </style>
</head>

<body>
    <div class="logo-container"></div>
    <p>
        <span>CONT/1/1/2024/05 EFS/1/{{ $contract->id }}</span>
    </p>
    <p style="text-align: right">
        <span>{{ Carbon\Carbon::parse($contract->start_date)->format('jS F, Y') }}</span>
    </p>
    <p>
        <strong>{{ $contract->employee->gender == 'male' ? 'Mr.' : ($contract->employee->marital_status == 'married' ? 'Mrs.' : 'Ms.') }}
            &ThickSpace;
            {{ $contract->employee->user->name }}</strong>
    </p>
    <p>
        <strong style="text-decoration: underline; text-transform:uppercase">Offer of Employment</strong>
    </p>
    <p>
        We are pleased to offer you the position
        of<strong>{{ ' ' . $contract->employee->designation->title . ' ' }}</strong>at
        <strong>{{ env('COMPANY_NAME') }}</strong>, commencing on
        <strong>{{ Carbon\Carbon::parse($contract->start_date)->format('jS F, Y') }}</strong>. This offer is made under
        the following terms and conditions, in compliance with the Kenyan Employment Act, 2007.
    </p>

    <p>
    <ol>
        <li><strong>Reporting</strong>
            <p>
                You are required to report to work on
                {{ Carbon\Carbon::parse($contract->start_date)->format('jS F, Y') }} at {{ $contract->reporting_time }}.
                You will report directly to the Head of the {{ $contract->designation->department->title }} Department,
                your immediate supervisor.
            </p>
        </li>
        <li><strong>Duties and Responsibilities</strong>
            <p>
                Your responsibilities include, but are not limited to:
            <ul>
                @foreach ($contract->employee->designation->responsibilities as $responsibility)
                    <li>{{ $responsibility->responsibility }}</li>
                @endforeach
            </ul>
            </p>
        </li>
        <li><strong>Duration</strong>
            <p>
                This contract is for a period of <strong> {{ $contract->duration }}</strong>, commencing on
                <u>{{ Carbon\Carbon::parse($contract->start_date)->format('jS F, Y') }}</u> and ending on
                <u>{{ Carbon\Carbon::parse($contract->end_date)->format('jS F, Y') }}</u>. The Employment Act, Section
                10(3)(c), mandates that the duration of employment must be specified in the contract.
            </p>
        </li>
        <li><strong>Renewal of Contract</strong>
            <p>
                The renewal of this contract is subject to mutual agreement and will be reviewed three months before the
                expiry date. In accordance with Section 10(3)(c) of the Employment Act, any renewal will be provided in
                writing.
            </p>
        </li>
        <li><strong>Place of Work</strong>
            <p>
                Your primary place of work will be at {{ env('COMPANY_LOCATION') }}. However, you may be required to
                work at other locations as necessitated by the company's operations.
            </p>
        </li>
        <li><strong>Remuneration</strong>
            <p>
                Your remuneration will be a gross salary of <strong>KES
                    {{ number_format($contract->salary_kes) }} {{ $contract->employment_type->rate_type }}</strong>
                , which will be paid on the last working day
                of each month via bank transfer to the account details provided by you. This gross salary is inclusive
                of all allowances, including house allowance, and is subject to statutory deductions as required by law.
            </p>
            <p>
                In accordance with Section 17 of the Employment Act, wages must be paid promptly and regularly, ensuring
                that your remuneration is processed and deposited in a timely manner.
            </p>
        </li>

        <li><strong>Medical Cover</strong>
            <p>
                You will be entitled to medical cover under the company's group medical scheme, as per the provisions in
                the Employment Act, Section 34, which requires employers to provide adequate medical attention to
                employees.
            </p>
        </li>
        <li><strong>Pension Scheme</strong>
            <p>
                You will be enrolled in the company's pension scheme, where both you and the company will contribute a
                specified percentage of your basic salary. This complies with Section 25 of the Employment Act regarding
                the provision of retirement benefits.
            </p>
        </li>
        <li><strong>Leave Entitlement and Off Days</strong>
            <p>
                In accordance with Section 28 of the Employment Act, you are entitled to 21 working days of annual leave
                with full pay after every twelve consecutive months of service. This leave is exclusive of public
                holidays and any other days that the company may declare as holidays.
            </p>
            <p>
                Additionally, you are entitled to statutory leaves as follows:
            <ul>
                <li><strong>Maternity Leave:</strong> Female employees are entitled to three months (90 days) of
                    maternity leave with full pay. This leave can be extended for additional periods in case of medical
                    complications as certified by a medical practitioner.</li>
                <li><strong>Paternity Leave:</strong> Male employees are entitled to two weeks (14 days) of paternity
                    leave with full pay, to be taken within the period surrounding the birth of a child.</li>
                <li><strong>Sick Leave:</strong> Employees are entitled to sick leave as stipulated under the Employment
                    Act. This includes a maximum of 30 days of sick leave with full pay and an additional 15 days with
                    half pay, provided a medical certificate is furnished.</li>
                <li><strong>Compassionate Leave:</strong> Employees may be granted compassionate leave for bereavement
                    or other serious personal matters. This leave may be granted at the discretion of the company and
                    may be deducted from the employee’s annual leave entitlement.</li>
            </ul>
            </p>
            <p>
                In addition to the statutory leaves, the company policy entitles you to one weekly off day. This off day
                is in line with company policy and the requirement for adequate rest, contributing to your overall
                well-being and productivity.
            </p>
            <p>
                The company reserves the right to schedule your off day, taking into consideration the operational needs
                of the business. Any additional time off required beyond the specified leaves and off days may be
                granted at the discretion of the management and may be deducted from your leave entitlement or treated
                as unpaid leave.
            </p>
        </li>

        <li><strong>Code of Conduct</strong>
            <p>
                You are expected to adhere to the company's code of conduct, which includes but is not limited to:
            <ol type="a">
                <li>Maintaining a high level of professionalism at all times.</li>
                <li>Adhering to company policies and procedures.</li>
                <li>Maintaining confidentiality of company information.</li>
            </ol>
            Any breach of the code of conduct may result in disciplinary action, including termination of employment.
            </p>
        </li>
        <li><strong>Confidentiality</strong>
            <p>
                You are required to keep all company information confidential both during and after your employment.
                This clause applies in accordance with Section 44(4)(g) of the Employment Act, which regards
                unauthorized disclosure of information as a gross misconduct.
            </p>
            <ol type="a">
                <li>Confidential information includes, but is not limited to, trade secrets, customer lists, and
                    proprietary data.</li>
                <li>Any breach of this confidentiality clause may lead to legal action and termination of employment.
                </li>
            </ol>
        </li>
        <li><strong>Termination</strong>
            <p>
                Either party may terminate this contract by giving one month's written notice or payment in lieu of
                notice. Termination may also occur under circumstances outlined in Section 44 of the Employment Act,
                such as gross misconduct or incapacity.
            </p>
        </li>
        <li><strong>Obligation</strong>
            <p>
                You are obliged to perform your duties to the best of your ability and comply with the company's
                policies and procedures at all times. For foreign employees, a valid work permit is required in
                accordance with the Kenyan Immigration Act.
            </p>
        </li>
        <li><strong>Acceptance</strong>
            <p>
                Please confirm your acceptance of this offer by signing and returning a copy of this contract by
                {{ Carbon\Carbon::parse($contract->acceptance_deadline)->format('jS F, Y') }}. By signing, you agree to
                adhere to the terms and conditions outlined above.
            </p>
            <p>
                I wish to congratulate you on this appointment and wish you well in your duties.
            </p>
            <p>
                Yours Sincerely,
            </p>
            <br>
            <br>
            <p>Mr. Steve Nyanumba</p>
            <p><strong>ICT DIRECTOR</strong></p>
            <br>
            <br>
            <br>
            <p>
                <strong><u>ACCEPTANCE OF OFFER</u></strong>
            </p>
            <p>
                I, the undersigned, hereby accept the offer of employment with
                <strong>{{ env('COMPANY_NAME') }}</strong> under the terms and conditions stipulated in this contract.
                I acknowledge and agree to comply with all the obligations and responsibilities outlined herein.
            </p>
            <p>
                I confirm that I will report for duty on <strong>_______________________________</strong> (Start Date).
            </p>
            <p>
                <strong>Employee Details:</strong>
                <br>
                Full Name: ___________________________________________
                <br>
                Postal Address: ______________________________________
                <br>
                Physical Address: ____________________________________
            </p>
            <br>
            <p>
                <strong>Signature: ________________________________________</strong>
                <br>
                <br>
                Date: _______________________
            </p>

        </li>
    </ol>
    </p>
</body>

</html>
