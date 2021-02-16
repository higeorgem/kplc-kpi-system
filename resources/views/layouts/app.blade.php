<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'KPLC-KPI-SYSTEM') }}</title>

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
    {{-- datatables --}}
    <link rel="stylesheet" href="{{asset('css/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('css/plugins/fontawesome-free/css/all.min.css')}}">
{{-- icofont --}}
    <link rel="stylesheet" href="{{asset('css/plugins/icofont/icofont.min.css')}}">

    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('css/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('css/dist/css/adminlte.min.css')}}">
    {{-- sweet alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@yield('styles')
</head>
{{-- sidebar-collapse --}}
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light border-bottom border-warning">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/" class="nav-link {{Request::is('/') ? 'active' : ''}}">Home</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
                @endif
                @else
                {{-- <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li> --}}
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                      <i class="icofont-user"></i>  {{ Auth::user()->fullName(Auth::user()->id) }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
                @endguest
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar  sidebar-dark-warning elevation-4">
            <!-- Brand Logo -->
            <a href="/" class="brand-link">
                <img src="{{asset('css/dist/img/logo_2.jpeg')}}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light"> {{ config('app.name', 'KPLC-KPI-SYSTEM') }}</span>
            </a>
            @auth
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{asset('css/dist/img/default-150x150.png')}}" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">
                            {{ Auth::user()->fullName(Auth::user()->id) }} <br>
                            <span class="text-sm font-italic">
                                {{ ucwords(Auth::user()->title) }}
                            </span>
                            <br>

                            <span class="text-sm">
                                Dept: {{ Auth::user()->division->name ?? '000'}}<br>
                                <i class="fa fa-circle text-success"></i> Online
                            </span>
                        </a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item menu-open">
                            <a href="/" class="nav-link {{ Request::is('/') || Request::is('home') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                    {{-- <i class="right fas fa-angle-left"></i> --}}
                                </p>
                            </a>
                        </li>
                        {{-- kpi --}}
                        <li class="nav-item">
                            <a href=""
                                class="nav-link {{ Request::is('all/kpis') || Request::is('kpi') || Request::is('kpi/create') || Route::is('kpiTasks') ? 'active' : '' }}">
                                <i class="fas fa-thumbtack nav-icon"></i>
                                <p>KPI <i class="right fas fa-angle-left"></i></p>
                            </a>
                            @can('kpi-list')
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('allKpis')}}"
                                        class="nav-link {{ Request::is('all/kpis') ? 'active' : '' }}">
                                        <i class="fas fa-user nav-icon"></i>
                                        <p>All KPIs</p>
                                    </a>
                                </li>
                            </ul>
                            @endcan
                            @can('kpi-create')
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('kpi.create')}}"
                                        class="nav-link {{ Request::is('kpi/create') ? 'active' : '' }}">
                                        <i class="fas fa-plus nav-icon"></i>
                                        <p>Create KPIs</p>
                                    </a>
                                </li>
                            </ul>
                            @endcan

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('kpi.index')}}"
                                        class="nav-link {{ Request::is('kpi') ? 'active' : '' }}">
                                        <i class="fas fa-user-tag nav-icon"></i>
                                        <p>My KPIs</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#"
                                class="nav-link {{ (Request::is('tasks') || Request::is('tasks/create') || Request::is('tasks/upload') || Request::is('tasks/upload') )  ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Task <i class="right fas fa-angle-left"></i> </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/tasks" class="nav-link {{ Request::is('tasks') ? 'active' : '' }}">
                                        <i class="fas fa-tasks nav-icon"></i>
                                        <p>My Task</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/tasks/create"
                                        class="nav-link {{ (Request::is('tasks/create')) ? 'active' : '' }}">
                                        <i class="fas fa-plus nav-icon"></i>
                                        <p>Create Task</p>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a href="/tasks/upload"
                                        class="nav-link {{ Request::is('tasks/upload') ? 'active' : '' }}">
                                        <i class="fas fa-upload nav-icon"></i>
                                        <p>Upload Tasks</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="" class="nav-link {{ Request::is('reports') || Request::is('reports/query/report') ? 'active' : '' }}">
                                <i class="fas fa-file-alt nav-icon"></i>
                                <p>Reports <i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/reports" class="nav-link {{ (Request::is('reports')) ? 'active' : '' }}">
                                       <i class="icofont-paper nav-icon"></i>
                                        <p>General Report</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{URL::signedRoute('get_query')}}" class="nav-link {{ (Request::is('reports/query/report')) ? 'active' : '' }}">
                                        <i class="icofont-papers nav-icon"></i>
                                        <p>Query Report</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        {{-- Division --}}
                        <li class="nav-item ">
                            <a href="/divisions" class="nav-link {{ Request::is('divisions') ? 'active' : '' }}">
                                <i class="icofont-building nav-icon"></i>
                                <p>Division</p>
                            </a>
                        </li>
                        {{-- group --}}
                        <li class="nav-item ">
                            <a href="/groups" class="nav-link {{ Request::is('groups') ? 'active' : '' }}">
                                <i class="icofont-briefcase nav-icon"></i>
                                <p>Group</p>
                            </a>
                        </li>
                        @can('users-list')
                        <li class="nav-item">
                            <a href="#"
                                class="nav-link {{ (Request::is('users') || Request::is('roles/create') || Request::is('roles') || Request::is('users/create'))  ? 'active' : '' }}">
                                <i class="fas fa-users nav-icon"></i>
                                <p>User Management <i class="right fas fa-angle-left"></i> </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/users" class="nav-link {{ (Request::is('users')) ? 'active' : '' }}">
                                        <i class="fas fa-users nav-icon"></i>
                                        <p>All Users</p>
                                    </a>
                                </li>
                                @can('role-list')
                                <li class="nav-item ">
                                    <a href="/roles" class="nav-link {{ Request::is('roles') ? 'active' : '' }}">
                                       <i class="fab fa-critical-role nav-icon"></i>
                                        <p>Roles</p>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
            @endauth
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="background: linear-gradient(110deg, #eafaea 60%, #f7f5e8 60%);">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                {{-- <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Dashboard v2</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard v2</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid --> --}}
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <section class="content " >
                <div class="container-fluid">
                    @include('flash::message')
                    @yield('content')
                </div>
                <!--/. container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; <?php echo date('Y'); ?></strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                {{ config('app.name', 'KPLC-KPI-SYSTEM') }}
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="{{asset('css/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap -->
    <script src="{{asset('css/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- overlayScrollbars -->
    <script src="{{asset('css/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('css/dist/js/adminlte.js')}}"></script>

    <!-- PAGE PLUGINS -->
    <!-- jQuery Mapael -->
    <script src="{{asset('css/plugins/jquery-mousewheel/jquery.mousewheel.js')}}"></script>
    <script src="{{asset('css/plugins/raphael/raphael.min.js')}}"></script>
    <script src="{{asset('css/plugins/jquery-mapael/jquery.mapael.min.js')}}"></script>
    <script src="{{asset('css/plugins/jquery-mapael/maps/usa_states.min.js')}}"></script>
    <!-- ChartJS -->
    <script src="{{asset('css/plugins/chart.js/Chart.min.js')}}"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{asset('css/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('css/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('css/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('css/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('css/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('css/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('css/plugins/jszip/jszip.min.js')}}"></script>
    <script src="{{asset('css/plugins/pdfmake/pdfmake.min.js')}}"></script>
    <script src="{{asset('css/plugins/pdfmake/vfs_fonts.js')}}"></script>
    <script src="{{asset('css/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('css/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('css/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{asset('css/dist/js/demo.js')}}"></script>
    <script>
        $('#flash-overlay-modal').modal();
        $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
    </script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    {{-- <script src="{{asset('css/dist/js/pages/dashboard2.js')}}"></script> --}}
    @yield('scripts')
</body>
</html>
