<!DOCTYPE html>
<html>

<head>
    <title>Email Verification</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body>
    <div id="verify-email-body">
        <h1>Verify Your Email Address</h1>
        <p>Click the link below to verify your email address:</p>

        <button id="verify-email-btn" class="btn btn-light"><a href="{{ $verificationUrl }}" class="link-dark">Verify Email</a></button>
    </div>
</body>

</html>