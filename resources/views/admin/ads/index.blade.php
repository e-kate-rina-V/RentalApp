@extends('layouts.admin')

@section('content')
    <h1>Список объявлений</h1>

    <!-- <a href="{{ route('ads.create') }}" class="btn btn-primary">Создать объявление</a> -->

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Название</th>
                <th>Тип</th>
                <th>Цена</th>
                <th>Владелец</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ads as $ad)
                <tr>
                    <td>{{ $ad->id }}</td>
                    <td>{{ $ad->title }}</td>
                    <td>{{ $ad->prem_type }}</td>
                    <td>{{ $ad->price }} ₴</td>
                    <td>{{ $ad->user->name }}</td>
                    <td>
                        <a href="{{ route('ads.edit', $ad) }}" class="btn btn-warning">Редактировать</a>
                        <form action="{{ route('ads.destroy', $ad) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" onclick="return confirm('Удалить объявление?')">Удалить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $ads->links() }}
@endsection
