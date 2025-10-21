<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>KSG Agent Password Reset</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f5f7f6; padding: 30px;">

    <div style="max-width: 650px; margin: auto; background-color: #ffffff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); border: 1px solid #e1e6e1;">

        <!-- Header -->
        <div style="text-align: center; margin-bottom: 30px;">
            <h1 style="color: #004d00; font-size: 26px; margin: 0;">Kenya School of Government (KSG)</h1>
            <p style="color: #444; font-size: 15px; margin-top: 8px;">Agent Training Portal</p>
        </div>

        <!-- Greeting -->
        <h2 style="color: #333333;">Dear {{ $agent->email }},</h2>

        <!-- Message Body -->
        <p style="color: #4a4a4a; font-size: 16px; line-height: 1.6;">
            A <strong>temporary password</strong> has been generated for your KSG Agent Training Portal account:
            <br><br>
            <span style="display:inline-block; background-color:#e9f7ef; padding:10px 18px; border-left:5px solid #00cc44; border-radius:6px; font-size:18px; font-weight:bold; color:#004d00;">
                {{ $tempPassword }}
            </span>
        </p>

        <p style="color: #4a4a4a; font-size: 16px; line-height: 1.6;">
            Please click the button below to set your new password. This link will expire in <strong>30 minutes</strong>.
        </p>

        <!-- Reset Password Button -->
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ url('/agent/set-password/' . $resetToken) }}"
               style="display: inline-block; background-color: #5A381E; color: #fff; text-decoration: none; padding: 14px 28px; border-radius: 8px; font-size: 18px; font-weight: 600;">
                Set New Password
            </a>
        </div>

        <!-- Security Notice -->
        <div style="margin: 30px 0; background-color: #f1f9f2; border-left: 6px solid #00cc44; padding: 20px 25px; border-radius: 8px; box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05);">
            <h3 style="margin: 0 0 10px 0; font-size: 18px; color: #004d00;">Action Required</h3>
            <p style="margin: 0; font-size: 16px; color: #000;">
                For security reasons, please reset your password before logging in to the Agent Training Portal.
            </p>
        </div>

        <!-- Footer -->
        <p style="color: #555; font-size: 15px; line-height: 1.5;">
            If you did not request this password reset, please contact the KSG ICT support team immediately.
        </p>

        <p style="color: #333; font-size: 16px; margin-top: 30px;">
            Kind regards,<br>
            <strong style="color: #004d00;">KSG ICT Team</strong><br>
            <small style="color:#5A381E;">(Developed by Denis & Allan)</small>
        </p>
    </div>

    <!-- Footer Background -->
    <p style="text-align: center; color: #999; font-size: 12px; margin-top: 30px;">
        © {{ date('Y') }} Kenya School of Government (KSG) — All Rights Reserved.
    </p>

</body>
</html>
