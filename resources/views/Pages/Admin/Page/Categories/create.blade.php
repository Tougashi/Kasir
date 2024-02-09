@extends('Pages.Admin.Layout.index')
@section('content')

<div class="card p-3">
    <div class="container">
        <form action="{{url()->current().'/store'}}" method="POST" class="row gap-2">
            @csrf
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="nama">Nama Kategori</label>
                    <input type="text" name="name" id="nama" value="{{old('name')}}" class="form-control @if($errors->all()) is-invalid @endif">
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="description">Deskripsi Kategori</label>
                    <textarea type="text" name="description" id="description" class="form-control @if($errors->all()) is-invalid @endif" cols="30">{{old('description')}}</textarea>
                </div>
            </div>
            <div class="col-lg-12 d-flex my-4">
                <button type="submit" class="btn btn-primary w-25 text-center ms-auto">Simpan</button>
            </div>
        </form>
    </div>
</div>

@endsection
@push('scripts')
    @if($errors->any())
        @foreach (json_decode(json_encode($errors->all()), true) as $error)
            <script>
                error('{{$error}}');
            </script>
        @endforeach
    @endif
    @if(session()->has('success'))
    <script>
        success('{{session("success")}}');
    </script>
    @endif
@endpush
