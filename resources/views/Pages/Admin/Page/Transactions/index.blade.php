@extends('Pages.Admin.Layout.index')

@section('content')
    <div class="card">
        <div class="container py-3">
            {{-- <x-add-button /> --}}
            <table class="table table-responsive dt">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Admin</th>
                        <th>Nama Pelanggan</th>
                        <th>Nama Produk</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th>Tanggal Transaksi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{$item['adminName']}}</td>
                            <td>{{ $item['custName'] }}</td>
                            <td>
                                <ol>
                                    @foreach ($item['products'] as $product)
                                        <li>{{ $product }}</li>
                                    @endforeach
                                </ol>
                            </td>
                            <td>
                                {{-- <ol> --}}
                                    @foreach ($item['qty'] as $qty)
                                        <p>{{ $qty }}</p>
                                    @endforeach
                                {{-- </ol> --}}
                            </td>
                            <td>{{ $item['totalPrice'] }}</td>
                            <td>{{ $item['transactionDate'] }}</td>
                            <td>{{ $item['status'] }}</td>
                            <td>
                                <a href="{{url()->current().'/details/'.encrypt($item['transactionId'])}}/show" class="badge btn btn-primary"><i
                                        class="bi bi-eye m-auto"></i></a>
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
        $().ready(function() {
            initTable('.dt');
        });
    </script>
@endpush
