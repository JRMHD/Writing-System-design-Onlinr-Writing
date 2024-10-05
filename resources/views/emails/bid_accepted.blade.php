<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bid Accepted - Uvo Writers</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #001e00;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f2f7f2;
        }

        .header {
            background-color: #14a800;
            padding: 20px;
            text-align: center;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .logo {
            max-width: 150px;
        }

        .content {
            background-color: #ffffff;
            padding: 30px;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #14a800;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .amount {
            font-size: 24px;
            font-weight: bold;
            color: #14a800;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #5e6d55;
        }

        .button {
            display: inline-block;
            background-color: #14a800;
            color: #ffffff;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 20px;
            margin-top: 20px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #3c8224;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="/images/logo.png" alt="Uvo Writers Logo" class="logo">
    </div>
    <div class="content">
        <h1>Congratulations, {{ $writer->name }}!</h1>
        <p>Your bid on the assignment "{{ $bid->assignment->title }}" has been accepted!</p>
        <p><strong>Bid Amount:</strong> <span class="amount">KES {{ number_format($bid->amount, 2) }}</span></p>
        <p>You can now start working on the assignment. If you have any questions, feel free to reach out.</p>
        <a href="/writer/bids/active" class="button">View Assignment Details</a>
        <p>Best regards,<br>The {{ config('app.name') }} Team</p>
    </div>
    <div class="footer">
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        <p>This is an automated email, please do not reply directly to this message.</p>
    </div>
</body>

</html>
