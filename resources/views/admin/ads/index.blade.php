@extends('layouts.admin')

@section('content')
<h1>Список оголошень</h1>

<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Назва</th>
            <th>Тип</th>
            <th>Ціна</th>
            <th>Власник</th>
            <th>Дії</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($ads as $ad)
        <tr>
            <td>{{ $ad->id }}</td>
            <td>{{ $ad->title }}</td>
            <td>{{ $ad->prem_type }}</td>
            <td>{{ $ad->price }} ₴</td>
            <td>{{ $ad->user->email }}</td>
            <td>
                <a href="{{ route('ads.edit', $ad) }}" class="btn btn-warning">Редагувати</a>
                <form action="{{ route('ads.destroy', $ad) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Видалити оголошення?')">Видалити</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $ads->links() }}
@endsection