<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Verify Your Email</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8f9fa; margin:0; padding:0;">
    <div style="max-width: 600px; margin: 40px auto; background-color: #fff; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); overflow: hidden; text-align: center; padding: 30px;">
        
        <!-- Logo -->
        <img src="{{ $logo }}" alt="Logo" style="width:120px; height:120px; border-radius: 50%; margin-bottom: 20px; object-fit: cover;">

        <!-- Greeting -->
        <h2 style="margin-bottom: 20px; color: #333;">Hello {{ $usr_name }}!</h2>

        <!-- Message -->
        <p style="font-size: 16px; color: #555; margin-bottom: 30px;">
            Thank you for registering. Please verify your email to access all features.
        </p>

        <!-- Verify Button -->
        <a href="{{ $verificationUrl }}" style="display: inline-block; padding: 12px 25px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 5px; font-weight: bold;">
            Verify Email
        </a>

        <!-- Footer -->
        <p style="font-size: 12px; color: #999; margin-top: 30px;">
            If you did not create an account, no further action is required.
        </p>
    </div>
</body>
</html>
