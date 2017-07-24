
@section('header')    
    @if (Auth::guest())
        <div class="header-top">
            <div class="container">
                <div class="row">
                    <div class="col-xs-2 col-sm-6">                            

                    </div>
                    <div class="col-xs-10 col-sm-6">
                        <!-- header-top-second start -->
                        <div id="header-top-second"  class="clearfix">
                            <!-- header top dropdowns start -->
                            <div class="header-top-dropdown">
                                <div class="btn-group dropdown">
                                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown"><i class="fa fa-search"></i> Search</button>
                                    <ul class="dropdown-menu dropdown-menu-right dropdown-animation">
                                        <li>
                                            <form role="search" class="search-box">
                                                <div class="form-group has-feedback">
                                                    <input type="text" class="form-control" placeholder="Search">
                                                    <i class="fa fa-search form-control-feedback"></i>
                                                </div>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                                <div class="btn-group dropdown">
                                    @if (Route::has('login'))
                                        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> Login</button>
                                        <ul class="dropdown-menu dropdown-menu-right dropdown-animation">
                                            <li>
                                                <form id="header-login-form" class="login-form" role="form">
                                                    {{ csrf_field() }}
                                                    <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                                                        <label class="control-label">E-mail Address</label>
                                                        <input type="text" name="email" class="form-control" placeholder="" required autofocus>
                                                        <i class="fa fa-user form-control-feedback"></i>
                                                        @if ($errors->has('email'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('email') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
                                                        <label class="control-label">Password</label>
                                                        <input type="password" name="password" class="form-control" placeholder="" required >
                                                        <i class="fa fa-lock form-control-feedback"></i>
                                                        @if ($errors->has('password'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('password') }}</strong>
                                                            </span>
                                                        @endif
                                                         <label id="header-login-error" class="ajax-error hidden">The password or email is not correct</label>
                                                        <label id="header-login-unconfirmed" class="ajax-error hidden">The account is not activated</label>
                                                    </div>
                                                    <div class="form-group has-feedback">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" name="remember"> Remember Me
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-group btn-dark btn-sm">Log In</button>
                                                    <span>or</span>
                                                    <a href="{{ url('/register') }}" class="btn btn-group btn-default btn-sm">Register</a>                                                  
                                                    <a href="{{url('/password/reset')}}">Forgot your password?</a>                
                                                </form>
                                            </li>
                                        </ul>
                                     @endif
                                </div>                              
                            </div>
                            <!--  header top dropdowns end -->
                        </div>
                        <!-- header-top-second end -->
                    </div>                        
                </div>
            </div>
        </div>
    @else
        <div class = "main-navigation header-top">
            <div class="container">
				<nav class="navbar navbar-default " role="navigation">
				    <div class="navbar-collapse collapse in" id="app-header-collapse" aria-expanded="true">     
				        <ul class="nav navbar-nav">
				            <!-- Authentication Links -->
				                <li class="dropdown">
				                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" >
				                        {{ Auth::user()->name }} <i class="fa fa-caret-down" aria-hidden="true"></i> </span>
				                    </a>

				                    <ul class="dropdown-menu user-menu" role="menu" id = 'logout-menu'>
				                        <li>
				                        	<a href="{{url('/profile')}}">
				                        	<i class="fa fa-user" aria-hidden="true"></i>Profile</a>
				                        </li>
				                        <li>
				                            <a href="{{ url('/logout') }}"
				                                onclick="event.preventDefault();
				                                         document.getElementById('logout-form').submit();">
				                                <i class="fa fa-power-off" aria-hidden="true"></i>Logout
				                            </a>

				                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
				                                {{ csrf_field() }}
				                            </form>
				                        </li>

				                    </ul>
				                </li> 
				        </ul>
				    </div>
				</nav>
			</div>
        </div>
    @endif
@endsection