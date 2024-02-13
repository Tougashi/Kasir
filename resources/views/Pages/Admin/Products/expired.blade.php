@extends('Pages.Admin.Layout.index')
@section('content')

<div class="card">
    <div class="py-3 px-4">
        {{-- <x-add-button /> --}}
        <table class="table responsive dt table-bordered text-center" id="mytable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Harga</th>
                    <th>Tanggal Masuk</th>
                    <th>Tanggal Kadaluarsa</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->category->name }}</td>
                    <td>{{ $item->stock }}</td>
                    <td>{{ $item->price }}</td>
                    <td>{{ \Illuminate\Support\Carbon::parse($item->entryDate)->format('d F Y H:i') }}</td>
                    <td><p class="text-danger fw-bold">{{ \Illuminate\Support\Carbon::parse($item->expiredDate)->format('d F Y H:i') }}</p></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
@push('scripts')
    <script>
        initTable('#mytable');
    </script>
@endpush
