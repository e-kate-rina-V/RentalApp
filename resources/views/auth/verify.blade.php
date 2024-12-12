<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
</head>

<body>
    <div>
        @if(session('status'))
        <h2>{{ session('status') }}</h2>
        @elseif($errors->has('error'))
        <h2>{{ $errors->first('error') }}</h2>
        @endif
    </div>
    <h2>Email successfully verified.</h2>
</body>

</html>