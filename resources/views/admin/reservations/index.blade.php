@extends('layouts.admin')

@section('content')
<h3>Список бронювань</h3>

<!-- <a href="{{ route('reservations.create') }}" class="btn btn-primary mb-3">Создать новую резервацию</a> -->

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Бронь на користувача</th>
            <th>Оголошення</th>
            <th>Дата прибуття</th>
            <th>Дата від'їзду</th>
            <th>Статус</th>
            <th>Дії</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($reservations as $reservation)
        <tr>
            <td>{{ $reservation->id }}</td>
            <td>{{ $reservation->user->email }}</td>
            <td>{{ $reservation->ad->title }}</td>
            <td>{{ $reservation->arrival_date }}</td>
            <td>{{ $reservation->depart_date }}</td>
            <td>{{ $reservation->status }}</td>
            <td>
                <a href="{{ route('reservations.edit', $reservation->id) }}" class="btn btn-warning btn-sm">Редагувати</a>
                <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Видалити бронювання?')">Видалити</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $reservations->links() }}
@endsection