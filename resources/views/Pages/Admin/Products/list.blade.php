@extends('Pages.Admin.Layout.index')
@section('content')
    <div class="card">
        <div class="py-3 px-4">
            <table class="table responsive">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Tanggal Kadaluarsa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $item)
                        <th>{{$loop->iteration}}</th>
                        <th>{{$item->name}}</th>
                        <th>{{$item->category->name}}</th>
                        <th>{{$item->stock}}</th>
                        <th>{{$item->price}}</th>
                        <th>{{$item->expiredDate->format('d F Y')}}</th>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $().ready(function() {
            initTable('table');
        });
    </script>
@endpush
