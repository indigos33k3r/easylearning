@extends('layouts.app')

@section('content')
<section class="main-container content min-height">
<div class="container">
    <div class="row">
        @if ($token !== "expired")
        <div class="main object-non-visible" data-animation-effect="fadeInDownSmall" data-effect-delay="300">
            <div class="form-block center-block">
                <h2 class="title">Reset Password</h2>
                <hr>                
                <form id="reset-password-form" class="form-horizontal" role="form">
                    {{ csrf_field() }}
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input id="email" type="hidden" class="form-control" name="email" value="{{ $email }}">
                    <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-4 control-label">Password</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="password" required>
							<i class="fa fa-lock form-control-feedback"></i>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
								<i class="fa fa-lock form-control-feedback"></i>
                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Reset Password
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @else
			<div class="main object-non-visible animated object-visible fadeInDownSmall" data-animation-effect="fadeInDownSmall" data-effect-delay="300">
			    <div class="form-block center-block">
			        <h2 class="title">Link expired</h2>
			        <hr>                   
					<div>
						The link for reseting the password has expired. Please request another link if you wish to reset your password.
					</div>
			    	<div>
			    		<a href="{{url('/')}}/password/reset" class="btn btn-default">Request another link</a>
			    	</div>
			    </div>
			</div>
        @endif
    </div>    
</div>
</section>

<div class="modal fade" id="reset-success" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Password reset</h4>
			</div>
			<div class="modal-body">
				<p>Your password has been successfully reset.</p>
			</div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn btn-sm btn-default">Go to login</button>
			</div>
		</div>
	</div>
</div> 
@endsection
