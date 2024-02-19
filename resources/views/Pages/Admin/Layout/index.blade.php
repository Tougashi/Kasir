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
    <link href="{{ url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('assets/plugins/datatable/css/datatables.css')}}">
    <link href="{{ asset('/assets/css/icons.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/icons/bootstrap-icons-1.11.3/font/bootstrap-icons.min.css') }}">
    <link rel="stylesheet" href="{{asset('assets/plugins/sweetalert/css/sweetalert2.min.css')}}">


    @yield('plugins')
</head>

<body>
    @include('Components.sidenav')

    <div class="main-content">
        <div class="container">
            <div class="content-wrapper">
                <div class="content-header">
                    <h3 class="content-title">{{ $title }}</h3>
                    @php
                    $currentUrl = url()->current();
                    @endphp
                    @unless(request()->is('admin/dashboard') || request()->is('admin/products/stock-in') || Str::endsWith($currentUrl, '/add') || Str::of($currentUrl)->contains('history'))
                        <x-add-button/>
                    @endunless
                </div>
                <div id="content" class="content-body">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-lg" tabindex="-1" id="transactionModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Pop up Transaksi</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mb-3">
              <div class="row container">
                <div class="form-group">
                    <label for="code">Scan atau Ketik kode produk</label>
                    <input type="text" name="code" id="code" class="form-control">
                </div>
              </div>
            </div>
            {{-- <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div> --}}
          </div>
        </div>
      </div>




    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap JS -->
    <script src="{{ asset('/assets/plugins/bootstrap/js/bootstrap.js') }}"></script>

    <script type="text/javascript" src="{{asset('assets/plugins/datatable/js/datatables.min.js')}}"></script>


    {{-- Sweeetalert --}}
    <script src="{{asset('assets/plugins/sweetalert/js/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('assets/js/sweetalert/script.js')}}"></script>
    <script>
        const currentUrl = '{{url()->current()}}';
        $(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });

        var map = {}; // You could also use an array
        onkeydown = onkeyup = function(e){
            e = e || event;
            map[e.keyCode] = e.type == 'keydown';
            if(map[82] && map[84]){
                showScanModal();
            }
        }


        function showScanModal(){
            $('#transactionModal').modal('show');
        }

        function alertExpProduct(){
            $('#alertExpProduct').empty().append(`<div class="alert alert-danger" role="alert">
                Terdapat Product yang telah Kadaluarsa, Periksa Segera
            </div>`);
        }

        function printTable(tableId, exportColumns){
            let dt = $(`${tableId}`).DataTable({
                responsive: true,
                searching: true,
                autoWidth: false,
                dom: 'Bflrtip',
                buttons: [
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: exportColumns
                        },
                        className: 'coy'
                    },
                    {
                        extend: 'copy',
                        exportOptions: {
                            columns: exportColumns
                        },
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: exportColumns
                        },
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: exportColumns
                        },
                    },
                ],
                destroy: true,
            });
        }

        function initTable(tableId){
            let dt = $(`${tableId}`).DataTable({
                responsive: true,
                searching: true,
                autoWidth: false,
                destroy: true,
            });
        }

        function refreshDatatable(data, column, args){
            $('.dt').empty();
            $('.dt').DataTable({
                responsive: true,
                searching: true,
                autoWidth: false,
                destroy: true,
                data: data,
                columns: column,
                createdRow: (row, data, index) => {
                    let expDate = new Date(data.expiredDate).toISOString();
                    let now = new Date().toISOString();
                    if(now >= expDate){
                        $(row).addClass('table-danger');
                        alertExpProduct();
                    }
                }
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
