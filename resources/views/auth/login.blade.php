@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 text-center mb-3 mt-10">
            <img src="{{asset('public/app/images/logo.svg')}}"" alt="" height="100">
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow p-3">
                <h5 class="card-title mb-3 mt-3 text-center">Inicio de Sesión</h5>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="row mb-4 justify-content-center">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="has-float-label">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder=" ">
                                        <label for="email">{{ __('Email Address') }}</label>
                                        <i class="bi bi-at form-control-icon"></i>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="has-float-label">
                                        <i class="bi bi-lock form-control-icon"></i>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="password" placeholder=" ">
                                        <label for="password">{{ __('Password') }}</label>
                                        <i id="icon-eye" class="bi bi-eye-slash form-icon-passwd btn-show-passwd" data-passwd="password"></i>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-7">
                                <button type="submit" class="btn btn-primary float-end">
                                    {{ __('Login') }} <i class="bi bi-box-arrow-in-right"></i>
                                </button>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6">
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <a href="{{route('register')}}" class="btn btn-link float-end">
                                    <i class="fal fa-user-plus"></i> Registrarse
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
                <footer class="py-16 text-center text-sm text-black dark:text-white/70 small text-muted">
                    Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                </footer>
            </div>
        </div>
    </div>
</div>
@endsection
