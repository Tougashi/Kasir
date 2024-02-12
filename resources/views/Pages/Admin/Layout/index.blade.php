<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kopsis | {{ $title }}</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/logo.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/logo.png') }}">
    <meta name="csrf-token" content="{{csrf_token()}}"/>
    <link href="{{ asset('/assets/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
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
    <script src="{{ asset('/assets/plugins/bootstrap/js/bootstrap.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <link rel="stylesheet" href="{{asset('assets/plugins/datatable/css/dataTables.min.css')}}">
    <script type="text/javascript" src="{{asset('assets/plugins/datatable/js/dataTables.min.js')}}"></script>

    {{-- Sweeetalert --}}
    <link rel="stylesheet" href="{{asset('assets/plugins/sweetalert/css/sweetalert2.min.css')}}">
    <script src="{{asset('assets/plugins/sweetalert/js/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('assets/js/sweetalert/script.js')}}"></script>

    @yield('plugins')
</head>

<body>
    @include('Components.sidebar')
    @include('Components.navbar')
    <div class="w-80p d-flex float-end container py-3 d-flex">
        <div class="w-100 py-1">
            <div class="d-flex align-items-center justify-content-between">
                <h3 class="ps-4 mt-lg-3 mt-0" id="cardWrapperTitle">{{ $title }}</h3>
            </div>
            <div id="content" class="mt-2 pb-5 w-100">
                @yield('content')
            </div>
        </div>
    </div>
    <script>
        const currentUrl = '{{url()->current()}}';
        $(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });

        function initTable(tableId){
            let dt = $(`${tableId}`).DataTable({
                responsive: true,
                searching: true,
                autoWidth: false,
                destroy: true,
            });
        }

        function refreshDatatable(data, column){
            $('.dt').empty();
            $('.dt').DataTable({
                responsive: true,
                searching: true,
                autoWidth: false,
                destroy: true,
                data: data,
                columns: column,
            });
        }

        const ajaxDeleteData = (itemId) => {
            let url = '{{url()->current()}}'+'/delete/'+itemId;
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response){
                    successAlert(response.message);
                    refreshData();
                },
                error: function(error,xhr){
                    errorAlert(errror.message);
                    console.log(xhr.responseText);
                }
            });
        }

        function edit(slug){
            let url = '{{url()->current()}}'+'/edit/'+slug;
            info('Mohon tunggu sebentar..');
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response){
                    showEditModal(response.data);
                    Swal.close();
                },
                error: function(error, xhr){
                    errorAlert(error.message);
                }
           });
        }


        </script>
    @if(session()->has('success'))
        <script>
            successAlert('{{session("success")}}');
        </script>
    @endif
    @stack('scripts')
</body>

</html>
