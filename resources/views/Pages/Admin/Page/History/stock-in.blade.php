@extends('Pages.Admin.Layout.index')
@section('content')

<div class="card">
    <div class="container p-4">
        <table class="table table-responsive" id="recordTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Produk</th>
                    <th>Nama Produk</th>
                    <th>Nama Petugas</th>
                    <th>Jumlah</th>
                    <th>Tanggal Proses</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$product->product->code}}</td>
                    <td>{{$product->product->name}}</td>
                    <td>{{$product->user->username}}</td>
                    <td>{{$product->qty}}</td>
                    <td>{{$product->created_at->format('d F Y')}}</td>
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
            printTable('#recordTable',[0,1,2,3,4,5]);
        });
    </script>
@endpush
