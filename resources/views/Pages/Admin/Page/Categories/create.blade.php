@extends('Pages.Admin.Layout.index')
@section('content')
    <div class="card p-3">
        <div class="container">
            <form action="{{ url()->current() . '/store' }}" method="POST" class="row gap-2">
                @csrf
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="nama">Nama Kategori</label>
                        <input type="text" name="name" id="nama" value="{{ old('name') }}"
                            class="form-control mb-0 @if ($errors->has('name')) is-invalid @endif">
                        @if ($errors->has('name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="description">Deskripsi Kategori</label>
                        <textarea type="text" name="description" id="description"
                            class="form-control @if ($errors->has('description')) is-invalid @endif" cols="30">{{ old('description') }}</textarea>
                        @if ($errors->has('description'))
                            <div class="invalid-feedback">
                                {{ $errors->first('description') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-12 d-flex my-4">
                    <button type="submit" onclick="info('Mohon Tunggu Sebentar...')" class="btn btn-primary w-25 text-center ms-auto">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    @if (session()->has('success'))
        <script>
            successAlert('{{ session('success') }}');
        </script>
    @endif
@endpush
