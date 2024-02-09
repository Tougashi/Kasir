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
    <link rel="stylesheet" href="{{asset('assets/plugins/datatable/css/dataTables.min.css')}}">
    <script type="text/javascript" src="{{asset('assets/plugins/datatable/js/dataTables.min.js')}}"></script>

    {{-- Sweeetalert --}}
    <link rel="stylesheet" href="{{asset('assets/plugins/sweetalert/css/sweetalert2.min.css')}}">
    <script src="{{asset('assets/plugins/sweetalert/js/sweetalert2.all.min.js')}}"></script>
</head>

<body>
    @include('Components.sidebar')
    @include('Components.navbar')
    <div class="w-80p d-flex float-end container py-3 d-flex">
        <div class="w-100 py-3">
            <h3 class="ps-lg-0 ps-4" id="cardWrapperTitle">{{ $title }}</h3>
            <div id="content" class="mt-2 pb-5 w-100">
                @yield('content')
            </div>
        </div>
    </div>
    <script>
        $(function(){
            $('[data-toggle="tooltip"]').tooltip();
            // confirmation();

        });

        function initTable(tableId){
            let dt = $(`${tableId}`).DataTable({
                responsive: true,
                searching: true,
                autoWidth: false,
            });
        }

        const successButton = 'btn btn-success';
        const infoButton = 'btn btn-info';
        const errorButton = 'btn btn-danger';
        const timeoutAlert = 2000;

        const success = (message) => {
            Swal.fire({
                title: "Good job!",
                text: message,
                icon: "success",
                timer: timeoutAlert,
                customClass: {
                    confirmButton: successButton
                },
            });
        }

        const info = (message) => {
            Swal.fire({
                title: "Good job!",
                text: message,
                icon: "success",
                timer: timeoutAlert,
                customClass: {
                    confirmButton: infoButton
                }
            });
        }

        const confirmation = () => {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                if (result.isConfirmed) {
                    ajaxDeleteData('dsf');
                }else{
                    info('Data anda tetap disimpan !');
                }
            });
        }


        const error = (message) => {
            Swal.fire({
                title: "Terdapat Masalah",
                text: message,
                icon: "error",
                customClass: {
                    confirmButton: errorButton
                }
            });
        }


        const ajaxDeleteData = (itemId) => {
            let url = '{{url()->current()}}'+'/delete/'+itemId;
            info(url);
        }

    </script>
    @stack('scripts')
</body>

</html>
