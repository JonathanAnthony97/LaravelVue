@extends('layouts.app')

@section('content')


<div class="login">
    <div class="wrapper wrapper-login">
        <div class="container container-login animated fadeIn pageLog">
			<h3 class="text-center">{{ __('Reset Password') }}</h3>
			<div class="login-form">
                <form method="POST" action="{{ route('password.email') }}">
                @csrf
                    <div class="form-group @error('email') has-error @enderror">
                        <label for="email" class="placeholder"><b>{{ __('E-Mail Address') }}</b></label>
                        <input id="email" class="form-control loger" name="email" type="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <small class="form-text text-muted text-danger">&nbsp;{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="row form-action">
                        <div class="col-md-4">
                            <a href="{{ route('login') }}" id="show-signin" class="btn btn-danger btn-link w-100 fw-bold">Cancel</a>
                        </div>
                        <div class="col-md-8">
                            <button type="submit" id="submiter" class="btn btn-sm btn-primary w-100 fw-bold">{{ __('Send Password Reset Link') }}</button>
                        </div>
                    </div>
                </form>
				
			</div>
		</div>
    </div>
</div>
@endsection
