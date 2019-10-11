<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

</div>


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/plugins/images/favicon.png')}}">
    <title>Բոնուս</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{asset('assets/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- animation CSS -->
    <link href="{{asset('assets/css/animate.css')}}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
    <!-- color CSS -->
    <link href="{{asset('assets/css/colors/default.css')}}" id="theme" rel="stylesheet">
    <!-- jQuery -->
    <script src="{{asset('assets/plugins/bower_components/jquery/dist/jquery.min.js')}}"></script>

</head>
<body class="fix-header">

<!-- Preloader -->
<div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
    </svg>
</div>
    @yield('content')

{{--data table--}}
<script src="{{asset('assets/plugins/bower_components/datatables/datatables.min.js')}}"></script>
<!-- Bootstrap Core JavaScript -->
<script src="{{asset('assets/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- Menu Plugin JavaScript -->
<script src="{{asset('assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js')}}"></script>
<!--slimscroll JavaScript -->
<script src="{{asset('assets/js/jquery.slimscroll.js')}}"></script>
<!--Wave Effects -->
<script src="{{asset('assets/js/waves.js')}}"></script>
<!-- Custom Theme JavaScript -->
<script src="{{asset('assets/js/custom.min.js')}}"></script>
<!--Style Switcher -->
<script src="{{asset('assets/plugins/bower_components/styleswitcher/jQuery.style.switcher.js')}}"></script>

</body>

</html>


