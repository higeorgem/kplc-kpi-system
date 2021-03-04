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
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('css/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('css/dist/css/adminlte.min.css')}}">
    {{-- sweet alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
{{-- sidebar-collapse --}}
<body style="background: linear-gradient(110deg, #82f87e 60%, #f5e76a 60%);">

    <section class="mt-4">
        <div class="container-fluid">
            @include('flash::message')
            @yield('content')
        </div>
    </section>


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
