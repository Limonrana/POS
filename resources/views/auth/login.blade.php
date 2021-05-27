@extends('layouts.app')

@section('content')
    <main class="main" id="top">
        <div class="container-fluid">
            <div class="row flex-center min-vh-100 py-6">
                <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4"><a class="d-flex flex-center mb-4" href="{{ route('mainRoot') }}"><img class="mr-2" src="{{ asset('assets/img/illustrations/falcon.png') }}" alt="" width="58" /><span class="text-sans-serif font-weight-extra-bold fs-5 d-inline-block">inventory</span></a>
                    <div class="card">
                        <div class="card-body p-4 p-sm-5">
                            <div class="row text-left justify-content-between align-items-center mb-2">
                                <div class="col-auto">
                                    <h5>Log in</h5>
                                </div>

                            </div>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group">
                                    <input id="email" type="email" placeholder="Email address" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus />
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password" />
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
                                <div class="row justify-content-between align-items-center">
                                    <div class="col-auto">
                                        <div class="custom-control custom-checkbox">
        {{--                                    <input class="custom-control-input" type="checkbox" id="basic-checkbox" checked="checked" />--}}
        {{--                                    <label class="custom-control-label" for="basic-checkbox">Remember me</label>--}}
                                            <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="remember">
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        @if (Route::has('password.request'))
                                            <a class="fs--1" href="{{ route('password.request') }}">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group"><button class="btn btn-primary btn-block mt-3" type="submit" name="submit">Log in</button></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
@endsection
