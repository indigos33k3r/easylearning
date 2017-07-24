<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ URL::asset('css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>

    <!-- Theme CSS files -->
    <!-- Font Awesome CSS -->
    <link href="{{ url('/') }}/external/theme/fonts/font-awesome/css/font-awesome.css" rel="stylesheet">
    <!-- Fontello CSS -->
    <link href="{{ url('/') }}/external/theme/fonts/fontello/css/fontello.css" rel="stylesheet">
    
    <!-- Plugins -->
    <link href="{{ url('/') }}/external/theme/plugins/rs-plugin/css/settings.css" media="screen" rel="stylesheet">
    <link href="{{ url('/') }}/external/theme/plugins/rs-plugin/css/extralayers.css" media="screen" rel="stylesheet">
    <link href="{{ url('/') }}/external/theme/plugins/magnific-popup/magnific-popup.css" rel="stylesheet">
    <link href="{{ url('/') }}/external/theme/css/animations.css" rel="stylesheet">
    <link href="{{ url('/') }}/external/theme/plugins/owl-carousel/owl.carousel.css" rel="stylesheet">

    <!-- iDea core CSS file -->
    <link href="{{ url('/') }}/external/theme/css/style.css" rel="stylesheet">

    <!-- Color Scheme (In order to change the color scheme, replace the red.css with the color scheme that you prefer)-->
    <link href="{{ url('/') }}/external/theme/css/skins/blue.css" rel="stylesheet">
    
    <!-- Theme CSS files -->
    @if (isset($styleSheets))
        @foreach ($styleSheets as $sheet)
            <link href="{{ URL::asset($sheet)}}" rel="stylesheet">
        @endforeach
    @endif
    <link href="{{ URL::asset('css/main.css')}}" rel="stylesheet">
</head>
<body class="front no-trans full-height">
    <?php echo View::make('include/header'); ?>
    <?php echo View::make('include/footer'); ?>
    <div id="app" class="page-wrapper" > 
        @yield('header')
        @if (isset($projects)) 
            @include('include.menu', ['projects' => $projects])
        @else
            @include('include.menu')
        @endif
        @yield('menu')

        @yield('content')   
        
        @yield('footer')        
    </div>

    <!-- JavaScript files placed at the end of the document so the pages load faster
    ================================================== -->
    <!-- Jquery and Bootstap core js files -->
    <script type="text/javascript" src="{{ url('/') }}/external/theme/plugins/jquery.min.js"></script>
    <script type="text/javascript" src="{{ URL::asset('js/bootstrap.min.js')}}"></script>

    <!-- Modernizr javascript -->
    <script type="text/javascript" src="{{ url('/') }}/external/theme/plugins/modernizr.js"></script>

    <!-- jQuery REVOLUTION Slider  -->
    <script type="text/javascript" src="{{ url('/') }}/external/theme/plugins/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
    <script type="text/javascript" src="{{ url('/') }}/external/theme/plugins/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>

    <!-- Isotope javascript -->
    <script type="text/javascript" src="{{ url('/') }}/external/theme/plugins/isotope/isotope.pkgd.min.js"></script>

    <!-- Owl carousel javascript -->
    <script type="text/javascript" src="{{ url('/') }}/external/theme/plugins/owl-carousel/owl.carousel.js"></script>

    <!-- Magnific Popup javascript -->
    <script type="text/javascript" src="{{ url('/') }}/external/theme/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>

    <!-- Appear javascript -->
    <script type="text/javascript" src="{{ url('/') }}/external/theme/plugins/jquery.appear.js"></script>

    <!-- Count To javascript -->
    <script type="text/javascript" src="{{ url('/') }}/external/theme/plugins/jquery.countTo.js"></script>

    <!-- Parallax javascript -->
    <script src="{{ url('/') }}/external/theme/plugins/jquery.parallax-1.1.3.js"></script>

    <!-- Contact form -->
    <script src="{{ url('/') }}/external/theme/plugins/jquery.validate.js"></script>

    <!-- SmoothScroll javascript -->
    <script type="text/javascript" src="{{ url('/') }}/external/theme/plugins/jquery.browser.js"></script>
    <script type="text/javascript" src="{{ url('/') }}/external/theme/plugins/SmoothScroll.js"></script>
    
    <!-- Initialization of Plugins -->
    <script type="text/javascript" src="{{ url('/') }}/external/theme/js/template.js"></script>

    <!-- Scripts -->
    {{-- <script src="{{ URL::asset('js/app.js')}}"></script> --}}

    @if (isset($scripts))
        @foreach ($scripts as $script)
            <script src="{{ URL::asset($script)}}"></script>
        @endforeach
    @endif
    <script type="text/javascript" src="{{ URL::asset('js/main.js')}}"></script>

    <script> 
        BASE_URL = "{{url('/')}}";
    </script>
</body>
</html>
