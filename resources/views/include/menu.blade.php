@section('menu')    
<header class="header fixed clearfix">
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <div class="header-left clearfix">
                    <div class="logo">
                        <a href="{{url('/')}}"><img id="logo" src="{{url('/')}}/images/logo.png" alt="EasyLearning"></a>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="header-right clearfix">
                    <div class="main-navigation animated">
                        <nav class="navbar navbar-default" role="navigation">
                            <div class="container-fluid">
                                <div class="navbar-header">
                                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                </div>
                                <div class="collapse navbar-collapse" id="navbar-collapse-1">
                                    <ul class="nav navbar-nav navbar-right">
                                        <li class="active">
                                            <a href="{{url('/')}}/home" class="active">Home</a>
                                        </li>
                                        <li>
                                            <a href="{{url('/')}}/schedules">Schedule</a>
                                        </li>
                                        <li>
                                            <a href="#">Q&A</a>
                                        </li>
                                        <li>
                                            <a href="#">Blog</a>
                                        </li>
                                        <li>
                                            <a href="#">Contact US</a>
                                        </li> 
                                    </ul>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
@endsection