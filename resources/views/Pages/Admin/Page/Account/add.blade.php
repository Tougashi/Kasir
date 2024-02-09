@extends('Pages.Admin.Layout.index')
@section('content')
<div class="card">
    <div class="card-body">
        <div class="p-4 border rounded">
            @if($message = Session::get('success'))
            <div class="alert alert-success" role="alert">
                <strong>{{ $message }}</strong>
            </div> 
            @endif
            <form class="row g-3" action="{{ route('account.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col-md-4">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" name="email" id="email" placeholder="contoh@gmail.com" required>
                </div>
                <div class="col-md-4">
                    <label for="username" class="form-label">Nama</label>
                    <input type="text" class="form-control" name="username" id="username" placeholder="Masukan Nama Disini" required>
                </div>
                <div class="col-md-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="********" required value="password">
                </div>
                <div class="col-md-">
                    <label for="roles" class="form-label">Peran</label>
                    <select class="form-select" name="roles" id="roles" required>
                        <option selected disabled value="">Pilih...</option>
                        <option value="Admin">Admin</option>
                        <option value="Cashier">Kasir</option>
                        <option value="Guest">Tamu (Sementara)</option>
                    </select>
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="invalidCheck2" required>
                        <label class="form-check-label" for="invalidCheck2">Sudah benar?</label>
                    </div>
                </div>
                 @error('account')
                 <span class="text-danger">{{ $message }}</span>
                 @enderror
                <div class="col-12">
                    <button class="btn btn-primary" type="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection