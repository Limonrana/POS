@include('partials.header')
    <div class="container" data-layout="container">
        <div class="row flex-center min-vh-100 py-6">
            <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4"><a class="d-flex flex-center mb-4" href="{{ route('home') }}"><img class="mr-2" src="../../assets/img/illustrations/falcon.png" alt="" width="58"><span class="text-sans-serif font-weight-extra-bold fs-5 d-inline-block">Inventory</span></a>
                <div class="card">
                    <div class="card-body p-4 p-sm-5">
                        <h5 class="text-center">Change Your Password</h5>
                        <form class="mt-3" action="{{ route('change.password.update') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input id="oldpass" type="password" class="form-control @error('oldpass') is-invalid @enderror" name="oldpass" value="{{ $oldpass ?? old('oldpass') }}" required autocomplete="oldpass" autofocus placeholder="Old Password">
                                @error('oldpass')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="New Password" required autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                            </div>
                            <button class="btn btn-primary btn-block mt-3" type="submit" name="submit">Set password</button>
                        </form>
                        <div class="text-center mt-3">
                            <a class="fs--1 text-600" href="{{ route('home') }}">Go back to dashboard<span class="d-inline-block ml-1">→</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@include('partials.footer')
