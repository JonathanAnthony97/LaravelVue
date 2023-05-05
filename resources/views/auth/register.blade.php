@extends('layouts.app')

@section('content')

<div class="login">
    <div class="wrapper wrapper-login">
        <div class="container container-login animated fadeIn">
			<h3 class="text-center">Sign Up</h3>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <div class="form-group @error('name') has-error @enderror">
                    <label for="name" class="placeholder"><b>Name</b></label>
                    <input id="name" type="text" class="form-control loger" name="name" value="{{ old('name') }}" required autocomplete="name">
                    @error('name')
                        <small class="form-text text-muted text-danger">&nbsp;{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group @error('email') has-error @enderror">
                    <label for="email" class="placeholder"><b>Email</b></label>
                    <input id="email" type="email" class="form-control loger" name="email" value="{{ old('email') }}" required autocomplete="email">
                    @error('email')
                        <small class="form-text text-muted text-danger">&nbsp;{{ $message }}</small>
                    @enderror 
                </div>
                    
                    <div class="form-group @error('password') has-error @enderror">
                        <label for="password" class="placeholder"><b>Password</b></label>
                        <div class="position-relative">
                        <input id="password" type="password" class="form-control loger" name="password" required autocomplete="new-password">
                            <div class="show-password">
                                <i class="flaticon-interface"></i>
                            </div> 
                        </div>
                        @error('password')
                            <small class="form-text text-muted text-danger">&nbsp;{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password-confirm" class="placeholder"><b>Confirm Password</b></label>
                        <div class="position-relative">
                            <input id="password-confirm" type="password" class="form-control loger" name="password_confirmation" required autocomplete="new-password">
                            <div class="show-password">
                                <i class="flaticon-interface"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row form-action">
                        <div class="col-md-6">
                            <a href="{{ route('login') }}" id="show-signin" class="btn btn-danger btn-link w-100 fw-bold">Cancel</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" id="submiter" class="btn btn-sm btn-primary w-100 fw-bold">{{ __('Register') }}</button>
                        </div>
                    </div>
                </form>
		</div>
    </div>
<div>
@endsection
