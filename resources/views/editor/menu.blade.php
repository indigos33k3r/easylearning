<div class="col-sm-1 menuBar" id="menuBarID">
	<div class="col-sm-11 menuBar-left">
		<img src="{{url('/')}}/images/logo.png" height="50px" style="vertical-align: top">
		<div class="tools modifyContent">
			<ul>
				<li style="">
					<div class="btn-group dropdown groupBtn">
						<button id="drawing" class="btn btn-secondary toolBtn pencilDrawing">
							<div class="toolImgDiv">
								<img src="{{url('/')}}/external/theme/icons/ic_pencil.png" alt="">
							</div>
						  	<p class="toolBtnName">Pencil</p>
						</button>
						<button type="button" class="btn btn-lg btn-secondary dropdown-toggle dropdown-toggle-split optionsDropDown" id="pencilArrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
	    					<i class="fa fa-chevron-right"></i>
	  					</button>
						<div class="dropdown-menu lineDropDown">
						    <ul id="drawing-mode-selector" class="lineOptions">
						    	<li>
						    		<span for="">Width</span>
						    		<input id="drawingWidth" type="number" class="lineWidthInput">	
						    	</li>
						    	<li data-value="Pencil">
						    		<img src="{{url('/')}}/external/theme/icons/defaultLine.png" class="lineIcon" alt="">
						    	</li>
						    	<li data-value="hline">
						    		<img src="{{url('/')}}/external/theme/icons/HLine.png" class="lineIcon" alt="">
						    	</li>
						    	<li  data-value="vline">
						    		<img src="{{url('/')}}/external/theme/icons/VLine.png" class="lineIcon" alt="">
						    	</li>
						    	<li  data-value="square">
						    		<img src="{{url('/')}}/external/theme/icons/squareLine.png" class="lineIcon" alt="">
						    	</li>
						    	<li  data-value="diamond">
						    		<img src="{{url('/')}}/external/theme/icons/diamondLine.png" class="lineIcon" alt="">
						    	</li>
						    	<li  data-value="texture">
						    		<img src="{{url('/')}}/external/theme/icons/textureLine.png" class="lineIcon" alt="">
						    	</li>
						    </ul>
						 </div>
					 </div>
				</li>
				<li>
					<button id="history" class="toolBtn">
						<div class="toolImgDiv">
							<img src="{{url('/')}}/external/theme/icons/ic_reload.png" alt="">
						</div>
					  	<p class="toolBtnName">Clear History</p>
					</button>
				</li>
				
				<li>
					<button id="undo" class="toolBtn">
						<div class="toolImgDiv">
							<img src="{{url('/')}}/external/theme/icons/ic_undo.png" alt="">							
						</div>
					  	<p class="toolBtnName">Undo</p>
					</button>
				</li>
				<li>
					<button id="redo" class="toolBtn">
						<div class="toolImgDiv">
							<img src="{{url('/')}}/external/theme/icons/ic_redo.png" alt="">							
						</div>
					  	<p class="toolBtnName">Redo</p>
					</button>
				</li>
			</ul>
		</div>
		<div class="tools modifyContent">
			<ul>
				<li>
					<button id="copy" class="toolBtn">
						<div class="toolImgDiv">
							<img src="{{url('/')}}/external/theme/icons/ic_copy.png" alt="">							
						</div>
					  	<p class="toolBtnName">Copy</p>
					</button>
				</li>
				<li>
					<button id="paste" class="toolBtn">
						<div class="toolImgDiv">
							<img src="{{url('/')}}/external/theme/icons/ic_paste.png" alt="">							
						</div>
					  	<p class="toolBtnName">Paste</p>
					</button>
				</li>
				<li>
					<button id="removeSelected" class="toolBtn">
						<div class="toolImgDiv">
							<img src="{{url('/')}}/external/theme/icons/ic_delete.png" alt="">							
						</div>
					  	<p class="toolBtnName">Delete</p>
					</button>
				</li>
			</ul>
		</div>
		<div class="tools YZposition">
			<ul>
				<li>
					<button id="bringForward" class="toolBtn">
						<div class="toolImgDiv">
							<img src="{{url('/')}}/external/theme/icons/ic_forward.png" alt="">							
						</div>
					  	<p class="toolBtnName">Forward</p>
					</button>
				</li>
				<li>
					<button id="sendBackwards" class="toolBtn">
						<div class="toolImgDiv">
							<img src="{{url('/')}}/external/theme/icons/ic_backward.png" alt="">						
						</div>
					  	<p class="toolBtnName">Backward</p>
					</button>
				</li>
				<li>
					<button id="viewMirror" class="toolBtn">
						<div class="toolImgDiv">
							<img src="{{url('/')}}/external/theme/icons/ic_mirror.png" alt="">							
						</div>
					  	<p class="toolBtnName">Mirror</p>
					</button>
				</li>
			</ul>
		</div>
		<div class="tools iconType">
			<ul>
				<li>
					<button class="toolBtn" id="image">
						<div class="toolImgDiv" >
							<img src="{{url('/')}}/external/theme/icons/ic_newPicture.png" alt="">						
						</div>
						<p class="toolBtnName">Image</p>
					</button>
					<input type="file" class="hidden" id="fileImage">
				</li>
				<li>
					<button class="toolBtn" id="cliparts">
						<div class="toolImgDiv">
							<img src="{{url('/')}}/external/theme/icons/ic_cliparts.png" alt="">
						</div>
					  	<p class="toolBtnName">Cliparts</p>
					</button>
				</li>
				<li>
					<button class="toolBtn" id="templates">
						<div class="toolImgDiv">
							<img src="{{url('/')}}/external/theme/icons/ic_templates.png" alt="">
						</div>
					  	<p class="toolBtnName">Templates</p>
					</button>
				</li>
				<li>
					<button class="toolBtn" id="shapes">
						<div class="toolImgDiv">
							<img src="{{url('/')}}/external/theme/icons/ic_shapes.png" alt="">
						</div>
					  	<p class="toolBtnName">Shapes</p>
					</button>
				</li>
			</ul>
		</div>
		<div class="tools textOptions">
			<ul>
				<li>
					<button id="addText" class="toolBtn">
						<div class="toolImgDiv">
							<img src="{{url('/')}}/external/theme/icons/ic_text.png" alt="">							
						</div>
						<p class="toolBtnName">Text</p>
					</button>
				</li>
				<li>
					<button id="save" class="toolBtn">
						<div class="toolImgDiv">
							<img src="{{url('/')}}/external/theme/icons/ic_save.png" alt="">							
						</div>
						<p class="toolBtnName">Save</p>
					</button>
				</li>
				<li>
					<button id="clearCanvas" class="toolBtn">
						<div class="toolImgDiv">
							<img src="{{url('/')}}/external/theme/icons/ic_reload.png" alt="">							
						</div>
						<p class="toolBtnName">Clear</p>
					</button>
				</li>
			</ul>
		</div>
	</div>
	<div class="col-sm-1 menuBar-right">
		<div class="tools refresh">
			<ul>
				<li>
					<button id="clearCanvas" class="toolBtn">
						<div class="toolImgDiv">
							<img src="{{url('/')}}/external/theme/icons/ic_reload.png" alt="">							
						</div>
						<p class="toolBtnName">Logout</p>
					</button>
				</li>
			</ul>
		</div>
	</div>
</div>

<div class="modal fade" id="templatesModal" role="dialog">
	<div id="templatesSection" class="modal-dialog templateDialog">
		<div class="modal-content jplist-panel">
			<div class="modal-header templatesDialogHeader">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Use Template</h4>
			</div>
			<div class="modal-body">
				<div class="upContainer row">
					<div class="searchDiv col-xs-12">
						<div class="text-filter-box input-group searchContainer pull-right">							
				            <input 
				            	class="form-control"
					            data-path=".templateName" 
					            type="text" 
					            value="" 
					            placeholder="Search" 
					            data-control-type="textbox" 
					            data-control-name="title-filter" 
					            data-control-action="filter"
				            />
				            <span class="input-group-addon" id="sizing-addon3">
								<i class="fa fa-search  searchIcon"></i>
							</span>	
				        </div>													
					</div>		
				</div>
	  			<div class="contentContainer row">
					<div class="productsByCategory centerDiv col-sm-12 col-md-12 col-xl-12 col-lg-12">
						<ul class="productsList listItems">
							<div class="list">
								@foreach ($templates as $template)
									<li class="productItem list-item">
										<div class="productItemContainer">
											<div class="projectItemInnerContainer">
												<div class="imgDiv centerDiv">					
													<img src="{{asset('storage/templates/' . $template->id . ".png")}}" class="productImg" alt="" />
												</div>
												<div class="centerDiv">
													<h5 class="templateName" >{{$template->name}}</h5>
												</div>
												<button data-template-id="{{$template->id}}" class="useTemplate gridBtn">Use</button>					
											</div>
										</div>					
									</li>
								@endforeach
							</div>
							<div class="box jplist-no-results text-shadow align-center jplist-hidden">
							    <p>No results found</p>
						    </div>
						</ul>
					</div>											
				</div>
			</div>
		</div>
	</div>
</div>	<!-- end modal -->

<div class="modal fade" id="shapesModal" role="dialog">
	<div id="templatesSection" class="modal-dialog templateDialog">
		<div class="modal-content jplist-panel">
			<div class="modal-header templatesDialogHeader">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Use Shape</h4>
			</div>
			<div class="modal-body">
				<div class="upContainer row">
					<div class="searchDiv col-xs-12">
						<div class="text-filter-box input-group searchContainer pull-right">							
				            <input 
				            	class="form-control"
					            data-path=".shapeName" 
					            type="text" 
					            value="" 
					            placeholder="Search" 
					            data-control-type="textbox" 
					            data-control-name="title-filter" 
					            data-control-action="filter"
				            />
				            <span class="input-group-addon" id="sizing-addon3">
								<i class="fa fa-search  searchIcon"></i>
							</span>	
				        </div>													
					</div>		
				</div>
	  			<div class="contentContainer row">
					<div class="productsByCategory centerDiv col-sm-12 col-md-12 col-xl-12 col-lg-12">
						<ul class="productsList listItems">
							<div class="list">
								@foreach ($shapes as $shape)
									<li class="productItem list-item">
										<div class="productItemContainer">
											<div class="projectItemInnerContainer">
												<div class="imgDiv centerDiv">					
													<img src="{{asset('storage/shapes/' . $shape->file_name)}}" class="productImg" alt="" />
												</div>
												<div class="centerDiv">
													<h5 class="shapeName" >{{$shape->name}}</h5>
												</div>
												<button data-shape-id="{{$shape->id}}" class="useShape gridBtn">Use</button>					
											</div>
										</div>					
									</li>
								@endforeach
							</div>
							<div class="box jplist-no-results text-shadow align-center jplist-hidden">
							    <p>No results found</p>
						    </div>
						</ul>
					</div>											
				</div>
			</div>
		</div>
	</div>
</div>	<!-- end modal -->							


<div class="modal fade" id="clipartsModal" role="dialog">
	<div id="templatesSection" class="modal-dialog templateDialog">
		<div class="modal-content jplist-panel">
			<div class="modal-header templatesDialogHeader">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Use Clipart</h4>
			</div>
			<div class="modal-body">
				<div class="upContainer row">
					<div class="searchDiv col-xs-12">
						<div class="text-filter-box input-group searchContainer pull-right">							
				            <input 
				            	class="form-control"
					            data-path=".clipartName" 
					            type="text" 
					            value="" 
					            placeholder="Search" 
					            data-control-type="textbox" 
					            data-control-name="title-filter" 
					            data-control-action="filter"
				            />
				            <span class="input-group-addon" id="sizing-addon3">
								<i class="fa fa-search  searchIcon"></i>
							</span>	
				        </div>													
					</div>		
				</div>
	  			<div class="contentContainer row">
					<div class="productsByCategory centerDiv col-sm-12 col-md-12 col-xl-12 col-lg-12">
						<ul class="productsList listItems">
							<div class="list">
								@foreach ($cliparts as $clipart)
									<li class="productItem list-item">
										<div class="productItemContainer">
											<div class="projectItemInnerContainer">
												<div class="imgDiv centerDiv">					
													<img src="{{asset('storage/cliparts/' . $clipart->file_name)}}" class="productImg" alt="" />
												</div>
												<div class="centerDiv">
													<h5 class="clipartName" >{{$clipart->name}}</h5>
												</div>
												<button data-clipart-id="{{$clipart->id}}" class="useClipart gridBtn">Use</button>
											</div>
										</div>					
									</li>
								@endforeach
							</div>
							<div class="box jplist-no-results text-shadow align-center jplist-hidden">
							    <p>No results found</p>
						    </div>
						</ul>
					</div>											
				</div>
			</div>
		</div>
	</div>
</div>	<!-- end modal -->	