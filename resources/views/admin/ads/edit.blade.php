@extends('layouts.admin')

@section('content')
<h1>Редагувати оголошення</h1>

<form id="ad-change" action="{{ route('ads.update', $ad) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="title">Титульна назва</label>
        <input type="text" id="title" name="title" value="{{ old('title', $ad->title) }}" class="form-control" required>
        <span class="error-message" id="titleError"></span>
    </div>

    <div class="form-group">
        <label for="prem_type">Тип помешкання</label>
        <select id="prem_type" name="prem_type" class="form-control" required>
            <option value="flat" {{ old('prem_type', $ad->prem_type) == 'flat' ? 'selected' : '' }}>Квартира</option>
            <option value="house" {{ old('prem_type', $ad->prem_type) == 'house' ? 'selected' : '' }}>Будинок</option>
            <option value="hotel_room" {{ old('prem_type', $ad->prem_type) == 'hotel_room' ? 'selected' : '' }}>Кімната у готелі</option>
        </select>
    </div>

    <div class="form-group">
        <label for="accom_type">Тип розміщення</label>
        <select id="accom_type" name="accom_type" class="form-control" required>
            <option value="entire_place" {{ old('accom_type', $ad->accom_type) == 'entire_place' ? 'selected' : '' }}>Ціле примешкання</option>
            <option value="private_room" {{ old('accom_type', $ad->accom_type) == 'private_room' ? 'selected' : '' }}>Кімната</option>
            <option value="shared_room" {{ old('accom_type', $ad->accom_type) == 'shared_room' ? 'selected' : '' }}>Спільна кімната</option>
        </select>
    </div>

    <div class="form-group">
        <label for="guest_count">Кількість гостей</label>
        <input type="number" id="guest_count" name="guest_count" value="{{ old('guest_count', $ad->guest_count) }}" class="form-control" min="1" required>
        <span class="error-message" id="guestCountError"></span>
    </div>

    <div class="form-group">
        <label for="description">Опис</label>
        <textarea id="description" name="description" class="form-control" required>{{ old('description', $ad->description) }}</textarea>
        <span class="error-message" id="descriptionError"></span>
    </div>

    <div class="form-group">
        <label for="price">Ціна</label>
        <input type="number" id="price" name="price" value="{{ old('price', $ad->price) }}" class="form-control" min="0" required>
        <span class="error-message" id="priceError"></span>
    </div>

    <div class="form-group">
        <label for="user_id">Власник</label>
        <select name="user_email" id="user_email" class="form-control" required>
            @foreach($users as $user)
            <option value="{{ $user->email }}" {{ old('user_email', $ad->user_email) == $user->email ? 'selected' : '' }}>{{ $user->email }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Оновити дані</button>
    <a href="{{ route('ads.index') }}" class="btn btn-secondary">Відміна</a>
</form>

<script src="{{ asset('js/ad_change_validation.js') }}"></script>

@endsection

<style>
    .error-message {
        color: red;
    }
</style>