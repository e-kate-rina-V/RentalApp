<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
</head>

<body>
    <h2>Вход</h2>
    <form method="POST" action="{{ route('login') }}" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <label for="email">{{ __('Email') }}</label>
        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" required>
        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

        <label for="password">{{ __('Пароль') }}</label>
        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        <div class="form-group">
            <label for="image">Зображення</label>
            <input type="file" id="image" name="image">
        </div>
        <button type="submit">{{ __('Войти') }}</button>
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