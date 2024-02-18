@extends('Pages.Admin.Layout.index')
@section('content')
    <div class="card">
        <div class="container p-4">
            <table class="table table-responsive dt">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Transaksi</th>
                        <th>Nama Pelanggan</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{md5($transaction->id)}}</td>
                            <td>{{$transaction->customer->username}}</td>
                            <td>
                                @foreach (json_decode($transaction->quantity) as $qty)
                                    {{$qty++}}
                                @endforeach
                            </td>
                            <td>{{$transaction->totalPrice}}</td>
                            <td>
                                @php
                                    $status = $transaction->transaction->status
                                @endphp
                                @if($status === 'pending')
                                    <div class="btn bg-warning bg-opacity-50">Pending</div>
                                @elseif($status === 'success')
                                    <div class="btn bg-success bg-opacity-50">Selesai</div>
                                @else
                                    <div class="btn bg-danger bg-opacity-50">Dibatalkan</div>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-primary"><i class="bi bi-eye"></i></button>
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
            printTable('.dt');
        });
    </script>
@endpush
