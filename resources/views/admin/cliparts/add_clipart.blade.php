@extends('admin.layouts.app')

@section('content')
<div class="row">
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
		<h1 class="page-title txt-color-blueDark">
			<i class="fa fa-table fa-fw "></i> 
				Clip Art
			<span>&nbsp;>&nbsp;Add Clip Art</span>
		</h1>
		<a href="{{url('/')}}/admin/cliparts" class="h5"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
	</div>
	<div class="pull-left go-back">
		
	</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-8 col-lg-6 col-lg-push-3 col-md-push-2 single-box-page">
	<div class="well no-padding">
		<form id="@yield('formId','addClipartForm')" class="smart-form client-form" novalidate="novalidate">
			{{csrf_field()}}
			@yield('requestType')
			@if(isset($clipart))
				<input id="clipart-id" type="hidden" value="{{$clipart->id}}" name="clipart_id">
			@endif
			<header>
				@yield('formTitle', 'Add a New Clip Art')
			</header>

			<fieldset>
				<section class="" style="display: inline-block; width: 100%">
					<label class="label col-sm-4 col-xs-6">Clip Art Image(s)<span class="text-danger bold" style="padding-left: 2px"><strong>*</strong></span></label>
					<label class="input col-xs-6"> <i class="icon-append fa fa-file-image-o"></i>
						<input type="text" name="image" id="image" placeholder="Choose file..." style="cursor:pointer;" onkeydown="return false" value="@yield('fileName')">
						<label id="chooseFileError" class="ajax-error hidden">You must choose a file to upload.</label>


						{{-- <b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> Enter your new password</b>  --}}
					</label>
				</section>
				<section class="" style="display: inline-block; width: 100%">
					<label class="label col-sm-4 col-xs-6">Active</label>
					<label class="toggle custom-toggle input col-sm-8 col-xs-7">
						@if (isset($clipart))
							<input type="checkbox" name="active" @if ($clipart->active == 1) {{"checked"}} @endif>
						@else
							<input type="checkbox" name="active" checked="checked">
						@endif
						<i data-swchon-text="Yes" data-swchoff-text="No"></i></label>
				</section>
				<section class="" style="display: inline-block; width: 100%">
					<div id="preview-template" class="hidden" style="padding: 15px 0px">
					</div>						
					@if(isset($clipart))
						<div id="edit-preview" class="dz-preview dz-file-preview" style="width: 20%">
							<div class="dz-details">
								<div class="dz-image">
									<img data-dz-thumbnail class="custom-file-preview"  src="{{url('/').Storage::url($clipart->image_path)}}" style="width: 100%" />
								</div>
								<div class="dz-filename"><span data-dz-name></span></div>	
								<div class="dz-size" data-dz-size></div>

							</div>
						</div>
					@endif
				</section>
			</fieldset>
			<footer>
				<button type="button" onclick="remoteValidation()" class="btn btn-primary">
					@yield('editButton', 'Save')
				</button>
				
			</footer>
		</form>
	</div>
</div>
<div class="modal fade" id="clipart-added" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">@yield('successModalTitle')</h4>
			</div>
			<div class="modal-body">
				<p>
					@yield('successModalText', 'The item has been successfully added.')
				</p>
			</div>
			<div class="modal-footer">
				@if(isset($clipart))
					<button type="button" data-dismiss="modal" class="btn btn-sm btn-primary">Ok</button>
				@else
					<button type="button" data-dismiss="modal" class="btn btn-sm btn-primary">Add another one</button>
				@endif
				<a href="{{url('/')}}/admin/cliparts" class="btn btn-sm btn-default">Cliparts list</a>
				
			</div>
		</div>
	</div>
</div> 
<div class="modal fade" id="clipart-add-error" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Error encountered</h4>
			</div>
			<div class="modal-body">
				<p>An error has been encountered while trying to save the new item. Please refresh the page and try again.</p>
			</div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn btn-sm btn-primary">Try again</button>
				<a href="{{url('/')}}/admin/cliparts" class="btn btn-sm btn-default">Clip Arts list</a>
				
			</div>
		</div>
	</div>
</div> 
@endsection