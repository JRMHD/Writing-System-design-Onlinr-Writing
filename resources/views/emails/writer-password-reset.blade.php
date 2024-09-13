<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset - Uvo Writers</title>
</head>

<body
    style="font-family: Arial, sans-serif; line-height: 1.6; color: #001e00; background-color: #f2f7f2; margin: 0; padding: 0;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f2f7f2;">
        <tr>
            <td style="padding: 20px;">
                <table width="100%" cellpadding="0" cellspacing="0"
                    style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <tr>
                        <td style="padding: 40px 30px;">
                            <h1 style="color: #14a800; font-size: 24px; margin-bottom: 20px; text-align: center;">Uvo
                                Writers</h1>
                            <h2 style="color: #001e00; font-size: 20px; margin-bottom: 20px;">Password Reset Request
                            </h2>
                            <p style="margin-bottom: 20px;">Hello Writer,</p>
                            <p style="margin-bottom: 20px;">You recently requested to reset your password for your Uvo
                                Writers account. Click the button below to reset it:</p>
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $resetUrl }}"
                                            style="display: inline-block; background-color: #14a800; color: #ffffff; text-decoration: none; padding: 12px 24px; border-radius: 20px; font-weight: bold; font-size: 16px;">Reset
                                            Your Password</a>
                                    </td>
                                </tr>
                            </table>
                            <p style="margin-top: 30px; font-size: 14px; color: #656565;">If you did not request a
                                password reset, please ignore this email or contact support if you have concerns.</p>
                            <p style="margin-top: 30px; font-size: 14px; color: #656565;">This password reset link is
                                only valid for the next 60 minutes.</p>
                        </td>
                    </tr>
                    <tr>
                        <td
                            style="background-color: #001e00; color: #ffffff; text-align: center; padding: 20px; border-radius: 0 0 8px 8px;">
                            <p style="margin: 0; font-size: 14px;">&copy; {{ date('Y') }} Uvo Writers. All rights
                                reserved.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
