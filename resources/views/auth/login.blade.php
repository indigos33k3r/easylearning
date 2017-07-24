@extends('layouts.app')

@section('content')
<section class="main-container content min-height">
    <div class="container">
        <div class="row">
            <!-- main start -->          
            <div class="main object-non-visible" data-animation-effect="fadeInDownSmall" data-effect-delay="300">
                <div class="form-block center-block">
                    <h2 class="title">Login</h2>
                    <hr>
                    <form id="login-form" class="form-horizontal" role="form" >
                        {{ csrf_field() }}
                        <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-sm-3 control-label">E-mail Address</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="email" placeholder="E-mail address" name="email" required autofocus>
                                <i class="fa fa-user form-control-feedback"></i>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-sm-3 control-label">Password</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" id="password" placeholder="Password" name="password" required>
                                <i class="fa fa-lock form-control-feedback"></i>
                                 @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                                <label id="login-error" class="ajax-error hidden">The password or email is not correct</label>
                                <label id="login-unconfirmed" class="ajax-error hidden">The account is not activated</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-8">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Remember me
                                    </label>
                                </div>                                          
                                <button type="submit" class="btn btn-group btn-default btn-sm">Log In</button>
                                <a href="{{ url('/password/reset') }}">
                                    Forgot Your Password?
                                </a> 
                            </div>
                        </div>
                    </form>
                </div>
                <p class="text-center space-top">Don't have an account yet? <a href="{{ url('/register') }}">Sign up</a> now.</p>
            </div>
            <!-- main end -->
        </div>
    </div>
</section>
@endsection
