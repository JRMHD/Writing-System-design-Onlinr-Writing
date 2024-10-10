<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email Address & Phone Number</title>
</head>

<body
    style="font-family: 'Poppins', Arial, sans-serif; line-height: 1.6; color: #333333; margin: 0; padding: 0; background-color: #f4f4f4;">
    <table cellpadding="0" cellspacing="0" width="100%"
        style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-collapse: collapse;">
        <tr>
            <td style="padding: 40px 30px; text-align: center; background-color: #14a800;">
                <img src="/images/logo.png" alt="Company Logo" style="max-width: 150px; height: auto;">
            </td>
        </tr>
        <tr>
            <td style="padding: 40px 30px;">
                <h1 style="font-size: 25px; font-weight: 600; color: #14a800; margin-bottom: 20px;">Verify Your Email
                    Address and Phone Number</h1>
                <p style="font-size: 16px; margin-bottom: 20px;">Dear Writer,</p>
                <p style="font-size: 16px; margin-bottom: 20px;">Thank you for registering with us. We're excited to
                    have you on board! To ensure the security of your account and activate all features, please verify
                    your Details by clicking the button below:</p>
                <table cellpadding="0" cellspacing="0" width="100%" style="margin-bottom: 20px;">
                    <tr>
                        <td align="center">
                            <a href="{{ $verificationUrl }}"
                                style="display: inline-block; padding: 12px 24px; background-color: #14a800; color: #ffffff; text-decoration: none; font-weight: 600; border-radius: 4px; font-size: 16px;">Verify
                                Email</a>
                        </td>
                    </tr>
                </table>
                <p style="font-size: 14px; color: #666666; margin-bottom: 20px;">If the button above doesn't work, you
                    can also copy and paste the following link into your browser:</p>
                <p style="font-size: 14px; color: #14a800; word-break: break-all; margin-bottom: 20px;">
                    {{ $verificationUrl }}</p>
                <p style="font-size: 14px; color: #666666; margin-bottom: 20px;">This link will expire in 60 Minutes for
                    security reasons. If you need a new verification link, please log in to your account and request a
                    new one.</p>
                <p style="font-size: 14px; color: #666666; margin-bottom: 20px;">If you did not create an account with
                    us, please disregard this email. No further action is required.</p>
                <p style="font-size: 16px; margin-bottom: 10px;">Best regards,<br>The Uvo Writers Team</p>
            </td>
        </tr>
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
    </table>
</body>

</html>
