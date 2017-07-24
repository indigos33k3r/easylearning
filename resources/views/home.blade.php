@extends('layouts.app')

@section('content')
{{-- <div class="container clear-fix content"> --}}
   {{--  <div class="row">
        <div class="col-md-8 col-md-offset-2"> --}}
	<div class="banner">

		<!-- slideshow start -->
		<!-- ================ -->
		<div class="slideshow">
			
			<!-- slider revolution start -->
			<!-- ================ -->
			<div class="slider-banner-container">
				<div class="slider-banner">
					<ul>
							<!-- slide 1 start -->
						<li data-transition="random" data-slotamount="7" data-masterspeed="500" data-saveperformance="on" data-title="Premium HTML5 template">
						
						<!-- main image -->
						<img src="{{url('/')}}/images/slider/blankImg.jpg"  alt="slidebg1" data-bgposition="center top" data-bgfit="cover" data-bgrepeat="no-repeat">

						<!-- LAYER NR. 1 -->
						<div class="tp-caption default_bg large sfr tp-resizeme"
							data-x="0"
							data-y="70" 
							data-speed="600"
							data-start="1200"
							data-end="9400"
							data-endspeed="600">Learn online
						</div>

						<!-- LAYER NR. 2 -->
						<div class="tp-caption dark_gray_bg sfl medium tp-resizeme"
							data-x="0"
							data-y="170" 
							data-speed="600"
							data-start="1600"
							data-end="9400"
							data-endspeed="600"><i class="icon-check"></i>
						</div>

						<!-- LAYER NR. 3 -->
						<div class="tp-caption light_gray_bg sfb medium tp-resizeme"
							data-x="50"
							data-y="170" 
							data-speed="600"
							data-start="1600"
							data-end="9400"
							data-endspeed="600"><a href="#" style="color:#333;">Learn faster</a>
						</div>

						<!-- LAYER NR. 4 -->
						<div class="tp-caption dark_gray_bg sfl medium tp-resizeme"
							data-x="0"
							data-y="220" 
							data-speed="600"
							data-start="1800"
							data-end="9400"
							data-endspeed="600"><i class="icon-check"></i>
						</div>

						<!-- LAYER NR. 5 -->
						<div class="tp-caption light_gray_bg sfb medium tp-resizeme"
							data-x="50"
							data-y="220" 
							data-speed="600"
							data-start="1800"
							data-end="9400"
							data-endspeed="600">Learn easier
						</div>

						<!-- LAYER NR. 6 -->
						<div class="tp-caption dark_gray_bg sfl medium tp-resizeme"
							data-x="0"
							data-y="270" 
							data-speed="600"
							data-start="2000"
							data-end="9400"
							data-endspeed="600"><i class="icon-check"></i>
						</div>

						<!-- LAYER NR. 7 -->
						<div class="tp-caption light_gray_bg sfb medium tp-resizeme"
							data-x="50"
							data-y="270" 
							data-speed="600"
							data-start="2000"
							data-end="9400"
							data-endspeed="600">More options
						</div>

						<!-- LAYER NR. 8 -->
						<div class="tp-caption dark_gray_bg sfl medium tp-resizeme"
							data-x="0"
							data-y="320" 
							data-speed="600"
							data-start="2200"
							data-end="9400"
							data-endspeed="600"><i class="icon-check"></i>
						</div>

						<!-- LAYER NR. 9 -->
						<div class="tp-caption light_gray_bg sfb medium tp-resizeme"
							data-x="50"
							data-y="320" 
							data-speed="600"
							data-start="2200"
							data-end="9400"
							data-endspeed="600">More enjoyable
						</div>

						<div class="tp-caption sfr tp-resizeme"
							data-x="right"
							data-y="center" 
							data-speed="600"
							data-start="2400"
							data-end="9400"
							data-endspeed="600"><img src="{{url('/')}}/images/slider/easylearning_img2.png" class="img-responsive" alt="" />
						</div>

						</li>
						<!-- slide 1 end -->

						<!-- slide 2 start -->
						<li data-transition="random" data-slotamount="7" data-masterspeed="500" data-saveperformance="on" data-title="Premium HTML5 template">
						
						<!-- main image -->
						<img src="{{url('/')}}/images/slider/blankImg.jpg"  alt="slidebg1" data-bgposition="center top" data-bgfit="cover" data-bgrepeat="no-repeat">

						<!-- LAYER NR. 1 -->
						<div class="tp-caption default_bg large sfr tp-resizeme"
							data-x="0"
							data-y="70" 
							data-speed="600"
							data-start="1200"
							data-end="9400"
							data-endspeed="600">Teach online
						</div>

						<!-- LAYER NR. 2 -->
						<div class="tp-caption dark_gray_bg sfl medium tp-resizeme"
							data-x="0"
							data-y="170" 
							data-speed="600"
							data-start="1600"
							data-end="9400"
							data-endspeed="600"><i class="icon-check"></i>
						</div>

						<!-- LAYER NR. 3 -->
						<div class="tp-caption light_gray_bg sfb medium tp-resizeme"
							data-x="50"
							data-y="170" 
							data-speed="600"
							data-start="1600"
							data-end="9400"
							data-endspeed="600"><a href="#" style="color:#333;">More students</a>
						</div>

						<!-- LAYER NR. 4 -->
						<div class="tp-caption dark_gray_bg sfl medium tp-resizeme"
							data-x="0"
							data-y="220" 
							data-speed="600"
							data-start="1800"
							data-end="9400"
							data-endspeed="600"><i class="icon-check"></i>
						</div>

						<!-- LAYER NR. 5 -->
						<div class="tp-caption light_gray_bg sfb medium tp-resizeme"
							data-x="50"
							data-y="220" 
							data-speed="600"
							data-start="1800"
							data-end="9400"
							data-endspeed="600">Easier tools
						</div>

						<!-- LAYER NR. 6 -->
						<div class="tp-caption dark_gray_bg sfl medium tp-resizeme"
							data-x="0"
							data-y="270" 
							data-speed="600"
							data-start="2000"
							data-end="9400"
							data-endspeed="600"><i class="icon-check"></i>
						</div>

						<!-- LAYER NR. 7 -->
						<div class="tp-caption light_gray_bg sfb medium tp-resizeme"
							data-x="50"
							data-y="270" 
							data-speed="600"
							data-start="2000"
							data-end="9400"
							data-endspeed="600">Teach from home
						</div>

						<!-- LAYER NR. 8 -->
						<div class="tp-caption dark_gray_bg sfl medium tp-resizeme"
							data-x="0"
							data-y="320" 
							data-speed="600"
							data-start="2200"
							data-end="9400"
							data-endspeed="600"><i class="icon-check"></i>
						</div>

						<!-- LAYER NR. 9 -->
						<div class="tp-caption light_gray_bg sfb medium tp-resizeme"
							data-x="50"
							data-y="320" 
							data-speed="600"
							data-start="2200"
							data-end="9400"
							data-endspeed="600">Travel and teach
						</div>
						
						<div class="tp-caption sfr tp-resizeme"
							data-x="right"
							data-y="center" 
							data-speed="600"
							data-start="2400"
							data-end="9400"
							data-endspeed="600"><img src="{{url('/')}}/images/slider/easylearning_img3.png" class="img-responsive" alt="" />
						</div>


						</li>
						<!-- slide 2 en -->
					</ul>
					<div class="tp-bannertimer tp-bottom"></div>
				</div>
			</div>
			<!-- slider revolution end -->

		</div>
		<!-- slideshow end -->

	</div>
				<!-- banner end -->

<!-- main-container start -->
<!-- ================ -->
<!-- section start -->

@endsection
