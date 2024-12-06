@extends('layouts.admin')

@section('content')
    <h1>Редактировать Резервацию</h1>

    <form action="{{ route('admin.reservations.update', $reservation) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="ad_id">Объявление</label>
            <select name="ad_id" id="ad_id" class="form-control" required>
                @foreach($ads as $ad)
                    <option value="{{ $ad->id }}" {{ $ad->id == old('ad_id', $reservation->ad_id) ? 'selected' : '' }}>
                        {{ $ad->title }} ({{ $ad->prem_type }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="user_id">Пользователь</label>
            <select name="user_id" id="user_id" class="form-control" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $user->id == old('user_id', $reservation->user_id) ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="start_date">Дата начала</label>
            <input type="date" id="start_date" name="start_date" value="{{ old('start_date', $reservation->start_date->toDateString()) }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="end_date">Дата окончания</label>
            <input type="date" id="end_date" name="end_date" value="{{ old('end_date', $reservation->end_date->toDateString()) }}" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Обновить</button>
        <a href="{{ route('admin.reservations.index') }}" class="btn btn-secondary">Отмена</a>
    </form>
@endsection
