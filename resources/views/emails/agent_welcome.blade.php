<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to KSG Agent Training Portal</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Arial, sans-serif; background-color: #f5f7f6;">
    <!-- Main Container -->
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f5f7f6;">
        <tr>
            <td align="center" style="padding: 20px 0;">
                <!-- Email Content Container -->
                <table width="650" cellpadding="0" cellspacing="0" border="0" style="background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(90deg, #004d00, #00ff66); color: white; text-align: center; padding: 25px 20px;">
                            <h1 style="margin: 0; font-size: 24px; font-weight: 700;">Welcome to KSG Agent Training Portal 💼</h1>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 30px 40px; color: #333;">
                            <h2 style="color: #004d00; font-size: 22px; margin-bottom: 10px;">Hello {{ $agent->email }},</h2>
                            
                            <p style="line-height: 1.6; font-size: 15px; margin-bottom: 15px;">
                                We're absolutely delighted to welcome you to the <strong>KSG Agent Training Portal</strong> — your gateway to our digital agent training system. This platform is designed to empower agents with the tools, information, and training needed to excel. 🌟
                            </p>
                            
                            <p style="line-height: 1.6; font-size: 15px; margin-bottom: 15px;">
                                Below is your unique <strong>Security Key</strong> — please keep it safe and confidential.
                            </p>
                            
                            <!-- Security Key Panel -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin: 20px 0;">
                                <tr>
                                    <td align="center">
                                        <div style="background: #e9f7ef; border-left: 5px solid #00cc44; padding: 15px; font-size: 18px; font-weight: bold; color: #004d00; text-align: center; border-radius: 5px;">
                                            {{ $securityKey }}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            
                            <p style="line-height: 1.6; font-size: 15px; margin-bottom: 15px;">
                                You can now log in to your account by clicking the button below:
                            </p>
                            
                            <!-- Login Button -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin: 20px 0; text-align: center;">
                                <tr>
                                    <td>
                                        <a href="{{ $loginUrl }}" style="display: inline-block; background: #8B4513; color: white; text-decoration: none; padding: 12px 24px; border-radius: 5px; font-weight: 600; margin-top: 10px;">
                                            Login to Portal
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            
                            <p style="line-height: 1.6; font-size: 15px; margin-bottom: 15px;">
                                Once you log in, kindly <strong>update your profile</strong> to proceed with providing your information to the agent system.
                            </p>
                            
                            <p style="line-height: 1.6; font-size: 15px; margin-bottom: 15px;">
                                We look forward to working with you — welcome aboard! 💚
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background: #004d00; color: #ffffff; text-align: center; padding: 15px; font-size: 13px;">
                            <p style="margin: 0;">Developed with <span style="color: #00ff66; font-weight: bold;">❤</span> by the KSG ICT Team — <span style="color: #00ff66; font-weight: bold;">Denis & Allan</span></p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>