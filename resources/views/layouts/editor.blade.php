<!DOCTYPE html>
<html lang="en">
<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>{{ config('app.name', 'Laravel') }}</title>

		<!-- Styles -->
{{--     <link href="{{ url('/') }}/external/theme/fonts/font-awesome/css/font-awesome.css" rel="stylesheet">
		<link href="{{ URL::asset('css/bootstrap.min.css')}}" rel="stylesheet"> --}}
		<link href="{{ url('/') }}/external/smartadmin/css/bootstrap.min.css" rel="stylesheet">
		<link href="{{ url('/') }}/external/smartadmin/css/font-awesome.min.css" rel="stylesheet">
		<link href="{{ url('/') }}/external/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet">
		<link href="{{ URL::asset('css/spectrum.css')}}" rel="stylesheet">
		<link href="{{ url('/') }}/external/jplist/css/jplist.core.min.css" rel="stylesheet">
		<link href="{{ url('/') }}/external/jplist/css/jplist.textbox-filter.min.css" rel="stylesheet" rel="stylesheet">
		<link href="{{ url('/') }}/external/jplist/css/jplist.filter-toggle-bundle.min.css" rel="stylesheet" rel="stylesheet">
		<link href="{{ url('/') }}/css/editor.css" rel="stylesheet" rel="stylesheet">
		<link href="{{ url('/') }}/css/getMediaElement.css" rel="stylesheet" rel="stylesheet">

		<!-- Scripts -->
		<script>
				window.Laravel = <?php echo json_encode([
						'csrfToken' => csrf_token(),
				]); ?>
		</script>

		<!-- Theme CSS files -->
		@if (isset($styleSheets))
				@foreach ($styleSheets as $sheet)
						<link href="{{ URL::asset($sheet)}}" rel="stylesheet">
				@endforeach
		@endif
</head>
<body class="front no-trans full-height editor">
		<div id="app" class="page-wrapper" > 
				@include('editor.menu')
				@yield('content')   
		</div>
		<script>
			var project = {};
			var userId = null;
			var user = null;
			var eventId;
		</script>
		@if (Auth::user()) 
			<script>
				userId = "{{Auth::user()->id}}";
				user =  <?php echo Auth::user(); ?>;
			</script>
		@elseif (Auth::guard('admins')->user())
			<script>
				userId = "{{Auth::guard('admins')->user()->id}}";
				user =  <?php echo Auth::guard('admins')->user(); ?>;
			</script>
		@endif
		@if (isset($eventId)) 
			<script> 
				eventId = "{{$eventId}}";
		 	</script>
		@endif
		@if (! isset($projectType)) 
			<?php $projectType = "project" ?>
		@endif
	 	<script> 
				BASE_URL = "{{url('/')}}";
				PROJECT_TYPE 	= "{{$projectType}}";
		 </script>
	 	@if (isset($project))
			<script>
				var project =  <?php echo $project; ?>;
			</script>
		@endif
		

	<!-- JavaScript files placed at the end of the document so the pages load faster
	================================================== -->
	<!-- Jquery and Bootstrap core js files -->
	<script type="text/javascript" src="{{ url('/') }}/external/theme/plugins/jquery.min.js"></script>
	<script type="text/javascript" src="{{ url('/') }}/external/theme/plugins/jquery-ui/jquery-ui.min.js"></script>
	<script type="text/javascript" src="{{ url('/') }}/external/theme/plugins/jquery.validate.js"></script>
	<script src="https://rtcmulticonnection.herokuapp.com/dist/RTCMultiConnection.min.js"></script>
	<script src="https://rtcmulticonnection.herokuapp.com/socket.io/socket.io.js"></script>
	<script type="text/javascript" src="{{ url('/') }}/js/getMediaElement.js"></script>
	<script type="text/javascript" src="{{ url('/') }}/js/RTCMultiConnection.min.js"></script>
	<script type="text/javascript" src="{{ url('/') }}/js/editor/publishSubscribe.js"></script>
	<script type="text/javascript" src="{{ url('/') }}/js/editor/fabric.js"></script>
	<script type="text/javascript" src="{{ url('/') }}/js/editor/helper.js"></script>
	<script type="text/javascript" src="{{ url('/') }}/js/editor/colorpicker.js"></script>
	<script type="text/javascript" src="{{ url('/') }}/js/editor/canvasDrawing.js"></script>
	<script type="text/javascript" src="{{ url('/') }}/js/editor/editorMenu.js"></script>
	<script type="text/javascript" src="{{ url('/') }}/js/editor/editorStyles.js"></script>
	<script type="text/javascript" src="{{ url('/') }}/js/editor/editorLeftBar.js"></script>
	<script type="text/javascript" src="{{ url('/') }}/js/editor/editor-ui.js"></script>
	<script type="text/javascript" src="{{ url('/') }}/js/editor/editor.js"></script>
	<script src="{{ url('/') }}/external/smartadmin/js/bootstrap/bootstrap.min.js"></script>
	<script src="{{ url('/') }}/external/bootstrap-select/js/bootstrap-select.min.js"></script>
	{{-- <script type="text/javascript" src="{{ URL::asset('js/bootstrap.min.js')}}"></script> --}}
	<script type="text/javascript" src="{{ url('/') }}/external/theme/plugins/spectrum.js"></script>
	<script type="text/javascript" src="{{ url('/') }}/external/theme/plugins/colorpicker/w3color.js"></script>
	<script type="text/javascript" src="{{ url('/') }}/external/jplist/js/jplist.core.min.js"></script>
	<script type="text/javascript" src="{{ url('/') }}/external/jplist/js/jplist.textbox-filter.min.js"></script>
	<script type="text/javascript" src="{{ url('/') }}/external/jplist/js/jplist.filter-toggle-bundle.min.js"></script>
	<script type="text/javascript" src="{{ url('/') }}/external/jplist/js/jplist.bootstrap-filter-dropdown.min.js"></script>
	{{-- <script type="text/javascript" src="{{ url('/') }}/external/socket.io-client/socket.io.js"></script> --}}
	<script type="text/javascript" src="{{ url('/') }}/js/live.js"></script>

	@if (isset($scripts))
			@foreach ($scripts as $script)
					<script src="{{ URL::asset($script)}}"></script>
			@endforeach
	@endif

	<!-- Modal -->
	<div class="modal fade" id="saveProjectModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog ">
			<form id="saveProjectForm" class="smart-form client-form">
					<div class="modal-content modalContent">
						<div class="modal-header modalHeader">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<h4 class="modal-title" id="myModalLabel">Save</h4>
						</div>
						<div class="modal-body modalBody">
							{{ csrf_field() }}
							<fieldset>
								<section>
									<label class="label">Name</label>
									<label class="input custom-input"></label>
									<input type="text" class="projectInput" name="projectName">
								</section>
							</fieldset>
						</div>
						<div class="modal-footer modalFooter">
							<button type="button" class="btn btn-sm btn-dark closeBtn" data-dismiss="modal">Cancel</button>
							<input type="submit" class="btn btn-sm btn-default saveBtn" value="SAVE">
						</div>
					</div>
			</form>
		</div>
	</div>

	<div class="modal fade" id="saveTemplateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<form id="saveTemplateForm" class="smart-form client-form">
				<div class="modal-content modalContent">
					<div class="modal-header modalHeader">
						<button type="button" class="close" data-dismiss="modal">
							<span aria-hidden="true">&times;</span>
							<span class="sr-only">Close</span>
						</button>
						<h4 class="modal-title" id="myModalLabel">Save</h4>
					</div>
					<div class="modal-body modalBody">
						{{ csrf_field() }}
						<fieldset>
							<section>
								<label class="label">Name</label>
								<label class="input custom-input"></label>
								<input type="text" class="projectInput" name="templateName">
							</section>
						</fieldset>
					</div>
					<div class="modal-footer modalFooter">
						<button type="button" class="btn btn-sm btn-dark closeBtn" data-dismiss="modal">Cancel</button>
						<input type="submit" class="btn btn-sm btn-default saveBtn" value="SAVE">
					</div>
				</div>
			</form>
		</div>
	</div>

	<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content modalContent">
				<div class="modal-header modalHeader">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
					</button>
					<h4 class="modal-title title" id="myModalLabel2">Save</h4>
				</div>
				<div class="modal-body modalBody modalBody-info">
					<label class="label message"></label>	                      
				</div>
				<div class="modal-footer modalFooter">
					<input type="button" class="btn btn-sm btn-default btn-ok saveBtn" data-dismiss="modal" value="OK">
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="clearCanvasModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content modalContent">
				<div class="modal-header modalHeader">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
					</button>
					<h4 class="modal-title" id="myModalLabel">CLEAR PROJECT</h4>
				</div>
				<div class="modal-body modalBody">
					<fieldset>
						<section>
							<label class="label message">Do you really want to reload the project?</label>
						</section>
					</fieldset>
				</div>
				<div class="modal-footer modalFooter">
					<button type="button" class="btn btn-sm btn-dark closeBtn" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-sm btn-default btn-ok saveBtn" data-dismiss="modal">OK</button>
				</div>
			</div>
		</div>
	</div>
	<input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
</body>
</html>
