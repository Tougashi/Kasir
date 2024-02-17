<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kopsis | {{ $title }}</title>
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link href="{{ url('https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700;800&display=swap') }}"
        rel="stylesheet">
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/logo.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/logo.png') }}">
</head>
<style>
    * {
        font-family: 'Poppins';
    }
</style>

<body onafterprint="reset()">
    <div class="container mt-3 py-3 mb-3 shadow px-3" id="wrapper">
        <div class="invoice-header bg-success bg-opacity-25 p-4">
            <div class="row d-flex">
                <div class="col-lg-5 col-12 row align-items-center">
                    <div class="col-6">
                        <img class="mb-3 img-fluid p-0 m-0"
                            src="{{ asset('assets/images/logo-text.png') }}" />
                    </div>
                    <div class="col-6">
                        <ul class="list-unstyled">
                            <li><strong>Koperasi Siswa</strong></li>
                            <li>SMK Negeri 2</li>
                            <li>Kota Tasikmalaya</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-7 col-12 my-3">
                    <h1>Invoice <small>Transaksi</small></h1>
                    <h6 class="text-muted">NO: {{ md5($transaction[0]['transactionId']) }} | Waktu Transaksi:
                        {{ $transaction[0]['transactionDate'] }}</h6>
                </div>
            </div>
        </div>
        <div class="invoice-body my-4">
            <div class="row">
            <div class="col-12">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title">Customer Details</h3>
                </div>
                <div class="">
                    <p class="mb-0">Name</p>
                    <p class="fw-normal">{{$transaction[0]['customer']}}</p>
                </div>
              </div>
            </div>
          </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title mt-3">Services / Products</h3>
                </div>
                <table class="table table-bordered table-condensed mb-4">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th class="text-center">Nama Produk</th>
                            <th class="text-center">Jumlah Produk</th>
                            <th class="text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaction as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td class="text-center">
                                @foreach ($item['products'] as $product)
                                    <p>{{$loop->iteration}}. {{$product->name}}</p>
                                @endforeach
                            </td>
                            <td class="text-center">
                                @foreach ($item['totalQty'] as $qty)
                                    <p>{{$qty}}</p>
                                @endforeach
                            </td>
                            <td class="text-center">
                                @foreach ($item['products'] as $price)
                                    <p>{{$price->price}}</p>
                                @endforeach
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="panel panel-default">
                <table class="table table-bordered table-condensed">
                    <thead>
                        <tr>
                            <td class="text-center col-xs-1">Sub Total</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="text-center rowtotal mono">{{$transaction[0]['totalPrice']}}</th>
                        </tr>
                    </tbody>
                </table>
            </div>


        </div>

    </div>
    <script>
        $().ready(function(){
            $('#wrapper').removeClass('shadow container');
            window.print();
        });

        function reset(){
            $('#wrapper').addClass('shadow container');
        }

        $(window).on('keydown', function(event){
            if((event.ctrlKey || event.metaKey) && event.key === 'p'){
                $('#wrapper').removeClass('shadow container');
                event.preventDefault();
                window.print();
            }
        });

      </script>
</body>

</html>
