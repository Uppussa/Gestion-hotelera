@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 text-center mb-3">
            <img src="{{asset('public/assets/custom/images/logo.svg')}}"" alt="" height="100">
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow p-3">
                
                <h5 class="card-title mb-3 mt-3 text-center">Registro</h5>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-4 justify-content-center">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="has-float-label">
                                        <input id="name" type="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder=" ">
                                        <label for="name">{{ __('Name') }}</label>
                                        <i class="bi bi-person-circle form-control-icon"></i>
                                        @error('name')
                                            <div class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4 justify-content-center">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="has-float-label">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder=" ">
                                        <label for="email">{{ __('Email Address') }}</label>
                                        <i class="bi bi-at form-control-icon"></i>
                                        @error('email')
                                            <div class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </div>
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
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="off" placeholder=" ">
                                        <label for="password">{{ __('Password') }}</label>
                                        <i id="icon-eye" class="bi bi-eye-slash form-icon-passwd btn-show-passwd" data-passwd="password"></i>
                                        @error('password')
                                            <div class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </div>
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
                                        <input id="password_confirmation" type="password" class="form-control  password-match @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required autocomplete="off" placeholder=" " data-passwd="password">
                                        <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                                        <i id="icon-eye" class="bi bi-eye-slash form-icon-passwd btn-show-passwd" data-passwd="password_confirmation"></i>
                                        @error('password_confirmation')
                                            <div class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary float-end">
                                    {{ __('Register') }} <i class="bi bi-person-plus"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
