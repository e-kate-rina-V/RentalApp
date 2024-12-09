@extends('layouts.admin')

@section('content')
<h1>Редагувати користувача</h1>

<form id="user-change" action="{{ route('users.update', $user) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="name">Ім'я</label>
        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
        <span class="error-message" id="nameError"></span>
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
        <span class="error-message" id="emailError"></span>
    </div>

    <div class="form-group">
        <label for="password">Пароль (залиште пустим, якщо не хочете змінювати)</label>
        <input type="password" id="password" name="password" class="form-control">
        <span class="error-message" id="passwordError"></span>
    </div>

    <div class="form-group">
        <label for="password_confirmation">Підтвердження паролю</label>
        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
        <span class="error-message" id="passwordConfirmationError"></span>
    </div>

    <button type="submit" class="btn btn-primary">Оновити дані</button>
    <a href="{{ route('users.index') }}" class="btn btn-secondary">Відміна</a>
</form>

<script src="{{ asset('js/user_change_validation.js') }}"></script>
@endsection


<style>
    .error-message {
        color: red;
    }
</style>