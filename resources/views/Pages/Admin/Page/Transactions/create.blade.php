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
                        <select name="select2" class="" name="custId" id="custId" style="width: 100%;">
                            <option value="3" selected>Umum</option>
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
                    <p class="ms-2" id="custName">Umum</p>
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
            <div class="row gap-2">
                <div class="col-lg-4 col-md-4 col-12 order-lg-1 order-md-1 order-2">
                    <a href="/admin/transactions" class="btn btn-secondary w-100">Kembali</a>
                </div>
                <div class="col-lg-4 col-md-4 col-12 d-flex justify-content-end ms-auto order-lg-2 order-md-2 order-1">
                    <button type="button" onclick="processTransaction()" class="btn btn-primary w-100">Proses</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<script>
    $().ready(function() {
        $('#custId, #productId').select2();
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
        if(productCodeArr.includes(code)){
            let indexArr = productCodeArr.indexOf(code);
            console.log(`array index ke ${indexArr} dan di tableNumRows ke ${indexArr + 1}`);
        }else{
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
                error: function(error, xhr) {
                    errorAlert(error.message);
                    console.log(xhr.responseText);
                }
            });
        }
    }

    function renumberRows() {
        if(productCodeArr.length < 1){
            $('#transactionTable').empty().append(`
            <tr>
                <td colspan="6">Belum ada Data</td>
            </tr>
            `);
        }else{
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
            if(isNaN(parseInt(valQty))){
                valQty = 0;
            }else{
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

    function calculateInput(rowId){
        let valQty = $(`#inputQty${rowId}`).val();
        let valPrice = $(`#price${rowId}`).text();
        if(isNaN(parseInt(valQty))){
            valQty = 0;
        }else{
            let totalPrice = parseInt(valQty) * parseFloat(valPrice);
            $(`#subtotal${rowId}`).text(totalPrice);
            calculateTable();
        }
    }

    function processTransaction(){
        let totalProductArr = [];
        for(let i=0; i<=tableNumRows; i++){
            let total = $(`#inputQty${i}`).val();
            totalProductArr.push(total);
            totalProductArr = totalProductArr.filter(function(element){
                return element !== undefined;
            });
        }

        let custId = $('#custId').val();

        if(custId === '' || productCodeArr.length < 1){
            errorAlert('Data yang dibutuhkan tidak boleh Kosong');
        }else{
            let formData = new FormData();
            formData.append('totalProductArr', JSON.stringify(totalProductArr));
            formData.append('productCodeArr', JSON.stringify(productCodeArr));
            formData.append('totalPrice', $('#subtotalTotal').text());
            formData.append('custId', custId);

            $.ajax({
                url: currentUrl+'/process',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content'),
                },
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    info('Tunggu sebentar...');
                },
                success: function(response){
                    successAlert();
                    console.log(response.data);
                    resetAllChanges();
                },
                error: function (xhr, error) {
                    errorAlert(xhr.responseText);
                },
            }).done(function(){
                if(confirm('Apakah ingin cetak struk ?') === true){
                    console.log('true');
                }else{
                    console.log('false');
                }
            });
        }
    }

    function resetAllChanges(){
        $('#userId').val('0').change();
        $('#productId').val('').change();
        productCodeArr = [];
        tableNumRows = 0;
        $('#transactionTable').empty();
        renumberRows();
        calculateTable();
    }

</script>



@endpush

