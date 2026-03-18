@extends('layouts.app')

@section('content')
<div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="row w-100 justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-5">
                    <h3 class="text-center mb-4 text-primary">{{ __('login.login_title') }} </h3>

                    @if(session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.submit') }}">
                        @csrf

                        <div class="form-floating mb-3">
                            <input id="email" type="email" 
                                class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autofocus
                                placeholder="{{ __('login.email') }}">
                            <label for="email">{{ __('login.email') }}</label>
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input id="password" type="password" 
                                class="form-control @error('password') is-invalid @enderror"
                                name="password" required placeholder="{{ __('login.password') }}">
                            <label for="password">{{ __('login.password') }}</label>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    {{ __('login.remember_me') }}
                                </label>
                            </div>
                            <a href="#" class="text-decoration-none small">
                                {{ __('login.forgot_password') }}
                            </a>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill">
                                {{ __('login.login_button') }}
                            </button>
                        </div>
                    </form>

                    <div class="mt-4 text-center">
                        <span class="text-muted">Don't have an account?</span>
                        <a href="{{ route('register') }}" class="text-decoration-none">
                            {{ __('login.register') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
