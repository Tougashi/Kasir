@extends('Pages.Admin.Layout.index')
@section('content')

<div class="card">
    <div class="container py-3 px-4">
        <form action="{{url()->current().'/store'}}" method="POST" class="row">
            @csrf
            <div class="col-6">
                <div class="form-group">
                    <label for="code">Kode Supplier</label>
                    <input type="text" name="code" id="code" class="form-control {{$errors->has('code') ? 'is-invalid' : ''}}" value="{{old('code')}}">
                    @if($errors->first('code'))
                        <div class="invalid-feedback">{{$errors->first('code')}}</div>
                    @endif
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="name">Nama Supplier</label>
                    <input type="text" name="name" id="name" class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" value="{{old('name')}}">
                    @if($errors->first('name'))
                        <div class="invalid-feedback">{{$errors->first('name')}}</div>
                    @endif
                </div>
            </div>
            <div class="col-12 d-flex row gap-2 m-auto px-0 py-3">
                <div class="col-lg-2 col-md-3 col-12 order-lg-1 order-md-1 order-2">
                    <a href="/admin/suppliers" class="btn btn-secondary w-100">Kembali</a>
                </div>
                <div class="col-lg-2 col-md-3 col-12 d-flex justify-content-end order-lg-2 order-md-2 order-1 ms-lg-auto ms-md-auto m-0">
                    <button type="submit" class="btn btn-primary w-100" onclick="info('Mohon Tunggu Sebentar...')">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
