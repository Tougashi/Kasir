@extends('Pages.Admin.Layout.index')
@section('content')
<div class="card pt-3 px-3 pb-4">
    <div class="container">
        <form action="" class="row">
            <div class="col-lg-6">
                <label for="code">Kode Produk</label>
                <input type="text" name="code" id="code" class="form-control">
            </div>
            <div class="col-lg-6">
                <label for="name">Nama Produk</label>
                <input type="text" name="name" id="name" class="form-control">
            </div>
            <div class="col-lg-6">
                <label for="categoryId">Pilih Kategori</label>
                <select name="categoryId" class="form-control" id="categoryId">
                    <option value="">Pilih Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-6">
                <label for="categoryId">Pilih Kategori</label>
                <select name="categoryId" class="form-control" id="categoryId">
                    <option value="">Pilih Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
</div>

@endsection
