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
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="userId">Pilih Pelanggan</label>
                        <select name="select2" class="" name="userId" id="userId" style="width: 100%;">
                            <option value="" selected disabled ></option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->username }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md">
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
                        <th colspan="4">Subtotal</th>
                        <th id="subtotalTotal">0</th>
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

    let tableNumRows = 0;
    let priceArr = [];

    function addToTable() {
        let val = $('#productId').val();
        if (val) {
            getProductData(val);
        } else {
            errorAlert('Pilih Produk terlebih dahulu');
        }
    };

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
                calculateTable();
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
            <td id="price${tableNumRows}">${data.price}</td>
        </tr>
        `);
    }

    function removeRow(row) {
        $(`tr#${row}`).remove();
        calculateTable();
    }

    function calculateTable() {
        let qtyTotal = 0;
        let priceTotal = 0;
        for (let i = 1; i <= tableNumRows; i++) {
            let valQty = $(`#inputQty${i}`).val();
            let valPrice = $(`#price${i}`).text();
            let subtotal = parseInt(valQty) * parseFloat(valPrice);
            $(`#subtotal${i}`).text(subtotal);
            qtyTotal += parseInt(valQty);
            priceTotal += subtotal;
        }
        $('#qtyTotal').text(qtyTotal);
        $('#priceTotal').text(priceTotal);
        $('#subtotalTotal').text(priceTotal);
    }

    function calculateInput(rowId){
        let valQty = $(`#inputQty${rowId}`).val();
        let valPrice = $(`#price${rowId}`).text();
        let totalPrice = parseInt(valQty) * parseFloat(valPrice);
        $(`#subtotal${rowId}`).text(totalPrice);
        calculateTable();
    }

</script>

@endpush

