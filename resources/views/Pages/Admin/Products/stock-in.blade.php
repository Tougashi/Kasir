@extends('Pages.Admin.Layout.index')
@section('content')

<div class="card">
    <div class="px-4 py-3">
        <div class="form-group">
            <label for="code" class="h6">Masukkan Kode Produk</label>
            <input type="text" name="code" id="code" class="form-control mt-1" placeholder="Kode Produk">
            <div id="information"></div>
        </div>
        <div id="selectProduct" class="mt-4">
            <table class="table table-responsive table-bordered">
                <thead>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Kode Produk</th>
                    <th>Stok Produk</th>
                    <th>Tanggal Kadaluarsa</th>
                </thead>
                <tbody id="tBodySelectStockin">
                    <tr id="initialRowSelect">
                        <td colspan="5">Belum ada Data</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="card mt-3">
    <div class="px-4 py-3">
        <table class="table table-responsive table-bordered">
            <thead>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Kode Produk</th>
                <th>Stok Produk</th>
                <th>Tanggal Kadaluarsa</th>
            </thead>
            <tbody id="tbodyStockIn">
                <tr id="initialRow">
                    <td colspan="5">Belum ada Data</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


@endsection
@push('scripts')
    <script>
        $('#code').on('input', function(){
            let inputLength = $(this).val().length;
            let infoText = $('#information');
            if(inputLength <= 5){
                infoText.text('Masukkan setidaknya 5 karakter, anda baru memasukkan '+inputLength+' Karakter');
                getProductData();
            }else{
                infoText.text('');
            }
        });

        function getProductData()

    </script>
@endpush
