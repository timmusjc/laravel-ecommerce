@extends('layout')

@section('title')
    Rejestracja
@endsection

@section('main_content')
<div class="auth-page">
    <div class="container">
        <div class="auth-container">
            <div class="auth-card">
                <div class="auth-header">
                    <h1 class="auth-title">Rejestracja</h1>
                    <p class="auth-subtitle">Utwórz nowe konto</p>
                </div>

                <div class="auth-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Imię -->
                        <div class="form-group">
                            <label for="name" class="form-label">Imię</label>
                            <input id="name" 
                                   type="text" 
                                   class="form-input @error('name') is-invalid @enderror" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required 
                                   autocomplete="name" 
                                   autofocus
                                   placeholder="Jan Kowalski">

                            @error('name')
                                <span class="form-error">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email" class="form-label">Adres email</label>
                            <input id="email" 
                                   type="email" 
                                   class="form-input @error('email') is-invalid @enderror" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autocomplete="email"
                                   placeholder="twoj@email.pl">

                            @error('email')
                                <span class="form-error">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <!-- Hasło -->
                        <div class="form-group">
                            <label for="password" class="form-label">Hasło</label>
                            <input id="password" 
                                   type="password" 
                                   class="form-input @error('password') is-invalid @enderror" 
                                   name="password" 
                                   required 
                                   autocomplete="new-password">

                            @error('password')
                                <span class="form-error">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <!-- Potwierdzenie hasła -->
                        <div class="form-group">
                            <label for="password-confirm" class="form-label">Potwierdź hasło</label>
                            <input id="password-confirm" 
                                   type="password" 
                                   class="form-input" 
                                   name="password_confirmation" 
                                   required 
                                   autocomplete="new-password">
                        </div>

                        <!-- Кнопка регистрации -->
                        <div class="form-actions">
                            <button type="submit" class="btn-submit">
                                Zarejestruj się
                            </button>

                            @if (Route::has('login'))
                                <a class="link-forgot" href="{{ route('login') }}">
                                    Masz już konto? Zaloguj się
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection