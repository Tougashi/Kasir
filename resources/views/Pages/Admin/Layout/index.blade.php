<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kopsis | {{ $title }}</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/logo.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/logo.png') }}">
    <link href="{{ asset('/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap') }}"
        rel="stylesheet">

    <link href="{{ asset('/assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/css/icons.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">

    <link href="{{ asset('assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />

    <link href="{{ asset('/assets/css/icons.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/icons/bootstrap-icons-1.11.3/font/bootstrap-icons.min.css') }}">

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <!-- Bootstrap JS -->
    <script src="{{ asset('/assets/js/bootstrap.bundle.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <link rel="stylesheet" href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}">
    <script type="text/javascript" src="{{asset('assets/plugins/datatable/js/dataTables.min.js')}}"></script>
</head>

<body>
    @include('Components.sidebar')
    @include('Components.navbar')
    <div class="w-80p d-flex float-end container py-3 d-flex">
        <div class="w-100 py-3">
            <h3 class="ps-lg-0 ps-4" id="cardWrapperTitle">{{ $title }}</h3>
            <div id="content" class="pt-2 pb-5 w-100">
                @yield('content')
            </div>
        </div>
    </div>
    @stack('scripts')
    <script>
        $(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</body>

</html>
