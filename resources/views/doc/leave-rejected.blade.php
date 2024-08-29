<!DOCTYPE html>
<html>

<head>
    <title>Leave Request Rejection - {{ env('COMPANY_NAME') }}</title>
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
            color: #e74c3c;
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
        <h1>Leave Request #{{ $leaveRequest->id }} Rejection</h1>
        <p>Dear {{ $leaveRequest->employee->user->name }},</p>
        <p>We regret to inform you that your recent leave request has been rejected. Please reach out to your manager or
            HR for more details or clarification regarding this decision.</p>

        <p>If you have any questions or require further assistance, feel free to contact the support team.</p>

        <p>Best regards,<br>
            Support Team,<br>
            {{ env('COMPANY_NAME') }}<br>
            <a href="mailto:{{ env('COMPANY_EMAIL') }}">{{ env('COMPANY_EMAIL') }}</a>
        </p>
    </div>
</body>

</html>
