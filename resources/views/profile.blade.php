@extends('layouts.app')

@section('content')
<section class="main-container content min-height" style="position: relative;">
	<div class="container">
		<div class="row">
			<!-- main start -->  
			<div id = "session-message">
				@include('partials.messages')
			</div>     
			<div id="preview-profile" class="main object-non-visible user-profile" data-animation-effect="fadeInDownSmall" data-effect-delay="300">
				<div  class="form-block center-block" style = "">
					<h2 class="title">Profile Information</h2>
					<hr>
					<div class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
						{{ csrf_field() }}
						<div class="form-group has-feedback {{ $errors->has('name') ? ' has-error' : '' }}">
							<label for="name" class="col-sm-3 col-xs-4 user-profile-label">Name </label>
							<div class="col-sm-8 col-xs-8">
								<div class="user-profile-info" >{{$user['name']}}</div>

								@if ($errors->has('name'))
								<span class="help-block">
									<strong>{{ $errors->first('name') }}</strong>
								</span>
								@endif
							</div>
						</div>                            
						<div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
							<label for="email" class="col-sm-3 col-xs-4 user-profile-label">E-mail Address </label>
							<div class="col-sm-8 col-xs-8">
								<div class="user-profile-info" >{{$user['email']}}</div>
								@if ($errors->has('email'))
								<span class="help-block">
									<strong>{{ $errors->first('email') }}</strong>
								</span>
								@endif
							</div>
						</div>
						<div class="form-group has-feedback {{ $errors->has('phone') ? ' has-error' : '' }}">
							<label for="phone" class="col-sm-3 col-xs-4 user-profile-label">Phone </label>
							<div class="col-sm-8 col-xs-8">
								<div class="user-profile-info" >{{$user['phone']}}</div>
								@if ($errors->has('phone'))
								<span class="help-block">
									<strong>{{ $errors->first('phone') }}</strong>
								</span>
								@endif
							</div>
						</div>
						<div class="form-group with-buttons">
							<div class="col-sm-8 col-xs-6">
								<button  type="" class="btn btn-default action-buttons edit-p">Edit</button>
							</div>
							<div class="col-sm-4 col-xs-6" style="text-align: right">
								<button  type="" class="btn btn-default action-buttons change-p">Change password</button>
							</div>

						</div>
					</div>
				</div>
				</div>
				<div id="edit-profile" class="main object-non-visible user-profile hidden" data-animation-effect="fadeInDownSmall" data-effect-delay="100">
				<div  class="form-block center-block" style = "">
					<h2 class="title">Update Profile Information</h2>
					<hr>
					<form id="update-profile-form" class="form-horizontal " role="form">
						{{ csrf_field() }}
						{{ method_field('PUT')}}
						<div class="form-group has-feedback {{ $errors->has('name') ? ' has-error' : '' }}">
							<label for="name" class="col-sm-3 control-label">Name <span class="text-danger small">*</span></label>
							<div class="col-sm-8">
								<input id="name" type="text" class="form-control" placeholder="Name" name="name" value="{{$user['name']}}" required>

								@if ($errors->has('name'))
								<span class="help-block">
									<strong>{{ $errors->first('name') }}</strong>
								</span>
								@endif
								<i class="fa fa-user form-control-feedback"></i>
							</div>
						</div>               
						<div class="form-group has-feedback {{ $errors->has('name') ? ' has-error' : '' }}">
							<label for="name" class="col-sm-3 control-label">Phone <span class="text-danger small">*</span></label>
							<div class="col-sm-8">
								<input id="name" type="text" class="form-control" placeholder="Phone" name="phone" value="{{$user['phone']}}" required>
								@if ($errors->has('phone'))
								<span class="help-block">
									<strong>{{ $errors->first('phone') }}</strong>
								</span>
								@endif
								<i class="fa fa-phone form-control-feedback"></i>
							</div>
						</div>             
						<div class="form-group with-buttons">
							<div class="col-sm-6 col-xs-6">
								<button type="submit" class="btn btn-default">Update</button>
							</div>
							<div class="col-sm-5 col-xs-6" style="text-align: right">
								<div id="cancel-update" class="btn btn-default action-buttons">Cancel</div>
							</div>
						</div>
						<input id="user-id" type="hidden" name="user_id" value={{Auth::id()}}>
					</form>
				</div>
				</div>
				<div id="change-password" class="main object-non-visible user-profile hidden" data-animation-effect="fadeInDownSmall" data-effect-delay="100">
				<div  class="form-block center-block" style = "">
					<h2 class="title">Change Password</h2>
					<hr>
					<form id="change-password-form" class="form-horizontal " role="form" method="POST" action="{{ url('/profile/update') }}">
						{{ csrf_field() }}
						{{ method_field('PUT')}}
						<div class="form-group has-feedback">
							<label for="opassword" class="col-sm-4 control-label">Old Password <span class="text-danger small">*</span></label>
							<div class="col-sm-7">
								<input id="old-password" type="password" class="form-control" placeholder="Password" name="old_password" value="" required>
								<i class="fa fa-lock form-control-feedback"></i>
								<label id="old-password-error" class="ajax-error hidden">Old Password is not correct</label>
							</div>
						</div>     
						<div class="form-group has-feedback">
							<label for="password" class="col-sm-4 control-label">New Password <span class="text-danger small">*</span></label>
							<div class="col-sm-7">
								<input id="password" type="password" class="form-control" placeholder="Password" name="password" value="" required>
								<i class="fa fa-lock form-control-feedback"></i>
							</div>
						</div>     						
						<div class="form-group has-feedback">
							<label for="name" class="col-sm-4 control-label">Confirm Password <span class="text-danger small">*</span></label>
							<div class="col-sm-7">
								<input id="confirm-password" type="password" class="form-control" placeholder="Confirm password" name="confirm-password" value="" required>
								<i class="fa fa-lock form-control-feedback"></i>
							</div>
						</div>     
                      
						<div class="form-group with-buttons">
							<div class="col-sm-6 col-xs-6">
								<button type="submit" class="btn btn-default">Update</button>
							</div>
							<div class="col-sm-5 col-xs-6" style="text-align: right">
								<div id="cancel-update" class="btn btn-default action-buttons">Cancel</div>
							</div>
						</div>
						<input id="user-id" type="hidden" name="user_id" value={{Auth::id()}}>
					</form>
				</div>		
			</div>
			<!-- main end -->
		</div>
	</div>
</section>

@endsection