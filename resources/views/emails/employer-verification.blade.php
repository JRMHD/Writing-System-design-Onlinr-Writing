<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email Address</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 8px;
            max-width: 600px;
            margin: 20px auto;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo img {
            max-width: 150px;
            height: auto;
        }

        h1 {
            color: #14a800;
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        p {
            color: #333333;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .button {
            display: inline-block;
            padding: 12px 24px;
            font-size: 16px;
            font-weight: bold;
            color: #ffffff;
            background-color: #14a800;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #108a00;
        }

        .button-container {
            text-align: center;
            margin: 30px 0;
        }

        .footer {
            text-align: center;
            color: #666666;
            font-size: 14px;
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="logo">
            <img src="https://your-company-logo-url.com" alt="Company Logo">
        </div>
        <h1>Welcome to Our Platform!</h1>
        <p>Dear Employer,</p>
        <p>Thank you for choosing our platform to find top-tier talent for your projects. We're excited to have you on
            board! To ensure the security of your account and unlock all the features our platform offers, please verify
            your email address and Phone number.</p>
        <div class="button-container">
            <a href="{{ $verificationUrl }}" class="button">Verify My Email</a>
        </div>
        <p>Once verified, you'll gain access to:</p>
        <ul>
            <li>A vast pool of skilled professionals</li>
            <li>Advanced search and filtering tools</li>
            <li>Secure messaging and file sharing</li>
            <li>Escrow payment protection</li>
            <li>24/7 customer support</li>
        </ul>
        <p>If you did not create an account with us, please disregard this email. No further action is required.</p>
        <p>We look forward to helping you find the perfect talent for your projects!</p>
        <p>Best regards,<br>The Team</p>
        <tr>
            <td
                style="padding: 20px 30px; text-align: center; background-color: #f4f4f4; font-size: 12px; color: #666666;">
                <p>&copy; <span id="currentYear"></span> Uvo Writers. All rights reserved.</p>
                <p>Kenyatta Avenue, Nairobi, Kenya</p>
            </td>

            <script>
                // Get the current year
                document.getElementById('currentYear').textContent = new Date().getFullYear();
            </script>

        </tr>
    </div>
</body>

</html>
