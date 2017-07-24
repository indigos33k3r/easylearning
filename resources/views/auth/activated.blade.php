@extends ('layouts.app')

@section ('content')
<div class="modal fade" id="accountActivated" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Account activated</h4>
			</div>
			<div class="modal-body">
				<p>Your account has been succesfully activated.</p>
				<p class="small">Note: You are now able to login</p>
			</div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn btn-sm btn-default">Ok</button>
			</div>
		</div>
	</div>
</div>    

@endsection