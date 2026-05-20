@extends('shop.layouts.app')
@section('title', 'Редактирование профиля')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-sm p-4">
                <h3 class="mb-4">Редактировать профиль</h3>
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Телефон</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $profile->phone) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Город</label>
                        <input type="text" name="city" class="form-control" value="{{ old('city', $profile->city) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Адрес</label>
                        <textarea name="address" class="form-control" rows="2">{{ old('address', $profile->address) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Почтовый индекс</label>
                        <input type="text" name="postal_code" class="form-control" value="{{ old('postal_code', $profile->postal_code) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Аватар</label>
                        <input type="file" name="avatar" class="form-control" accept="image/*">
                    </div>
                    <div class="ac-form-actions">
                        <button type="submit" class="btn btn-accent">Сохранить</button>
                        <a href="{{ route('profile') }}" class="btn btn-outline-ac">Отмена</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
