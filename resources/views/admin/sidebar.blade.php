<aside id="left-panel">

	<!-- User info -->
	<div class="login-info">
		<span> <!-- User image size is adjusted inside CSS, it should stay as it --> 
			
			<a href="{{url('/')}}/admin/profile" class="dropdown dropdown-toggle" data-toggle="dropdwon">
				<img src="{{url('/')}}/external/smartadmin/img/avatars/sunny.png" alt="me" class="online" /> 
				<span style="text-transform: inherit;">
					{{Auth::guard('admins')->user()->email}}
				</span>
				<i class="fa fa-angle-down"></i>
			</a>
		</span>
	</div>
	<!-- end user info -->

	<!-- NAVIGATION : This navigation is also responsive-->
	<nav>
		<ul>
			<li id="menu-customers">
				<a href="{{url('/')}}/admin/customers"><i class="fa fa-lg fa-fw fa-user"></i> <span class="menu-item-parent">Users</span></a>
			</li>
			<li id="menu-templates">
				<a href="{{url('/')}}/admin/templates"><i class="fa fa-lg fa-fw fa-list"></i> <span class="menu-item-parent">Templates</span></a>
			</li>
			<li id="menu-cliparts">
				<a href="{{url('/')}}/admin/cliparts"><i class="fa fa-lg fa-fw fa-file-image-o"></i> <span class="menu-item-parent">Cliparts</span></a>
			</li>
			<li id="menu-shapes">
				<a href="{{url('/')}}/admin/shapes"><i class="fa fa-lg fa-fw fa-star-o"></i> <span class="menu-item-parent">Shapes</span></a>
			</li>
		</ul>
	</nav>
	

	<span class="minifyme" data-action="minifyMenu"> 
		<i class="fa fa-arrow-circle-left hit"></i> 
	</span>

</aside>