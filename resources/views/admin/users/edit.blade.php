@extends('layouts.admin')

@section('content')
<h1>Редактировать пользователя</h1>

<form action="{{ route('admin.users.update', $user) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="name">Имя</label>
        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="password">Пароль (оставьте пустым, если не хотите изменять)</label>
        <input type="password" id="password" name="password" class="form-control">
    </div>

    <div class="form-group">
        <label for="password_confirmation">Подтверждение пароля</label>
        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Обновить</button>
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Отмена</a>
</form>
@endsection