@extends('Pages.Admin.Layout.index')
@section('content')
<div class="card">
        <div class="p-4 border rounded">
            <form class="row g-3" action="{{ url()->current().'/store'}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3 col-md">
                    @error('image')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <label  for="inputProductDescription" class="form-label">Unggah Foto Profil </label>
                    <input id="image-uploadify" type="file" name="image" accept="image/*" class="form-control" required>   
                </div>
                <div class="col-md-4">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" name="email" id="email" placeholder="contoh@gmail.com" required>
                    @error('email')
                    <div class="invalid-feedback">Isi Email dengan benar</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="username" class="form-label">Nama</label>
                    <input type="text" class="form-control" name="username" id="username" placeholder="Masukan Nama Disini" required>
                    @error('username')
                    <div class="invalid-feedback">Isi dengan benar!</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="roles" class="form-label">Peran</label>
                    <select class="form-select" name="roles" id="roles" required>
                        <option selected disabled value="">Pilih...</option>
                        <option value="Admin">Admin</option>
                        <option value="Cashier">Kasir</option>
                        <option value="Guest">Tamu (Sementara)</option>
                    </select>
                </div>
                <div class="col-md">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password diawali dengan Kapital dan menggunakan satu Angka atau Simbol" required>
                    @error('password')
                    <div class="invalid-feedback">Kata Sandi min 8</div>
                    @enderror
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="invalidCheck2" required>
                        <label class="form-check-label" for="invalidCheck2">Sudah benar?</label>
                    </div>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary" type="submit">Simpan</button>
                </div>
            </form>
        </div>
</div>
@endsection
