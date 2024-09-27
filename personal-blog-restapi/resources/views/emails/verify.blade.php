<!-- resources/views/emails/verify.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
</head>
<body>
<h1>Wall Blog</h1>
<h2>Hello {{ $user->name }},</h2>
<p>Thank you for registering. Please click the link below to verify your email address:</p>
<a href="{{ $verificationUrl }}">Verify Email Address</a>
<p>If you did not create an account, no further action is required.</p>
</body>
</html>
