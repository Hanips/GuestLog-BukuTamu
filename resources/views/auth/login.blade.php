@extends('layouts.app')

@section('title_page', 'Login')

@section('content')
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row justify-content-center align-items-center">
                    <div class="col-12 col-md-6 col-lg-5">
                        <div class="card card-primary">
                            <div class="card-header"><h4>{{ __('Login') }}</h4></div>

                            <div class="card-body">
                                <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate="">
                                @csrf
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" name="email" tabindex="1" required autocomplete="email" autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="d-block">
                                        <label for="password" class="control-label">Password</label>
                                    <div class="float-right">
                                        @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="text-small">
                                            Forgot Password?
                                        </a>
                                        @endif
                                    </div>
                                    </div>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" tabindex="2" required autocomplete="current-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" name="remember" id="remember-me"
                                            {{ old('remember') ? 'checked' : '' }}>
                                        <label class="custom-control-label"
                                            for="remember-me">{{ __('Remember Me') }}</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                    {{ __('Login') }}
                                    </button>
                                </div>
                                </form>
                            </div>
                        </div>
                        <div class="mt-5 text-muted text-center">
                            Don't have an account? <a href="{{ route('register') }}">{{ __('Register') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection