@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 text-center mb-3 mt-10">
            <img src="{{asset('public/app/images/logo.svg')}}"" alt="" height="100">
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow p-3">
                <h5 class="card-title mb-3 mt-3 text-center"><i class="bi bi-lock"></i> {{ __('Reset Password') }}</h5>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6">
                                <a href="{{route('login')}}" class="btn btn-link">
                                    <i class="fal fa-arrow-left"></i> Regresar a login
                                </a>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary float-end">
                                    {{ __('Send Password Reset Link') }} <i class="bi bi-check-circle"></i>
                                </button>
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
