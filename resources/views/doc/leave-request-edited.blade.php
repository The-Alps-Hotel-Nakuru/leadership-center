<!DOCTYPE html>
<html>

<head>
    <title>Leave Request Edit Notification - {{ env('COMPANY_NAME') }}</title>
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
            color: #242464;
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
        <h1>Leave Request Edited Notification</h1>
        <p>Dear Admin,</p>
        <p>This is to inform you that {{ $leaveRequest->employee->user->name }} has edited
            {{ $leaveRequest->employee->gender == 'male' ? 'his' : 'her' }} request for leave. Below are the details of the
            leave request:</p>

        <table class="leave-table">
            <tr>
                <th>Employee Name:</th>
                <td>{{ $leaveRequest->employee->user->name }}</td>
            </tr>
            <tr>
                <th>Email Address:</th>
                <td>{{ $leaveRequest->employee->user->email }}</td>
            </tr>
            <tr>
                <th>Leave Type:</th>
                <td>{{ $leaveRequest->leave_type->title }}</td>
            </tr>
            <tr>
                <th>Start Date:</th>
                <td>{{ Carbon\Carbon::parse($leaveRequest->start_date)->format('jS F,Y') }}</td>
            </tr>
            <tr>
                <th>End Date:</th>
                <td>{{ Carbon\Carbon::parse($leaveRequest->end_date)->format('jS F,Y') }}</td>
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

        <p>Please review the request at your earliest convenience. You can take the necessary action by logging into the
            admin portal.</p>

        <p>If you have any questions or need further information, feel free to reach out to the support team.</p>

        <p>Best regards,<br>
            Support Team,<br>
            {{ env('COMPANY_NAME') }}<br>
            <a href="mailto:{{ env('COMPANY_EMAIL') }}">{{ env('COMPANY_EMAIL') }}</a>
        </p>
    </div>
</body>

</html>
