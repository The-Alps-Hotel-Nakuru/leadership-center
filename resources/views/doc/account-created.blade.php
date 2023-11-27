<!DOCTYPE html>
<html>

<head>
    <title>Welcome to The Alps Hotel Nakuru - KCB Leadership Centre</title>
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

        .login-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .login-table th,
        .login-table td {
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
        <h1>Welcome to {{ env('COMPANY_NAME') }}!</h1>
        <p>Greetings {{ $user->name }},</p>
        <p>Thank you for joining our team. We are excited to have you on board and look forward to
            working together.</p>
        <p>Please find below your login credentials to access the system:</p>

        <table class="login-table">
            <tr>
                <th>Email Address:</th>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <th>Password:</th>
                <td>{{ $password }}</td>
            </tr>
        </table>

        <p>To log in, please follow these steps:</p>
        <ol>
            <li>Go to <a href="{{ env('APP_URL') }}" target="_blank">This Portal</a></li>
            <li>Enter your credentials as provided above.</li>
        </ol>
        <p>If you have any questions or need any assistance, feel free to reach out to the support team.</p>

        <p>Welcome aboard once again, and we wish you a successful and fulfilling journey with {{ env('COMPANY_NAME') }}!</p>

        <p>Best regards,<br>
            Support Team,<br>
            {{ env('COMPANY_NAME') }}
            <a href="mailto:{{ env('COMPANY_EMAIL') }}">{{ env('COMPANY_EMAIL') }}</a>
        </p>
    </div>
</body>

</html>
