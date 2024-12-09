@extends('layouts.admin')

@section('content')
<h1>Редагувати бронювання</h1>

<form id="reservation-change" action="{{ route('reservations.update', $reservation) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="ad_id">Оголошення</label>
        <select name="ad_id" id="ad_id" class="form-control" required>
            @foreach($ads as $ad)
            <option value="{{ $ad->id }}" {{ $ad->id == old('ad_id', $reservation->ad_id) ? 'selected' : '' }}>
                {{ $ad->title }} ({{ $ad->prem_type }})
            </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="user_email">Власник</label>
        <select name="user_email" id="user_email" class="form-control" required>
            @foreach($users as $user)
            <option value="{{ $user->email }}" {{ $user->email == old('user_email', $reservation->ad->user->email) ? 'selected' : '' }}>
                {{ $user->email }}
            </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="booked_by_user_email">Бронь на:</label>
        <select name="user_id" id="user_id" class="form-control" required>
            @foreach($users as $user)
            <option value="{{ $user->id }}" {{ $user->id == old('user_id', $reservation->user_id) ? 'selected' : '' }}>
                {{ $user->email }}
            </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="arrival_date">Дата прибуття</label>
        <input type="date" id="arrival_date" name="arrival_date" value="{{ old('arrival_date', $reservation->arrival_date ? $reservation->arrival_date->toDateString() : '') }}" class="form-control" required>
        <span class="error-message" id="arrivalDateError"></span>
    </div>

    <div class="form-group">
        <label for="depart_date">Дата від'їзду</label>
        <input type="date" id="depart_date" name="depart_date" value="{{ old('depart_date', $reservation->depart_date ? $reservation->depart_date->toDateString() : '') }}" class="form-control" required>
        <span class="error-message" id="departDateError"></span>
    </div>

    <div class="form-group">
        <label for="total_cost">Ціна</label>
        <input type="number" id="total_cost" name="total_cost" value="{{ old('total_cost', $reservation->total_cost) }}" class="form-control" required>
        <span class="error-message" id="priceError"></span>
    </div>

    <button type="submit" class="btn btn-primary">Оновити дані</button>
    <a href="{{ route('reservations.index') }}" class="btn btn-secondary">Відміна</a>
</form>

<script src="{{ asset('js/reservation_change_validation.js') }}"></script>

@endsection

<style>
    .error-message {
        color: red;
    }
</style>