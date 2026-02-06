@extends('layout')

@section('title')
    Logowanie
@endsection

@section('main_content')
    <div class="auth-page">
        <div class="container">
            <div class="auth-container">
                <div class="auth-card">
                    <div class="auth-header">
                        <h1 class="auth-title">Logowanie</h1>
                        <p class="auth-subtitle">Zaloguj się do swojego konta</p>
                    </div>

                    <div class="auth-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <label for="email" class="form-label">Adres email</label>
                                <input id="email" type="email" class="form-input @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                    placeholder="twoj@email.pl">

                                @error('email')
                                    <span class="form-error">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password" class="form-label">Hasło</label>
                                <input id="password" type="password"
                                    class="form-input @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="current-password">

                                @error('password')
                                    <span class="form-error">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="form-checkbox">
                                    <input type="checkbox" name="remember" id="remember" class="checkbox-input"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <label for="remember" class="checkbox-label">
                                        Zapamiętaj mnie
                                    </label>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn-submit">
                                    Zaloguj się
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="link-forgot" href="{{ route('password.request') }}">
                                        Zapomniałeś hasło?
                                    </a>
                                @endif
                                @if (Route::has('register'))
                                    <a class="link-forgot" href="{{ route('register') }}">
                                        Nie masz jeszcze konta?
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
