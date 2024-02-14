@extends('Pages.Admin.Layout.index')

@section('content')
    <div class="card">
        <div class="container py-3">
            <x-add-button/>
            <table class="table table-responsive dt">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Transaksi</th>
                        <th>Nama Pelanggan</th>
                        <th>Nama Propduk</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th>Tanggal Transaksi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $item)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{encrypt($item->transactionId)}}</td>
                        <td>
                            {{$item->productId}}
                            {{$item->quantity}}
                        </td>
                        <td>{{$item->totalPrice}}</td>
                        <td>{{$item->created_at->format('d F Y')}}</td>
                        <td>
                            <a href="javascript:void(0)" class="badge btn btn-danger"
                            onclick="deleteModal('{{ encrypt($item->transactionId) }}')"><i class="bi bi-trash m-auto"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $().ready(function(){
            initTable('.dt');
        });
    </script>
@endpush
