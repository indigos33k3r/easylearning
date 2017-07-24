@extends('admin.layouts.app')

@section('content')

<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-lg-push-4 col-md-push-3 single-box-page">
	<div class="well no-padding">
		<form id="resetPasswordForm" class="smart-form client-form">
			{{ csrf_field() }}
			<input type="hidden" name="email" value="{{$user->email}}">
			<header>
				Change password
			</header>

			<fieldset>
				<section>
					<label class="label">New Password</label>
					<label class="input"> <i class="icon-append fa fa-lock"></i>
						<input type="password" name="password" id="password">
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
@endsection
