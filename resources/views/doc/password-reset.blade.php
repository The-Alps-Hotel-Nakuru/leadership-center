<!DOCTYPE html>
<html>

<head>
    <title>Your Password Has Been Reset</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
        }

        h1 {
            color: #1575BB;
        }

        .login-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .login-table th,
        .login-table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        .message {
            margin-top: 30px;
            font-style: italic;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Password Has Been Reset</h1>
        <p>Greetings {{ $user->name }},</p>
        <p>We have deemed it so that your password had to be reset given internal circumstances.</p>
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
        <p>If you have any questions or need any assistance, feel free to reach out to the ICT department.</p>

        <p>Welcome aboard once again, and we wish you a successful and fulfilling journey with The Alps Hotel!</p>

        <p>Best regards,<br>
            Steve O. Nyanumba <i>SwE.</i><br>
            IT Manager & ICT Director<br>
            The Alps Hotel Nakuru
            <a href="mailto:tech@thealpshotelnakuru.com">tech@thealpshotelnakuru.com</a>
        </p>
    </div>
</body>

</html>