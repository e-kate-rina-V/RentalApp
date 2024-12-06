@extends('layouts.admin')

@section('content')
    <h1>Редактировать объявление</h1>

    <form action="{{ route('admin.ads.update', $ad) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="title">Заголовок</label>
            <input type="text" id="title" name="title" value="{{ old('title', $ad->title) }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="prem_type">Тип недвижимости</label>
            <input type="text" id="prem_type" name="prem_type" value="{{ old('prem_type', $ad->prem_type) }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="accom_type">Тип размещения</label>
            <input type="text" id="accom_type" name="accom_type" value="{{ old('accom_type', $ad->accom_type) }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="guest_count">Количество гостей</label>
            <input type="number" id="guest_count" name="guest_count" value="{{ old('guest_count', $ad->guest_count) }}" class="form-control" min="1" required>
        </div>

        <div class="form-group">
            <label for="description">Описание</label>
            <textarea id="description" name="description" class="form-control" required>{{ old('description', $ad->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="price">Цена</label>
            <input type="number" id="price" name="price" value="{{ old('price', $ad->price) }}" class="form-control" min="0" required>
        </div>

        <div class="form-group">
            <label for="user_id">Пользователь</label>
            <select name="user_id" id="user_id" class="form-control" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id', $ad->user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Обновить</button>
        <a href="{{ route('admin.ads.index') }}" class="btn btn-secondary">Отмена</a>
    </form>
@endsection
