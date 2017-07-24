@extends('admin.layouts.app')

@section('content')

<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-lg-push-4 col-md-push-3 single-box-page">
	<div class="well no-padding">
		<form id="changePasswordForm" class="smart-form client-form">
			{{ csrf_field() }}
			<header>
				Change password
			</header>

			<fieldset>
				<section>
					<label class="label">Old Password</label>
					<label class="input"> <i class="icon-append fa fa-lock"></i>
						<input type="password" name="oldPassword">
						<b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> Enter your old password</b> </label>
						<label id="errorMessage" class="ajax-error hidden">The old password is not correct</label>
				</section>

				<section>
					<label class="label">New Password</label>
					<label class="input"> <i class="icon-append fa fa-lock"></i>
						<input type="password" name="newPassword" id="newPassword">
						<b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> Enter your new password</b> </label>
				</section>

				<section>
					<label class="label">Confirm Password</label>
					<label class="input"> <i class="icon-append fa fa-lock"></i>
						<input type="password" name="cpassword">
						<b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> Confirm your new password</b> </label>
				</section>
			</fieldset>
			<div id="successMessage" class="alert alert-success alert-block hidden">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading">Info!</h4>
				Password succesfully changed!
			</div>
			<footer>
				<button type="submit" class="btn btn-primary">
					Change
				</button>
				<button type="reset" class="hidden"></button>

			</footer>
		</form>
	</div>
</div>

<div class="modal fade" id="change-success" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
				<button type="button" data-dismiss="modal" class="btn btn-sm btn-primary">Ok</button>
			</div>
		</div>
	</div>
</div> 
@endsection