@extends('layouts.admin')

@section('content')
<h3>Список бронирований</h3>

<!-- <a href="{{ route('reservations.create') }}" class="btn btn-primary mb-3">Создать новую резервацию</a> -->

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Пользователь</th>
            <th>Объявление</th>
            <th>Дата начала</th>
            <th>Дата окончания</th>
            <th>Статус</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($reservations as $reservation)
        <tr>
            <td>{{ $reservation->id }}</td>
            <td>{{ $reservation->user->name }}</td>
            <td>{{ $reservation->ad->title }}</td>
            <td>{{ $reservation->start_date }}</td>
            <td>{{ $reservation->end_date }}</td>
            <td>{{ $reservation->status }}</td>
            <td>
                <a href="{{ route('reservations.edit', $reservation->id) }}" class="btn btn-warning btn-sm">Редактировать</a>
                <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $reservations->links() }} 
@endsection