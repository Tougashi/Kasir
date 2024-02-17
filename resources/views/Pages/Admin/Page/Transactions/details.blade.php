@extends('Pages.Admin.Layout.index')
@section('content')

<div class="card">
    <div class="container p-4">
        <div class="row gap-2 d-flex">
            <div class="col-5">
                <h6>Kode Transaksi : <span class="fw-normal">{{md5($transaction[0]['transactionId'])}}</span></h6>
            </div>
            <div class="col-5 ms-auto">
                <h6>Admin : <span class="fw-normal">{{$transaction[0]['admin']}}</span></h6>
            </div>
            <div class="col-5 me-auto">
                <h6>Waktu Transaksi : <span class="fw-normal">{{$transaction[0]['transactionDate']}}</span></h6>
            </div>
            <div class="col-5 ">
                <h6>Customer : <span class="fw-normal">{{$transaction[0]['customer']}}</span></h6>
            </div>
        </div>
        <table class="table table-responsive mt-4 text-center">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Jumlah Pembelian</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaction as $item)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>
                        <ul>
                            @foreach($item['products'] as $product)
                                <li>{{$loop->iteration}}. {{$product->name}}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <ul>
                            @foreach($item['totalQty'] as $qty)
                                <li>{{$qty}} Buah</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <ul>
                            @foreach($item['products'] as $product)
                                <li>{{$product->price}}</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-end">Subtotal</th>
                    <th>{{$transaction[0]['totalPrice']}}</th>
                </tr>
            </tfoot>
        </table>
        <div class="row py-3">
            <div class="col-lg-4 col-md-6 col-12 order-lg-1 order-md-1 order-2">
                <a href="/admin/transactions" class="btn btn-secondary w-100">Kembali</a>
            </div>
            <div class="col-lg-4 col-md-6 col-12 order-lg-1 order-md-1 order-2 ms-auto">
                <a href="javascript:void(0)" onclick="redirectNewTab()" class="btn btn-primary w-100">Cetak</a>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script>
        function redirectNewTab(){
            let url = '/admin/transactions/details/{{encrypt($transaction[0]["transactionId"])}}/print';
            window.open(url);
        }
    </script>
@endpush
