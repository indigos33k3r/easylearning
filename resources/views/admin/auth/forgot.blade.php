@extends('admin.layouts.app')

@section('content')

<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-7 col-lg-8 hidden-xs hidden-sm">
		<h1 class="txt-color-red login-header-big">SmartAdmin</h1>
		<div class="hero">

			<div class="pull-left login-desc-box-l">
				<h4 class="paragraph-header">It's Okay to be Smart. Experience the simplicity of SmartAdmin, everywhere you go!</h4>
			</div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
		<div class="well no-padding">
			<form id="resetPasswordForm" class="smart-form client-form">
				{{ csrf_field() }}
				<header>
					Forgot Password
				</header>

				<fieldset>
					
					<section>
						<label class="label">Enter your email address</label>
						<label class="input"> <i class="icon-append fa fa-envelope"></i>
							<input type="email" name="email">
							<b class="tooltip tooltip-top-right"><i class="fa fa-envelope txt-color-teal"></i> Please enter email address for password reset</b></label>
					</section>
					<div id="infoMessage" class="alert alert-info alert-block hidden">
						<a class="close" data-dismiss="alert" href="#">×</a>
						<h4 class="alert-heading">Info!</h4>
						Please access the link received on your email in order to reset your password.
					</div>
					<div id="errorMessage" class="alert alert-block alert-danger hidden">
						<a class="close" data-dismiss="alert" href="#">×</a>
						<h4 class="alert-heading">Error!</h4>
						The email you enter was not found in our database.
					</div>
					<section>
						<div class="note">
							<a href="{{url('/')}}/admin/login">I remembered my password!</a>
						</div>
					</section>

				</fieldset>
				<footer>
					<button type="submit" class="btn btn-primary float-left">
						<i class="fa fa-refresh"></i> Reset Password
					</button>
					<div id="loading-gif" class="loading-gif hidden">
                    	<img src="{{url('/')}}/images/loader.gif" >
                	</div>
					<button type="reset"></button>
				</footer>
			</form>
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
				</div>
				<div class="modal-footer">
					<a href="{{url('/')}}/admin/home" data-dismiss="modal" class="btn btn-sm btn-primary">Ok</a>
				</div>
			</div>
		</div>
	</div>   
@endsection
