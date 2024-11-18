<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
</head>

<body>
    <h2>Регистрация</h2>
    <form method="POST" action="{{ route('register') }}">
        
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <label for="name">{{ __('Name') }}</label>
        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" required>
        @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

        <label for="email">{{ __('Email Adress') }}</label>
        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" required>
        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

        <label for="role">{{ __('Role') }}</label>
        <input type="role" id="role" name="role" class="form-control @error('role') is-invalid @enderror" required>
        @error('role')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

        <label for="password">{{ __('Password') }}</label>
        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

        <label for="password_confirmation">{{ __('Password Confirmation') }}</label>
        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>

        <button type="submit">{{ __('Зарегистрироваться') }}</button>
    </form>
</body>

</html>

<style>
    form {
        display: grid;
        width: 10%;
        gap: 10%;
    }
</style>