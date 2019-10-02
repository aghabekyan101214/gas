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
    <title>Ample Admin Template - The Ultimate Multipurpose admin template</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{asset('assets/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="{{asset('assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css')}}" rel="stylesheet">
    <!-- animation CSS -->
    <link href="{{asset('assets/css/animate.css')}}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
    <!-- color CSS -->
    <link href="{{asset('assets/css/colors/default.css')}}" id="theme" rel="stylesheet">
    <!-- jQuery -->
    <script src="{{asset('assets/plugins/bower_components/jquery/dist/jquery.min.js')}}"></script>
    {{--data table--}}
    <link href="{{asset('assets/plugins/bower_components/datatables/media/css/dataTables.bootstrap.css')}}"
          rel="stylesheet" type="text/css"/>
    <!-- Select2 Css -->
    <link href="{{ asset("assets/select2/dist/css/select2.min.css") }}" rel="stylesheet" />

</head>
<body class="fix-header">

<!-- Preloader -->
<div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
    </svg>
</div>

<div id="app">
    <!-- Wrapper -->
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header">
                <div class="top-left-part">
                    <!-- Logo -->
                    <a class="logo" href="index.html">
                        <b>
                            <img src="{{asset('assets/plugins/images/aimtech.png')}}" alt="home"
                                 class="dark-logo" width="100px" height='55px' />
                        </b>
                    </a>
                </div>

                <ul class="nav navbar-top-links navbar-right pull-right">
                    <li class="dropdown">
                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> <img
                                src="{{asset('assets/plugins/images/users/varun.jpg')}}" alt="user-img" width="36"
                                class="img-circle"><b
                                class="hidden-xs">{{Auth::user()->name}}</b><span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu dropdown-user animated flipInY">
                            <li><a href="#"><i class="ti-user"></i> My Profile</a></li>
                            <li><a href="#"><i class="ti-wallet"></i> My Balance</a></li>
                            <li><a href="#"><i class="ti-email"></i> Inbox</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#"><i class="ti-settings"></i> Account Setting</a></li>
                            <li role="separator" class="divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <i class="fa fa-power-off"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav slimscrollsidebar">
                <div class="sidebar-head">
                    <h3><span class="fa-fw open-close"><i class="ti-menu hidden-xs"></i><i
                                class="ti-close visible-xs"></i></span>
                        <span class="hide-menu">Navigation</span></h3></div>
                <ul class="nav" id="side-menu">

                    <li class="devider"></li>

                    <li>
                        <a href="/admin/users" class="waves-effect">
                            <i class="mdi mdi-account fa-fw"></i>
                            <span class="hide-menu">Admins</span>
                        </a>
                    </li>

                    <li>
                        <a href="/admin/stations" class="waves-effect">
                            <i class="mdi mdi-gauge fa-fw"></i>
                            <span class="hide-menu">Gas Stations</span>
                        </a>
                    </li>

                    <li>
                        <a href="/admin/dispensers" class="waves-effect">
                            <i class="mdi mdi-calculator fa-fw"></i>
                            <span class="hide-menu"> Dispensers </span>
                        </a>
                    </li>

                    <li>
                        <a href="/admin/fuels" class="waves-effect">
                            <i class="mdi mdi-format-color-fill fa-fw"></i>
                            <span class="hide-menu"> Fuels </span>
                        </a>
                    </li>

                    <li>
                        <a href="/admin/clients" class="waves-effect">
                            <i class="mdi mdi-human fa-fw"></i>
                            <span class="hide-menu">Clients</span>
                        </a>
                    </li>

                </ul>
            </div>
        </div>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
{{--                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">--}}
{{--                        <h4 class="page-title">{{$data["title"]}}</h4></div>--}}
                </div>

                <div class="row">
                    <div class="col-md-12">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer text-center"> 2019 &copy;</footer>
        </div>
    </div>
</div>

{{--data table--}}
<script src="{{asset('assets/plugins/bower_components/datatables/datatables.min.js')}}"></script>
<script>
    $(function () {
        $('#myTable').DataTable();
    });

    $(document).ready(function() {
        $('.select2').select2();
    });
</script>

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
<!--Select2-->
<script src="{{ asset("assets/select2/dist/js/select2.min.js") }}"></script>
</body>

</html>


