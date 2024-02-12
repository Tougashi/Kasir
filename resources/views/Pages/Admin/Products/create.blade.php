@extends('Pages.Admin.Layout.index')
@section('content')
    <div class="card pt-3 px-3 pb-4">
        <div class="container">
            @if ($errors->any())
                {{ $errors }}
            @endif
            <form action="{{url()->current().'/store'}}" method="POST" class="row">
                @csrf
                <div class="col-lg-6">
                    <label for="code">Kode Produk</label>
                    <input type="text" name="code" id="code" class="form-control @if($errors->has('code')) is-invalid mb-0 @endif">
                    @if($errors->has('code'))
                    <div class="invalid-feedback mt-0">
                        {{$errors->first('code')}}
                    </div>
                    @endif
                </div>
                <div class="col-lg-6">
                    <label for="name">Nama Produk</label>
                    <input type="text" name="name" id="name" class="form-control @if($errors->has('name')) is-invalid mb-0 @endif">
                    @if($errors->has('name'))
                    <div class="invalid-feedback mt-0">
                        {{$errors->first('name')}}
                    </div>
                    @endif
                </div>
                <div class="col-lg-6">
                    <label for="categoryId">Pilih Kategori</label>
                    <select name="categoryId" class="form-control @if($errors->has('categoryId')) is-invalid mb-0 @endif" id="categoryId">
                        <option value="">Pilih Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('categoryId'))
                    <div class="invalid-feedback mt-0">
                        {{$errors->first('categoryId')}}
                    </div>
                    @endif
                </div>
                <div class="col-lg-6">
                    <label for="supplierId">Pilih Supplier</label>
                    <select name="supplierId" class="form-control @if($errors->has('supplierId')) is-invalid mb-0 @endif" id="supplierId">
                        <option value="">Pilih Supplier</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('supplierId'))
                    <div class="invalid-feedback mt-0">
                        {{$errors->first('supplierId')}}
                    </div>
                    @endif
                </div>
                <div class="col-lg-6">
                    <label for="price">Harga Produk</label>
                    <input type="number" name="price" id="price" class="form-control @if($errors->has('price')) is-invalid mb-0 @endif">
                    @if($errors->has('price'))
                    <div class="invalid-feedback mt-0">
                        {{$errors->first('price')}}
                    </div>
                    @endif
                </div>
                <div class="col-lg-6">
                    <label for="expiredDate">Tanggal Kadaluarsa</label>
                    <input type="date" name="expiredDate" id="expiredDate" class="form-control @if($errors->has('expiredDate')) is-invalid mb-0 @endif">
                    @if($errors->has('expiredDate'))
                    <div class="invalid-feedback mt-0">
                        {{$errors->first('expiredDate')}}
                    </div>
                    @endif
                </div>
                <div class="col-lg-12">
                    <label for="desc">Deskripsi Produk</label>
                    <textarea name="description" class="form-control @if($errors->has('description')) is-invalid mb-0 @endif"  id="" cols="30"></textarea>
                    @if($errors->has('description'))
                    <div class="invalid-feedback mt-0">
                        {{$errors->first('description')}}
                    </div>
                    @endif
                </div>
                <input type="hidden" name="stock" value="0">
                <div class="col-lg-12 row gap-2 mt-3 d-flex m-auto m-0 p-0">
                    <div class="col-lg-3 col-md-3 col-12 order-lg-1 order-md-1 order-2">
                        <a href="/admin/products" class="btn btn-secondary w-100">Kembali</a>
                    </div>
                    <div class="col-lg-3 col-md-3 col-12 d-flex ms-auto order-lg-2 order-md-2 order-1">
                        <button type="submit" class="btn btn-primary w-100">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
