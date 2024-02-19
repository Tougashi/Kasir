<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kopsis | {{ $title }}</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/logo.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/logo.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="{{ asset('/assets/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap') }}"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/plugins/datatable/css/datatables.css') }}">
    <link href="{{ asset('/assets/css/icons.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/icons/bootstrap-icons-1.11.3/font/bootstrap-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/css/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">


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
                    @unless (request()->is('admin/dashboard') ||
                            request()->is('admin/products/stock-in') ||
                            Str::endsWith($currentUrl, '/add') ||
                            Str::of($currentUrl)->contains('history'))
                        <x-add-button />
                    @endunless
                </div>
                <div id="content" class="content-body">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-lg" tabindex="-1" id="transactionModal" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pop up Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="resetAllChanges()"></button>
                </div>
                <div class="modal-body mb-3 d-flex justify-content-center">
                    <div class="row container">
                        <div class="col-lg-6 col-md-6 col-12">
                            @php
                                $users = \App\Models\User::where('roles', 'Cashier');
                            @endphp
                            <div class="form-group">
                                <label for="code" class="mb-2">Nama Pelanggan</label>
                                <select name="" id="custId" style="width: 100%; ">
                                    <option value="3">Umum</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->username }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-group">
                                <label for="code" class="mb-2">Scan atau Ketik kode produk</label>
                                <input type="text" name="code" id="code" class="form-control form-control-sm border border-dark-subtle w-100">
                            </div>
                        </div>
                        <table class="table table-responsive text-center mt-4" id="regularTable">
                            <thead>
                                <tr>
                                    <th> </th>
                                    <th>No</th>
                                    <th>Kode Produk</th>
                                    <th>Nama Produk</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody id="transactionTable">
                                <tr>
                                    <td colspan="6">Belum ada Data</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4">Total</th>
                                    <th id="qtyTotal">0</th>
                                    <th id="priceTotal">0</th>
                                </tr>
                                <tr class="text-end">
                                    <th colspan="5">Subtotal</th>
                                    <th id="subtotalTotal">0</th>
                                </tr>
                            </tfoot>
                            <tbody id="transactionTable">
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="row gap-2 px-4 pb-4">
                    <div class="col-lg-4 col-md-4 col-12 order-lg-1 order-md-1 order-2">
                        <button type="button" onclick="resetAllChanges()" class="btn btn-secondary w-100">Proses</button>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12 d-flex justify-content-end ms-auto order-lg-2 order-md-2 order-1">
                        <button type="button" onclick="processTransaction()" class="btn btn-primary w-100">Proses</button>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap JS -->
    <script src="{{ asset('/assets/plugins/bootstrap/js/bootstrap.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/plugins/datatable/js/datatables.min.js') }}"></script>


    {{-- Sweeetalert --}}
    <script src="{{ asset('assets/plugins/sweetalert/js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert/script.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>

    <script>
        const currentUrl = '{{ url()->current() }}';
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
            $('#custId').select2({
                dropdownParent: $('#transactionModal'),
            });
        });


        function showScanModal() {
            $('#transactionModal').modal('show');
        }


        $('#code').on('input', function() {
            let value = $(this).val();
            if (value.length > 0) {
                getProductData(value);
            }
        });

        let map = {};
        onkeydown = onkeyup = function(e) {
            e = e || event;
            map[e.keyCode] = e.type == 'keydown';
            if (map[82] && map[84]) {
                showScanModal();
            }
        }

        let tableNumRows = 0;
        let productCodeArr = [];

        function addToTable() {
            let val = $('#productId').val();
            if (val) {
                getProductData(val);
            } else {
                errorAlert('Pilih Produk terlebih dahulu');
            }
        };

        function getProductData(code) {
            if (productCodeArr.includes(code)) {
                let indexArr = productCodeArr.indexOf(code);
                // console.log(`array index ke ${indexArr} dan di tableNumRows ke ${indexArr + 1}`);
            } else {
                $.ajax({
                    method: 'GET',
                    url: '/admin/products/get/' + code,
                    success: function(response) {
                        if (productCodeArr.length < 1) {
                            $('#transactionTable').empty();
                        }
                        productCodeArr.push(response.data.code);
                        appendToTable(response.data);
                        calculateTable();
                    },
                    error: function(xhr, error) {
                        errorAlert(xhr.responseText);
                        console.log(error.message);
                    }
                });
            }
        }

        function renumberRows() {
            if (productCodeArr.length < 1) {
                $('#transactionTable').empty().append(`
            <tr>
                <td colspan="6">Belum ada Data</td>
            </tr>
            `);
            } else {
                $('#regularTable tbody tr').each(function(index) {
                    $(this).find('td:nth-child(2)').text(index + 1);
                });
            }
        }

        function appendToTable(data) {
            tableNumRows++;
            $('#transactionTable').append(`
        <tr id="${tableNumRows}">
            <td><button class="float-start btn btn-sm btn-danger pe-1" onclick="removeRow('${tableNumRows}')"><i class="bi bi-trash"></i></button></td>
            <td>${tableNumRows}</td>
            <td>${data.code}</td>
            <td>${data.name}</td>
            <td>
                <input type="number" id="inputQty${tableNumRows}" oninput="calculateInput('${tableNumRows}')" value="1" class="m-0 p-0 w-100 border-0 form-control text-center">
            </td>
            <td id="price${tableNumRows}">${data.price}</td>
        </tr>
        `);
            renumberRows();
        }

        function removeRow(row) {
            let codeProduct = $(`tr#${row}`).find('td:nth-child(3)').text();
            let indexOfArr = productCodeArr.indexOf(codeProduct);
            productCodeArr.splice(indexOfArr, 1);
            $('#' + row).remove();
            renumberRows();
            calculateTable();
        }

        function calculateTable() {
            let qtyTotal = 0;
            let priceTotal = 0;
            for (let i = 1; i <= tableNumRows; i++) {
                let valQty = $(`#inputQty${i}`).val();
                let valPrice = $(`#price${i}`).text();
                if (isNaN(parseInt(valQty))) {
                    valQty = 0;
                } else {
                    let subtotal = parseInt(valQty) * parseFloat(valPrice);
                    $(`#subtotal${i}`).text(subtotal);
                    qtyTotal += parseInt(valQty);
                    priceTotal += subtotal;
                }
            }
            $('#qtyTotal').text(qtyTotal);
            $('#priceTotal').text(priceTotal);
            $('#subtotalTotal').text(priceTotal);
        }

        function calculateInput(rowId) {
            let valQty = $(`#inputQty${rowId}`).val();
            let valPrice = $(`#price${rowId}`).text();
            if (isNaN(parseInt(valQty))) {
                valQty = 0;
            } else {
                let totalPrice = parseInt(valQty) * parseFloat(valPrice);
                $(`#subtotal${rowId}`).text(totalPrice);
                calculateTable();
            }
        }

        function processTransaction() {
            let totalProductArr = [];
            for (let i = 0; i <= tableNumRows; i++) {
                let total = $(`#inputQty${i}`).val();
                totalProductArr.push(total);
                totalProductArr = totalProductArr.filter(function(element) {
                    return element !== undefined;
                });
            }

            let custId = $('#custId').val();

            let orderId;

            if (custId === '' || productCodeArr.length < 1) {
                errorAlert('Data yang dibutuhkan tidak boleh Kosong');
            } else {
                let formData = new FormData();
                formData.append('totalProductArr', JSON.stringify(totalProductArr));
                formData.append('productCodeArr', JSON.stringify(productCodeArr));
                formData.append('totalPrice', $('#subtotalTotal').text());
                formData.append('custId', custId);

                $.ajax({
                    url: '/admin/transactions/add/process',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        info('Tunggu sebentar...');
                    },
                    success: function(response) {
                        successAlert(response.message);
                        orderId = response.data;
                        resetAllChanges();
                    },
                    error: function(xhr, error) {
                        errorAlert(xhr.responseText);
                    },
                }).done(function(response) {
                    if (confirm('Apakah ingin cetak struk ?') === true) {
                        let url = `/admin/transactions/details/${orderId}/print`;
                        window.open(url);
                    } else {
                        console.log('false');
                    }
                });
            }
        }

        function resetAllChanges() {
            $('#custId').val(3).change();
            $('#code').val('').change();
            productCodeArr = [];
            tableNumRows = 0;
            $('#transactionTable').empty();
            renumberRows();
            calculateTable();
            $('#transactionModal').modal('hide');
        }


        function showScanModal() {
            $('#transactionModal').modal('show');
        }

        function alertExpProduct() {
            $('#alertExpProduct').empty().append(`<div class="alert alert-danger" role="alert">
                Terdapat Product yang telah Kadaluarsa, Periksa Segera
            </div>`);
        }

        function printTable(tableId, exportColumns) {
            let dt = $(`${tableId}`).DataTable({
                responsive: true,
                searching: true,
                autoWidth: false,
                dom: 'Bflrtip',
                buttons: [{
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

        function initTable(tableId) {
            let dt = $(`${tableId}`).DataTable({
                responsive: true,
                searching: true,
                autoWidth: false,
                destroy: true,
            });
        }

        function refreshDatatable(data, column, args) {
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
                    if (now >= expDate) {
                        $(row).addClass('table-danger');
                        alertExpProduct();
                    }
                }
            });
        }

        const ajaxDeleteData = (itemId) => {
            let url = '{{ url()->current() }}' + '/delete/' + itemId;
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    successAlert(response.message);
                    refreshData();
                },
                error: function(error, xhr) {
                    errorAlert(errror.message);
                    console.log(xhr.responseText);
                }
            });
        }

        function edit(slug) {
            let url = '{{ url()->current() }}' + '/edit/' + slug;
            info('Mohon tunggu sebentar..');
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    showEditModal(response.data);
                    Swal.close();
                },
                error: function(error, xhr) {
                    errorAlert(error.message);
                }
            });
        }
    </script>
    @if (session()->has('success'))
        <script>
            successAlert('{{ session('success') }}');
        </script>
    @endif
    @stack('scripts')
</body>

</html>
