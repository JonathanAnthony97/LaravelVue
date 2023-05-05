@extends('layouts.app')

@section('content')

<div class="login">
    <div class="wrapper wrapper-login">
        <div class="container container-login animated fadeIn pageLog">
        <h3 class="text-center">Sign In</h3>
            <!--div style="text-align:center">
                <img style="width:200px;height:105px;margin-bottom:5px" src="{{ asset('rep.jpg') }}">
            </div-->
            <div class="login-form">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="form-group @error('email') has-error @enderror">
                        <label for="Email" class="placeholder"><b>{{ __('E-Mail Address') }}</b></label>
                        <input id="Email" name="email" type="email" class="form-control loger" value="{{ old('email') }}" required>
                        @error('email')
                            <small class="form-text text-muted text-danger">&nbsp;{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group @error('password') has-error @enderror">
                        <label for="password" class="placeholder"><b>{{ __('Password') }}</b></label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" style="color:#3472c3" class="link float-right">
                                {{ __('Forgot Your Password ?') }}
                            </a>
                        @endif
                        
                        <div class="position-relative">
                            <input id="password" name="password" type="password" class="form-control loger" required autocomplete="current-password">
                            <div class="show-password">
                                <i class="flaticon-interface"></i>
                            </div>
                        </div>
                        @error('password')
                            <small class="form-text text-muted text-danger">&nbsp;{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group form-action-d-flex mb-3" style="margin-top:15px !important">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="custom-control-label m-0" for="remember">{{ __('Remember Me') }}</label>
                        </div>
                        <button type="submit" id="submiter" class="btn btn-sm btn-primary col-md-5 float-right mt-3 mt-sm-0 fw-bold">{{ __('Login') }}</button>
                    </div>
                </form>

                <div class="login-account">
                    <span class="msg">Don't have an account yet ? </span>
                    <a href="{{ route('register') }}" id="show-signup" style="color:#3472c3" class="link">Sign Up</a>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
