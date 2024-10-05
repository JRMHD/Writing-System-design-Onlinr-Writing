<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Withdrawal Request Processed - Uvo Writers</title>
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

        ul {
            list-style-type: none;
            padding-left: 0;
        }

        ul li {
            margin-bottom: 10px;
        }

        ul li:before {
            content: '✓';
            color: #14a800;
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="/images/logo.png" alt="Uvo Writers Logo" class="logo">
    </div>
    <div class="content">
        <h1>Hello, {{ $writer->name }}</h1>
        <p>Great news! Your withdrawal request has been successfully processed.</p>
        <p>Amount: <span class="amount">KES {{ number_format($amount, 2) }}</span></p>
        <p>Here's a summary of your transaction:</p>
        <ul>
            <li>Date: {{ date('F j, Y') }}</li>
            <li>Status: Completed</li>
        </ul>
        <p>The funds should be reflected in your account within 1-3 business days, depending on your bank's processing
            time.</p>
        <p>If you have any questions about this transaction or need further assistance, please don't hesitate to reach
            out to our support team.</p>
        <a href="/writer/balance" class="button">View Transaction Details</a>
        <p>Thank you for choosing Uvo Writers for your freelancing journey. We appreciate your trust in our platform.
        </p>
        <p>Best regards,<br>The Uvo Writers Team</p>
    </div>
    <div class="footer">
        <p>&copy; {{ date('Y') }} Uvo Writers. All rights reserved.</p>
        <p>This is an automated email, please do not reply directly to this message.</p>
    </div>
</body>

</html>
