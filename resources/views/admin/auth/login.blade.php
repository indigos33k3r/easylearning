@extends('admin.layouts.app')

@section('content')
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-7 col-lg-8 hidden-xs hidden-sm">
			<h1 class="txt-color-red login-header-big">iClinkn'print</h1>
			<div class="hero">

				<div class="pull-left login-desc-box-l">
					<h4 class="paragraph-header">It's Okay to be Smart. </h4>
					
				</div>
				

			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
			<div class="well no-padding">
				<form id="loginForm" class="smart-form client-form">
					{{ csrf_field() }}
					<header>
						Sign In
					</header>

					<fieldset>
						<section>
							<label class="label">E-mail</label>
							<label class="input custom-input"> <i class="icon-append fa fa-user"></i>
								<input type="email" name="email">
								<b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> Please enter email address/username</b></label>
						</section>

						<section>
							<label class="label">Password</label>
							<label class="input custom-input"> <i class="icon-append fa fa-lock"></i>
								<input type="password" name="password">
								<b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> Enter your password</b> 
								<label id="login-error" class="ajax-error hidden">Wrong email or password</label>
							</label>

							<div class="note">
								<a href="{{url('/')}}/admin/forgotPassword">Forgot password?</a>
							</div>
						</section>

						<section>
							<label class="checkbox">
								<input type="checkbox" name="remember" checked="">
								<i></i>Stay signed in</label>
						</section>
					</fieldset>
					<footer>
						<button type="submit" class="btn btn-primary">
							Sign in
						</button>
					</footer>
				</form>
			</div>
		</div>
	</div>
@endsection
