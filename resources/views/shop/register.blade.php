@extends('shop.layouts.app')
@section('title', 'Регистрация')
@section('content')
<div class="auth-page">
    <div class="mp-container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="glass-card">
                    <div class="glass-card-header">
                        <h3 class="mb-0 fw-bold"><i class="fas fa-user-plus me-2"></i>Регистрация</h3>
                    </div>
                    <div class="p-4 p-md-5">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Имя пользователя</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Пароль</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Подтверждение пароля</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                            <div class="mb-4">
                                <div class="form-check">
                                    <input type="checkbox" name="terms" value="1" class="form-check-input" id="terms" {{ old('terms') ? 'checked' : '' }} required>
                                    <label class="form-check-label small" for="terms">
                                        Я принимаю <a href="{{ route('offer') }}" target="_blank" rel="noopener noreferrer">оферту</a>
                                        и <a href="{{ route('privacy') }}" target="_blank" rel="noopener noreferrer">политику конфиденциальности</a>
                                    </label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-glow w-100 py-2">Зарегистрироваться</button>
                        </form>
                        <p class="text-center mt-4 mb-0 text-muted small">Уже есть аккаунт? <a href="{{ route('login') }}" class="fw-bold">Войти</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
