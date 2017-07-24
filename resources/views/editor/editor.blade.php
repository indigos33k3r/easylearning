@extends('layouts.editor')

@section('content')

<div class="col-sm-12" id="editorContainer">
	@include('editor.leftSidebar')
	<div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 workbench">
		<div id="canvas-div" class="editorWorkspace">
			<canvas id="canvasHelp" class="hidden" width="400" height="300"></canvas>
		</div>
	</div>
	@include('editor.rightSidebar', ['fonts' => $fonts])
</div>

@endsection
