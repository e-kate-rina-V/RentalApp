@extends('layouts.admin')

@section('content')
<h3>Список пользователей</h3>

<!-- <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Добавить нового пользователя</a> -->

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Ім'я</th>
            <th>Email</th>
            <th>Роль</th>
            <th>Дата реєстрації</th>
            <th>Дії</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->role }}</td>
            <td>{{ $user->created_at->format('d.m.Y') }}</td>
            <td>
                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">Редагувати</a>
                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Видалити оголошення?')">Видалити</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $users->links() }}
@endsection