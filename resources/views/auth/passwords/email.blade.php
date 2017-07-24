@extends('layouts.app')

<!-- Main Content -->
@section('content')
<section class="main-container content min-height">
    <div class="container">
        <div class="row">
            <div class="main object-non-visible" data-animation-effect="fadeInDownSmall" data-effect-delay="300">
                <div class="form-block center-block">
                    <h2 class="title">Reset Password</h2>
                    <hr>                   
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                        <form id="email-form" class="form-horizontal" role="form" >
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Send Password Reset Link
                                    </button>
                                    <div id="loading-gif" class="loading-gif hidden">
                       					<img src="{{url('/')}}/images/loader.gif" >
                       				</div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<div class="modal fade" id="email-sent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">Email sent</h4>
				</div>
				<div class="modal-body">
					<p>An email containing a link for resetting your paswword has been sent to the provided email address. Please access the link and reset your password.</p>
					<p class="small">Note: The link will expire upon usage</p>
				</div>
				<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn btn-sm btn-default">Ok</button>
				</div>
			</div>
		</div>
	</div>    
</section>
@endsection
