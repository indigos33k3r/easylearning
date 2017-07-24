<div class="col-sm-2 col-md-2 col-lg-2 col-xl-2 workbench-leftComponents" id="workbench-leftComponentsID">
	 <div class="btn-group colorpickerDiv" role="group">
		<button id="selectedcolor" class="btn colorpickerBtn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			Color 
			<i class="fa fa-chevron-right" id="selectedcolor_ic" aria-hidden="true"></i>
		</button>
		@include('editor.colorpicker')
		<!-- end colorpicker -->
	</div>

	<div class="">
		<div class="categoryLabel">
			<label for="">Shape</label>
		</div>
		<div class="col-xs-4 categoryContentDiv">
			<label for="shapeColor">Fill</label>
			<div class="dropdown">
				<input id='shapeColor' class="sp-choose" />
			</div>
		</div>

		<div class="col-xs-4 categoryContentDiv">
			<label for="shapeStroke">Outline</label>
			<div class="dropdown">
				<input id='shapeStroke' class="sp-choose" />
			</div>
		</div>

		<div class="col-xs-4 categoryContentDiv propertiesDiv">
			<label for="" >Width</label>
			<input type='number' id='lineWidth' class="sp-choose" />
		</div>
	</div>
	<div class="categoryLabel">
		<label for="">Properties</label>
	</div>
	<div class="categoryContent">
		<div class="">
			<div class="col-xs-4 categoryContentDiv propertiesDiv">
				<label for="" id="widthLabel">Width</label>
				<input type='number' id='width' class="sp-choose" />
			</div>

			<div class="col-xs-4 categoryContentDiv propertiesDiv">
				<label for="height">Height</label>
				<input type='number' id='height' class="sp-choose" />
			</div>

			<div class="col-xs-4 categoryContentDiv propertiesDiv">
				<label for="">Rotate</label>
				<input type='number' id='rotation' class="sp-choose" />
			</div>

			<div class="col-xs-4 categoryContentDiv propertiesDiv">
				<label for="positionx">X Position</label>
				<input type='number' id='positionX' class="sp-choose" />
			</div>

			<div class="col-xs-4 categoryContentDiv propertiesDiv">
				<label for="positionY">Y Position</label>
				<input type='number' id='positionY' class="sp-choose" />
			</div>

			<div class="col-xs-4 categoryContentDiv">
				<label for="transparency">Opacity</label>
				<form action="" name="opacityForm"> 
					<div class="minMaxValue">
						<label id="transparencyDecrease" class="signBtn pull-left">0%</label>
						<label id="transparencyIncrease" class="signBtn pull-right">95%</label>
					</div>
					<div class="opacity">
						<div class="handle">
							<div class="bubble-tip rangeTooltip" id="opacityTooltip">
					            <div class="content">
					            	<output name="brushsizeOutput" id="transparencyOutputTooltip">0</output>
					            </div>
					            <div class="bubble-corner"></div>
					        </div>
							<input type="range" 
								   name="brushsize" 
								   min="0" 
								   max="95" 
								   id="transparency" 
								   step="5" value="0" 
								   onchange="this.setAttribute('value',this.value);" 
								   oninput="transparencyOutputTooltip.value = transparency.value + '%'">						
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="containerTxtOpt">
		<div class="col-xs-6 textOptions">
			<div class="categoryLabel-textOptions">
				<label for="">Font</label>
			</div>
			<div>
				<div class="form-group">							
					<select class=" form-control fontOpt fontOpt-selectPicker" onchange="this.nextElementSibling.value=this.value">
						<option>8</option>
						<option>9</option>
						<option>10</option>
						<option>11</option>
						<option>12</option>
						<option>14</option>
						<option>16</option>
						<option>18</option>
						<option>20</option>
						<option>22</option>
						<option>24</option>
						<option>26</option>
						<option>28</option>
						<option>36</option>
						<option>48</option>
						<option>72</option>
					</select>
					<input type="text" name="format" class='fontOpt-selectPicker' id="selectEditable" value="28" />
					
					<div class="fontOpt" >
						<img src="{{url('/')}}/external/theme/icons/Bold-26.png" id="fontWeight" data-value="normal" alt="">
					</div>
					<div class="fontOpt">
						<img src="{{url('/')}}/external/theme/icons/Italic-26.png" id="fontStyle" data-value="normal" alt="">
					</div>
					<div class="fontOpt">
						<img src="{{url('/')}}/external/theme/icons/Underline-48.png" id="textDecoration" data-value="none" alt="">
					</div>
				</div>
			</div>
		</div>

		<div class="col-xs-6 textOptions">
			<div class="categoryLabel-textOptions ">
				<label for="">Paragraph</label>
			</div>
			<div class="">
				<div class="paragraphOpt">
					<img src="{{url('/')}}/external/theme/icons/Align Left-26.png" id="textAlign-left" class="textAlign" data-value="left" alt="">
				</div>
				<div class="paragraphOpt">
					<img src="{{url('/')}}/external/theme/icons/Align Center-26.png" id="textAlign-center" class="textAlign" data-value="center" alt="">
				</div>
				<div class="paragraphOpt">
					<img src="{{url('/')}}/external/theme/icons/Align Right-26.png" id="textAlign-right" class="textAlign" data-value="right" alt="">
				</div>
			</div>
		</div>
	</div>

	<div class="lineSpacingDiv">
		<span>Line spacing</span>
		<form action="" name="opacityForm"> 
			<div class="minMaxValueFull">
				<label id="charSpacingDecrease" class="signBtn pull-left">5%</label>
				<label id="charSpacingIncrease" class="signBtn pull-right">500%</label>
			</div>
			<div class="opacity">
				<div class="handle">
					<div class="bubble-tip rangeTooltip" id="charSpacingTooltip">
			            <div class="content">
			            	<output name="brushsizeOutput" id="charSpacingOutputTooltip">0</output>
			            </div>
			            <div class="bubble-corner"></div>
			        </div>
					<input type="range" 
						   name="brushsize" 
						   min="5" 
						   max="500" 
						   id="charSpacing" 
						   step="5" value="0" 
						   onchange="this.setAttribute('value',this.value);" 
						   oninput="charSpacingOutputTooltip.value = charSpacing.value + '%'">
				</div>
			</div>
		</form>
	</div>

	<div class="hoverOptDiv">
		<input type='checkbox' id='hoverToChangeFont' checked />
		<span for="">Hover over to change fonts</span>
	</div>
	<div class="fontsList">
		<ul class="fontListItems">
			@foreach ($fonts as $font)
			<li class="fontFamily" id="fontFamily-{{$font->name}}" style="font-family: '{{$font->name}}';" data-value="{{$font->name}}">
				<div class="fontDiv">
					<p class="" >{{$font->name}}</p>
				</div>
			</li>
			@endforeach
		</ul>
	</div>
	<script>
		var fonts = [];
	</script>
	@foreach ($fonts as $font)
	<script>
		fonts.push('{{$font->name}}');
	</script>
	@endforeach
</div>