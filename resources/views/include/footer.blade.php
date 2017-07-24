
@section('footer')
    <footer id="footer">
        <!-- .footer start -->               
        <div class="footer">
            <div class="container">
                <div class="row">                            
                    <div class="footer-content">                                
                        <div class="row">
                            <div class="col-sm-6">
                                <p>Be the first to know all the updates. Follows us!</p>
                                <ul class="social-links circle">
                                    <li class="facebook"><a target="_blank" href="http://www.facebook.com"><i class="fa fa-facebook"></i></a></li>
                                    <li class="twitter"><a target="_blank" href="http://www.twitter.com"><i class="fa fa-twitter"></i></a></li>
                                    <li class="googleplus"><a target="_blank" href="http://plus.google.com"><i class="fa fa-google-plus"></i></a></li>
                                    <li class="skype"><a target="_blank" href="http://www.skype.com"><i class="fa fa-skype"></i></a></li>
                                    <li class="linkedin"><a target="_blank" href="http://www.linkedin.com"><i class="fa fa-linkedin"></i></a></li>
                                </ul>
                            </div>
                            <div class="col-sm-6">
                                <ul class="list-icons">
                                    <li><i class="fa fa-map-marker pr-10"></i> Tudor Vladimirescu, 6-8</li>
                                    <li><i class="fa fa-phone pr-10"></i> +40 753761702</li>
                                    <li><i class="fa fa-fax pr-10"></i> +44 7544393927 </li>
                                    <li><i class="fa fa-envelope-o pr-10"></i> davidurs1@gmail.com</li>
                                </ul>
                            </div>
                        </div>                                
                    </div>                            
                    <div class="space-bottom hidden-lg hidden-xs"></div>
                </div>
                <div class="space-bottom hidden-lg hidden-xs"></div>
            </div>
        </div>
        <!-- .footer end -->

        <!-- .subfooter start -->
        <div class="subfooter">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <p>Copyright © david. All Rights Reserved</p>
                    </div>
                    <div class="col-md-6">
                        <nav class="navbar navbar-default" role="navigation">
                            <!-- Toggle get grouped for better mobile display -->
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-2">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>   
                            <div class="collapse navbar-collapse" id="navbar-collapse-2">
                                <ul class="nav navbar-nav">
                                    <li><a href="{{url('/')}}">Home</a></li>
                                    <li><a href="{{url('/')}}/termsOfUse">Terms and conditions</a></li>
                                </ul>
                            </div>
                        </nav>
                    </div>                       
                </div>
            </div>
        </div>
        <!-- .subfooter end -->
    </footer>
@endsection
