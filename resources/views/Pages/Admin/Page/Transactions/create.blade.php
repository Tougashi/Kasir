@extends('Pages.Admin.Layout.index')
@section('plugins')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
@endsection
@section('content')
    <style>
        label {
            margin-bottom: 10px;
        }
    </style>

    <div class="card">
        <div class="container p-4">
            <div class="row">
                <div class="col-lg-6 my-2">
                    <div class="form-group">
                        <label for="userId">Pilih Pelanggan</label>
                        <select name="select2" class="" name="userId" id="userId" style="width: 100%;">
                            <option value=""></option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->username }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-6 my-2">
                    <label for="productId">Pilih Produk</label>
                    <div class="input-group flex-nowrap">
                        <select name="select2" class="" name="productId" id="productId" style="width: 100%;">
                            <option value=""></option>
                            @foreach ($products as $product)
                                <option value="{{ $product->code }}">{{ $product->code }} - {{ $product->name }}</option>
                            @endforeach
                        </select>
                        <span class="btn btn-sm btn-primary pb-0" onclick="addToTable()">Tambah</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="card py-3 my-4">
        <div class="container px-4">
            <div class="row">
                <div class="col-lg-6 d-flex">
                    <p class="fw-bold">Nama Customer :</p>
                    <p class="ms-2" id="custName"></p>
                </div>
                <div class="col-lg-6 d-flex">
                    <p class="fw-bold">Waktu Transaksi :</p>
                    <p class="ms-2" id="time"></p>
                </div>
            </div>
            <table class="table table-responsive text-center" id="regularTable">
                <thead>
                    <tr>
                        <th> </th>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody id="transactionTable">
                    <tr>
                        <td colspan="5">Belum ada Data</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3">Total</th>
                        <th id="qtyTotal">0</th>
                        <th id="priceTotal">0</th>
                    </tr>
                    <tr class="text-end">
                        <th colspan="4" class="">Subtotal</th>
                        <th>0</th>
                    </tr>
                </tfoot>
                <tbody id="transactionTable">
                </tbody>
            </table>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script>
        $().ready(function() {
            $('#userId, #productId').select2();
        });

        setInterval(() => {
            let currentTime = new Date().toLocaleString();
            $('#time').text(currentTime);
        }, 1000);

        $('#userId').on('change', function() {
            let textOptions = $('#userId option:selected').text();
            $('#custName').text(textOptions);
            calculateTable();
        });

        let selected = [];

        function addToTable() {
            let val = $('#productId').val();
            if (val) {
                if (!selected.includes(val)) {
                    selected.push(val)
                    getProductData(val);
                }
            } else {
                errorAlert('Pilih Produk terlebih dahulu');
            }
        };

        let tableNumRows = 0;

        let priceArr = [];

        function getProductData(code) {
            $.ajax({
                method: 'GET',
                url: '/admin/products/get/' + code,
                success: function(response) {
                    if (tableNumRows <= 0) {
                        $('#transactionTable').empty();
                    }
                    appendToTable(response.data);
                    priceArr.push(parseInt(response.data.price));
                },
                error: function(error, xhr) {
                    errorAlert(error.message);
                    console.log(xhr.responseText);
                }
            });
        }

        function appendToTable(data) {
            tableNumRows++;
            $('#transactionTable').append(`
            <tr id="${tableNumRows}">
                <td><button class="float-start btn btn-sm btn-danger pe-1" onclick="removeRow('${tableNumRows}')"><i class="bi bi-trash"></i></button></td>
                <td>${tableNumRows}</td>
                <td>${data.name}</td>
                <td>
                    <input type="number" id="inputQty${tableNumRows}" oninput="calculateInput('${tableNumRows}')" value="1" class="m-0 p-0 w-100 border-0 form-control text-center">
                </td>
                <td>${data.price}</td>
            </tr>
            `);
        }

        function removeRow(row) {
            $(`tr#${tableNumRows}`).remove();
            tableNumRows -= 1;
            calculateTable();
        }

        function calculateTable() {
            let val = [];
            for (let i = 0; i <= tableNumRows; i++) {
                let valQty = $(`#inputQty${i}`).val();
                if (parseInt(valQty) > 0 || valQty){
                    if(val[0] === 'undefined'){
                        val[0] = valQty;
                    }else{
                        val.push(valQty);
                    }
                }
            }
            console.log(val);
            console.log(priceArr);
        }

        function calculateInput(rowId){
            $(`tr#${rowId}`).find('td:nth-child');
        }
    </script>
@endpush

