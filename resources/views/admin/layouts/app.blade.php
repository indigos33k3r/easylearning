<!DOCTYPE html>
@if (Auth::guard('admins')->user())
<html lang="en">
@else 
<html lang="en" id="extr-page">
@endif
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} Admin</title>

    <!-- Styles -->
    <link href="{{ url('/') }}/external/smartadmin/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ url('/') }}/external/smartadmin/css/font-awesome.min.css" rel="stylesheet">
    <!-- SmartAdmin Styles : Caution! DO NOT change the order -->
    <link href="{{ url('/') }}/external/smartadmin/css/smartadmin-production-plugins.min.css" rel="stylesheet">
    <link href="{{ url('/') }}/external/smartadmin/css/smartadmin-production.min.css" rel="stylesheet">
    <link href="{{ url('/') }}/external/smartadmin/css/smartadmin-skins.min.css" rel="stylesheet">
    <link href="{{ url('/') }}/external/smartadmin/css/datatables/buttons.datatables.min.css" rel="stylesheet">

    <!-- SmartAdmin RTL Support  -->
    <link href="{{ url('/') }}/external/smartadmin/css/smartadmin-rtl.min.css" rel="stylesheet">

    <link href="{{ url('/') }}/adm/css/main.css" rel="stylesheet">

    @if (Auth::guard('admins')->user())
    @endif

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]); ?>
    </script>

     @if (isset($styleSheets))
        @foreach ($styleSheets as $sheet)
            <link href="{{ URL::asset($sheet)}}" rel="stylesheet">
        @endforeach
    @endif
</head>
<body>

@if (Auth::guard('admins')->user())
    @include('admin.headbar')
    @if (View::exists('admin.sidebar')) 
        @include('admin.sidebar')
    @endif
    <div id="main" role="main">
        <div id="ribbon"></div>
        <div id="content">
            @yield('content')
        </div>
    </div>
@else
    <header id="header">
        <div id="logo-group">
           <a href="{{url('/')}}/admin/home"> <span id="logo"> <img src="{{url('/')}}/adm/img/logo.png" alt="SmartAdmin"> </span></a>
        </div>
    </header>
    <div id="main" role="main">
        <div id="content" class="container">
            @yield('content')
        </div>
    </div>
@endif


<!-- Scripts -->

<script src="{{ url('/') }}/external/smartadmin/js/plugin/jquery/jquery.min.js"></script>
<script src="{{ url('/') }}/external/smartadmin/js/bootstrap/bootstrap.min.js"></script>
<script src="{{ url('/') }}/external/smartadmin/js/app.config.js"></script>
<script src="{{ url('/') }}/external/smartadmin/js/plugin/jquery/jquery-ui.min.js"></script>
<script src="{{ url('/') }}/external/smartadmin/js/plugin/jquery-validate/jquery.validate.min.js"></script>
@if (Auth::guard('admins')->user())
        <script src="{{ url('/') }}/external/smartadmin/js/app.min.js"></script>
        <script src="{{ url('/')}}/external/smartadmin/js/plugin/pace/pace.min.js"></script>  
        <script src="{{ url('/')}}/external/smartadmin/js/plugin/dt/dataTables.min.js"></script>
        <script src="{{ url('/')}}/external/smartadmin/js/plugin/dt/dataTables.buttons.min.js"></script>
        <script src="{{ url('/')}}/external/smartadmin/js/plugin/dt/buttons.flash.min.js"></script>
        <script src="{{ url('/')}}/external/smartadmin/js/plugin/dt/buttons.html5.min.js"></script>
        <script src="{{ url('/')}}/external/smartadmin/js/plugin/dt/jszip.min.js"></script>
        <script src="{{ url('/')}}/external/smartadmin/js/plugin/dt/vfs_fonts.js"></script>
       
        <script src="{{ url('/')}}/external/smartadmin/js/plugin/datatables/dataTables.colVis.min.js"></script>
        <script src="{{ url('/')}}/external/smartadmin/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
        {{-- <script src="{{ url('/')}}/external/smartadmin/js/plugin/datatable-responsive/datatables.responsive.min.js"></script> --}}
        <script src="{{ url('/') }}/adm/js/main.js"></script>

@endif
<script>
    BASE_URL = "{{url('/')}}";

</script>

@if (isset($scripts))
    @foreach ($scripts as $script)
        <script src="{{ url('/') }}/{{$script}}"></script>
    @endforeach
@endif
<script> 
    @if (isset($menuHighlightId))
        var menuHighlightId = '{{$menuHighlightId}}';
    @else
        var menuHighlightId = 'default';
    @endif

    @if (isset($submenuHighlightId))
        var submenuHighlightId = '{{$submenuHighlightId}}';
    @else
        var submenuHighlightId = null;
    @endif
</script>

</body>
</html>