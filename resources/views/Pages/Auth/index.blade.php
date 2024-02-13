 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/logo.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/logo.png">
	<link href="{{ asset('/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('/assets/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('/assets/css/icons.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!-- Bootstrap JS -->
	<script src="{{ asset('/assets/js/bootstrap.bundle.min.js') }}"></script>
	<!--plugins-->
	<script src="{{ asset('/assets/js/jquery.min.js') }}"></script>
</head>
<body style="">
        <div class="wrapper">
            <div class="d-flex justify-content-center align-items-center">
                <div class="container">
                    <br><br><br><br>
                    <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
                        <div class="col-20 mx-auto" style="width: 500px;">
                            <div class="card mt-auto border-primary my-5 border-2 rounded">
                                <div class="card-body">
                                    <div class="p-4 rounded">
                                        <div class="text-center">
                                            <img src="/assets/images/logo-text2.png" alt="Kasir" width="300" class="rounded mx-auto d-block">
                                        </div>
                                        <br>
                                        <div class="form-body mt-4">
                                            @if (Session::has('success'))
                                                <div class="alert alert-success" role="alert">
                                                    {{ Session::get('success') }}
                                                </div>
                                            @endif
                                            <form class="row g-3" action="{{ route('auth') }}" method="POST">
                                                @csrf
                                                <div class="col-12">
                                                    <label for="Username" class="form-label">Nama Pengguna</label>
                                                    <input type="text" class="form-control {{session('username') ? 'is-invalid' : 'border-primary'}}" id="username" placeholder="Masukan Nama Pengguna" required name="username" value="{{old('username')}}">
                                                    @if(session('username'))
                                                        <div class="text-danger">{{session('username')}}</div>
                                                    @endif
                                                </div>
                                                <div class="col-12">
                                                    <label for="inputChoosePassword" class="form-label">Kata Sandi</label>
                                                    <div class="input-group" id="showHide">
                                                        <input type="password" class="form-control  border border-primary" id="password" placeholder="Masukan Kata Sandi" required name="password">
                                                        <a href="#" class="input-group-text bg-transparent border border-primary"><i class='bx bx-hide'></i></a>
                                                    </div>
                                                </div>
                                                <div class="col-md-6"><a href="#">Lupa Kata Sandi?</a></div>
                                                {{-- <div class="col-md-6 text-end"><a href="/registrasi" class="text-black">Belum Punya Akun?</a></div> --}}
                                                <div class="col-12">
                                                    <div class="d-grid">
                                                        <button type="submit" class="btn text-white bg-primary"><i class="bx bxs-lock-open"></i>Masuk</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="bg-primary shadow-sm border-top border-2 p-2 text-center fixed-bottom bottom-0 w-100">
        <p class="mb-0 footer text-light">© KOPERASI SISWA SMKN 2 TASIKMALAYA</p>
    </footer>
    {{-- HIDE & SHOW PASSWORD --}}
    <script>
		$(document).ready(function () {
			$("#showHide a").on('click', function (event) {
				event.preventDefault();
				if ($('#showHide input').attr("type") == "text") {
					$('#showHide input').attr('type', 'password');
					$('#showHide i').addClass("bx-hide");
					$('#showHide i').removeClass("bx-show");
				} else if ($('#showHide input').attr("type") == "password") {
					$('#showHide input').attr('type', 'text');
					$('#showHide i').removeClass("bx-hide");
					$('#showHide i').addClass("bx-show");
				}
			});
		});
	</script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
 </body>

 </html>
