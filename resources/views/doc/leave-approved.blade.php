<!DOCTYPE html>
<html>

<head>
    <title>Leave Request Approval - {{ env('COMPANY_NAME') }}</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Lexend:wght@100;200;300;400;500;600;700;800;900&display=swap");

        body {
            font-family: "Lexend", sans-serif;
            font-size: 13px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
        }

        h1 {
            color: #28a745;
        }

        .leave-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .leave-table th,
        .leave-table td {
            padding: 10px;
            border-bottom: 1px solid #b4b4b4;
            text-align: left;
        }

        .message {
            margin-top: 30px;
            font-style: italic;
            color: #424242;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Leave Request Approval</h1>
        <p>Dear {{ $leaveRequest->employee->user->name }},</p>
        <p>We are pleased to inform you that your leave request has been approved. Below are the details of your approved leave:</p>

        <table class="leave-table">
            <tr>
                <th>Leave Type:</th>
                <td>{{ $leaveRequest->leave_type->title }}</td>
            </tr>
            <tr>
                <th>Start Date:</th>
                <td>{{ Carbon\Carbon::parse($leaveRequest->start_date)->format('jS F, Y') }}</td>
            </tr>
            <tr>
                <th>End Date:</th>
                <td>{{ Carbon\Carbon::parse($leaveRequest->end_date)->format('jS F, Y') }}</td>
            </tr>
            <tr>
                <th>Reporting Back:</th>
                <td>{{ Carbon\Carbon::parse($leaveRequest->end_date)->addDay()->format('jS F, Y') }}</td>
            </tr>
            <tr>
                <th>Reason:</th>
                <td>{{ $leaveRequest->reason }}</td>
            </tr>
        </table>

        <p>We hope you have a restful and enjoyable time off. Should you have any questions or need further assistance, please do not hesitate to contact the support team.</p>

        <p>Best regards,<br>
            Support Team,<br>
            {{ env('COMPANY_NAME') }}<br>
            <a href="mailto:{{ env('COMPANY_EMAIL') }}">{{ env('COMPANY_EMAIL') }}</a>
        </p>
    </div>
</body>

</html>
