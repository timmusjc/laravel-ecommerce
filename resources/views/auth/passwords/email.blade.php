@extends('layout')

@section('main_content')
<div class="auth-page">
    <div class="container">
        <div class="auth-container">
            <div class="auth-card">
                <div class="auth-header">
                    <h1 class="auth-title">{{ __('Reset Password') }}</h1>
                </div>
              

               <div class="auth-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group">
                            <label for="email" class="form-label">{{ __('Email Address') }}</label>

                           
                                <input id="email" type="email" class="form-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                 @error('email')
                                <span class="form-error">
                                    {{ $message }}
                                </span>
                            @enderror
                            
                        </div>

                        <div class="form-actions">
                            
                                <button type="submit" class="btn-submit">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
