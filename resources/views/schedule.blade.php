@extends('layouts.app')

@section('content')
<section class="main-container content min-height" style="position: relative;">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div id="calendar"></div>
			</div>
		</div>
	</div>
</section>

<div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form id="addEventForm" class="form-horizontal">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Add Event</h4>
				</div>
				<div class="modal-body">

					<div class="form-group col-xs-12">
						<label for="title" class="col-sm-3 control-label">Title</label>
						<div class="col-sm-9">
							<input type="text" name="title" class="form-control" id="title" placeholder="Title">
						</div>
					</div>
					<div class="form-group col-xs-12">
						<label for="start" class="col-sm-3 control-label">Start date</label>
						<div class="col-sm-9">
							<div class='input-group date col-sm-12' id='start'>
			                    <input type='text' class="form-control" name="start" />
			                    <span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
			                </div>
		                </div>
						
					</div>
					<div class="form-group col-xs-12" style="margin-bottom:15px">
						<label for="title" class="col-sm-3 control-label">Duration</label>
						<div class="col-sm-9">
							<input type="number" name="duration" class="form-control" id="duration" placeholder="Duration">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save changes</button>
				</div>
				<input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
			</form>
		</div>
	</div>
</div>


<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form class="form-horizontal" method="POST" action="editEventTitle.php">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Edit Event</h4>
				</div>
				<div class="modal-body">

					<div class="form-group">
						<label for="title" class="col-sm-2 control-label">Title</label>
						<div class="col-sm-10">
							<input type="text" name="title" class="form-control" id="title" placeholder="Title">
						</div>
					</div>
					<div class="form-group">
						<label for="color" class="col-sm-2 control-label">Color</label>
						<div class="col-sm-10">
							<select name="color" class="form-control" id="color">
								<option value="">Choose</option>
								<option style="color:#0071c5;" value="#0071c5">&#9724; Dark blue</option>
								<option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquoise</option>
								<option style="color:#008000;" value="#008000">&#9724; Green</option>						  
								<option style="color:#FFD700;" value="#FFD700">&#9724; Yellow</option>
								<option style="color:#FF8C00;" value="#FF8C00">&#9724; Orange</option>
								<option style="color:#FF0000;" value="#FF0000">&#9724; Red</option>
								<option style="color:#000;" value="#000">&#9724; Black</option>

							</select>
						</div>
					</div>
					<div class="form-group"> 
						<div class="col-sm-offset-2 col-sm-10">
							<div class="checkbox">
								<label class="text-danger"><input type="checkbox"  name="delete"> Delete event</label>
							</div>
						</div>
					</div>

					<input type="hidden" name="id" class="form-control" id="id">


				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save changes</button>
				</div>
			</form>
		</div>
	</div>
</div>
	
@endsection