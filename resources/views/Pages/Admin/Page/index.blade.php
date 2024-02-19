@extends('Pages.Admin.Layout.index')
@section('plugins')
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="container rounded bg-body shadow m-1 py-2 row">
                <canvas id="myChart"></canvas>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="container rounded bg-body shadow m-1 py-2 row">
                <div class="col-6">
                    Sales Overview
                </div>
                <div class="col-6 d-flex justify-content-end">
                    Refresh
                </div>
                <div class="col-6 mt-3">
                    <p class="mb-0">Annual Sales</p>
                    <p class="fw-bold h5">Rp. 12,458</p>
                </div>
                <div class="col-6 mt-3 d-flex justify-content-end text-end">
                    <div class="">
                        <p class="mb-0">Annual Sales</p>
                        <p class="fw-bold h5">Rp. 12,458</p>
                    </div>
                </div>
                <div class="col-6 mt-3">
                    <p class="mb-0">Annual Sales</p>
                    <p class="fw-bold h5">Rp. 12,458</p>
                </div>
                <div class="col-6 mt-3 d-flex justify-content-end text-end">
                    <div class="">
                        <p class="mb-0">Annual Sales</p>
                        <p class="fw-bold h5">Rp. 12,458</p>
                    </div>
                </div>
            </div>
        </div>



    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/plugins/chart.js/dist/chart.umd.js') }}"></script>
    <script>

        let labels;
        let datas = [];

        $.ajax({
            url: '/admin/transactions/today',
            method: 'GET',
            success: function(response){
                labels = response.hours;
                response.transactions.map(data => {
                    datas.push(Object.values(data));
                });

            }
        }).done(function(){
            console.log(labels, datas);
            let ctx = $('#myChart');

            let data = {
                labels: labels,
                datasets: [{
                    label: 'Sales',
                    borderColor: 'blue',
                    borderWidth: 1,
                    data: datas
                }]
            };

            let myChart = new Chart(ctx, {
                type: 'bar',
                data: data,
            });

        });

    </script>
@endpush
