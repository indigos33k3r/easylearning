@if(session()->has('profile_update_status'))
	<div class="alert alert-success">{{session()->get('profile_update_status')}}</div>
@endif         
@if(session()->has('change_password'))
	<div class="alert alert-success">{{session()->get('change_password')}}</div>
@endif  