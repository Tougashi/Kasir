@extends('Pages.Admin.Layout.index')
@section('content')
    <div class="card">
        <div class="px-4 py-3">
            <div class="form-group">
                <label for="code" class="h6">Masukkan Kode Produk</label>
                <input type="text" name="code" id="code" class="form-control mt-1" placeholder="Kode Produk">
                <div id="information"></div>
            </div>
        </div>
    </div>
    <div id="inputStock" class="mt-2">
    </div>
@endsection
@push('scripts')
    <script>
        let isFullFilled = false;

        $('#code').on('input', function() {
            let inputVal = $(this).val();
            if (inputVal[0] == ' ') {
                $(this).val('');
            } else {
                let inputLength = $(this).val().length;
                let infoText = $('#information');
                if (inputLength <= 5) {
                    isFullFilled = false;
                    infoText.text('Masukkan setidaknya 5 karakter, anda baru memasukkan ' + inputLength +
                        ' Karakter');
                } else {
                    isFullFilled = true;
                    infoText.text('Tekan Enter untuk mencari');
                }
            }
        });

        $('#code').on('keypress', function(e) {
            if (isFullFilled) {
                if (e.which == 13) {
                    getProductData($(this).val());
                }
            }
        });

        function getProductData(value) {
            $.ajax({
                url: '/admin/products/get/' + value,
                method: 'GET',
                success: function(response) {
                    $('#inputStock').empty();
                    addToProduct(response.data);
                },
                error: function(error, xhr) {
                    errorAlert();
                    console.log(xhr.responseText);
                }
            });
        }

        function addToProduct(data) {
            $('#inputStock').append(`
            <div class="card">
            <div class="row px-4 py-3">
                <div class="col-12 mb-3"><h5>Hasil Pencarian Produk</h5></div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="code">Kode Produk</label>
                        <input type="text" name="code" value="${data['code']}" readonly id="code" class="form-control">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="name">Nama Produk</label>
                        <input type="text" name="name" value="${data['name']}" readonly id="name" class="form-control">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="stock">Masukkan jumlah stok</label>
                        <input type="number" name="stock" id="stock" oninput="checkValue()" value="0" class="form-control">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="expiredDate">Tanggal Kadaluarsa</label>
                        <input type="date" name="expiredDate" id="expiredDate" class="form-control">
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-end">
                    <button type="button" class="btn btn-primary" onclick="updateStock(event)">Simpan</button>
                </div>
            </div>
        </div>
            `);
        }

        function checkValue(){
            let value = $('#stock').val();
            // console.log(value)
            if(value <= 0){
                $('#stock').val('0');
            }else{
                $('#stock').val(parseInt(value, 10).toString());
            }
        };


        function updateStock(event){
            event.preventDefault();
            let code = $('#code');
            let stock = $('#stock');
            let expiredDate = $('#expiredDate');
            let formData;
            if(stock.val() > 0 && expiredDate.val()){
                formData = new FormData();
                formData.append('code', code.val());
                formData.append('stock', stock.val());
                formData.append('expiredDate', expiredDate.val());
            }

            if(formData){
                $.ajax({
                    url: currentUrl+'/update',
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response){
                        console.log(response);
                        successAlert(response);
                        $('#inputStock').empty();
                    },
                    eror: function(error, xhr){
                        errorAlert();
                        console.log(xhr.responseText);
                    }
                });
            }
        }
    </script>
@endpush
