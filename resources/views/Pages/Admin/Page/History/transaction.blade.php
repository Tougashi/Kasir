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
                        <th>Tanggal Transaksi</th>
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
                                {{array_sum(json_decode($transaction->quantity)).' buah'}}
                            </td>
                            <td>{{$transaction->totalPrice}}</td>
                            <td>{{$transaction->created_at->format('d F Y H:i')}}</td>
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
                                <button class="btn btn-sm btn-primary" onclick="detailTransaction('{{encrypt($transaction->id)}}')"><i class="bi bi-eye"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal modal-lg" tabindex="-1" id="transactionModal">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Detail Transaksi</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    @endsection
@push('scripts')
    <script>
        $().ready(function(){
            printTable('.dt', [0, 1,2,3,4,5]);
        });

        function detailTransaction(id){
            $.ajax({
                url: `/admin/transactions/details/${id}/get`,
                method: 'GET',
                beforeSend: function(){
                    info('Mohon tunggu sebentar ...');
                },
                success: function(response){
                    Swal.close();
                    console.log(response.data[0]);
                    showTransactionModal(response.data[0]);
                },
                error: function(xhr, error){
                    errorAlert(xhr.responseText);
                    console.log(error.message);
                },
            });
        }


        function showTransactionModal(data){
            let i = 0;
            $('#transactionModal').modal('show');
            $('.modal-body').empty().append(`
                <div class="row">
                    <div class="col-lg-6 col-12">
                        <p class="mb-0">Nama Pelanggan: ${data.admin}</p>
                        <p class="">Nama Petugas : ${data.customer}</p>
                    </div>
                    <div class="col-lg-6 col-12">
                        <p class="mb-0">Tanggal Transaksi : ${data.transactionDate}</p>
                        <p>Status Transaksi : ${data.status}</p>
                    </div>
                </div>
                <table class="table table-responsive table-hover table-bordered text-center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>${i+=1}</td>
                            <td>
                                <ol>
                                    ${data.products.map(product => `<li>${product.name}</li>`)}
                                </ol>
                            </td>
                            <td>
                                ${data.totalQty.map(qty => `<p>${qty}</p>`)}
                            </td>
                            <td>
                                ${data.products.map(product => `<p>${product.price}</p>`)}
                            </td>
                            <td>
                                ${data.products.map(({price}, index) => `<p>${price * data.totalQty[index]+'.00'}</p>`)}
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3"></th>
                            <th>Subtotal</th>
                            <th>${data.totalPrice}</th>
                        </tr>
                    </tfoot>
                </table>

            `);
        }

    </script>
@endpush
