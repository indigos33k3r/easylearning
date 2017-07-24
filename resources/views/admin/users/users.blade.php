@extends('admin.layouts.app')

@section('content')
	<div class="row">
		<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
			<h1 class="page-title txt-color-blueDark">
				<i class="fa fa-table fa-fw "></i> 
					Customers 
				<span>> 
					All
				</span>
			</h1>
		</div>
	</div>
					
	<!-- widget grid -->
	<section id="widget-grid" class="">
		<!-- row -->
		<div class="row">

		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<h2>Customers </h2>
				</header>

				<div>

					<div class="jarviswidget-editbox">
						<!-- This area used as dropdown edit box -->

					</div>
					<div class="widget-body no-padding">
						<table id="usersTable" class="table table-striped table-bordered table-hover" width="100%">
							<thead>
								<tr>
									<th data-hide="phone">Id</th>
									<th>Name</th>
									<th>Email</th>
									<th>Phone</th>
									<th data-hide="phone">Created at</th>
								</tr>
							</thead>
							
							<tbody>
								
							@foreach ($users as $user)
								<tr>
									<td>{{$user->id}}</td>
									<td>{{$user->name}}</td>
									<td>{{$user->email}}</td>
									<td>{{$user->phone}}</td>
									<td>{{$user->created_at}}</td>
								</tr>
							@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</article>
	</div>
@endsection
