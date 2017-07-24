@extends('admin.layouts.app')
@section('content')
<div id="templatesList">	
	<div class="row">
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-5">
			<h1 class="page-title txt-color-blueDark">
				<i class="fa fa-table fa-fw "></i> 
					Templates
					<span>> 
						All
					</span>
			</h1>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-offset-2 col-lg-5 template-buttons-container">
			<div class="pull-right">
				<a href="{{url('/')}}/admin/templates/create" class="btn btn-default pull-right" style="font-size: 17px">Add New Template</a>
					
			</div>
		</div>
	</div>

	<section id="widget-grid" class="">
		<!-- row -->
		<div class="row">

			<!-- NEW WIDGET START -->
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

				<!-- Widget ID (each widget will need unique ID)-->
				<div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
					<header>
						<span class="widget-icon"> <i class="fa fa-table"></i> </span>
						<h2>Templates List</h2>
					</header>

					<div>

						<div class="jarviswidget-editbox">
							<!-- This area used as dropdown edit box -->

						</div>
						<div class="widget-body no-padding">
							<table id="templatesTable" class="table table-striped table-bordered table-hover" width="100%">
								<thead >
									<th>Id</th>
									<th>Name</th>
									<th>Preview</th>
									<th>Action</th>
								</thead>
								<tbody>
									@foreach ($templates as $template)
									<tr>
										<td>{{$template->id}}</td>
										<td><a>{{$template->name}}</a></td>
										<td class="text-center image-preview">
											<img src="{{url('/').Storage::url('public/templates/' . $template->id . '.png')}}" />
										</td>
										<td class="text-center">
											<a href="{{url('/')}}/admin/templates/{{$template->id}}/edit" class="btn btn-info btn-xs pull-left" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
											
											<form id="deleteTemplateForm-{{$template->id}}" action="{{url('/').'/admin/templates/'.$template->id}}" method="post" class="">
												{{csrf_field()}}
												{{method_field('DELETE')}}
												<a  class="btn btn-danger btn-xs" onclick="showDeleteModal({{'"'.$template->name.'"' }}, {{$template->id}})" data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>
											</form>	
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</article>
		</div>
	</section>
</div>

<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
			</div>
			<div class="modal-body">
				<p>Are you sure you want to delete the template: <b id="templateName"></b>?</p>
				<input id="templateId" type="hidden" name="template_id">
			</div>
			<div class="modal-footer">
				<button id="deleteTemplateConfirmed" class="btn btn-sm btn-primary">Ok</button>
				<button type="button" data-dismiss="modal" class="btn btn-sm btn-default">Cancel</button>
				
					
			</div>
		</div>
	</div>
</div> 
@endsection