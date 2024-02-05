 <!DOCTYPE html>
 <html lang="en">

 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
	<link href="{{ asset('/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
	<link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet" />
	<link href="{{ asset('/assets/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap') }}" rel="stylesheet">
	<link href="{{ asset('/assets/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('/assets/css/icons.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!-- Bootstrap JS -->
	<script src="{{ asset('/assets/js/bootstrap.bundle.min.js') }}"></script>
	<!--plugins-->
	<script src="{{ asset('/assets/js/jquery.min.js') }}"></script>
	<script src="{{ asset('/assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
	<script src="{{ asset('/assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
	<script src="{{ asset('/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
	<script src="{{ asset('/assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
	<script src="{{ asset('/assets/plugins/sparkline-charts/jquery.sparkline.min.js') }}"></script>
</head>
<body style="overflow: hidden">
        <div class="wrapper">
            <div class="section-authentication-signin d-flex justify-content-center align-items-center my-5 ">
                <div class="container">
                    <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
                        <div class="col mx-auto">
                            <div class="card mt-auto rounded border-2 border-success">
                                <div class="card-body">
                                    <div class="p-4 rounded">
                                        <div class="text-center">
                                            <img src="/assets/image/logo-text.png" alt="Kasir" width="300" class="rounded mx-auto d-block">
                                        </div>
                                        <br>
                                        <div class="form-body">
                                            @if (Session::has('success'))
                                                <div class="alert alert-success" role="alert">
                                                    {{ Session::get('success') }}
                                                </div>
                                            @endif
                                            <form class="row g-3" action="{{ route('auth') }}" method="POST">
                                                @csrf
                                                <div class="col-12">
                                                    <label for="Username" class="form-label">Nama Pengguna</label>
                                                    <input type="text" class="form-control border border-dark" id="username" placeholder="Masukan Nama Pengguna" name="username">
                                                </div>
                                                <div class="col-12">
                                                    <label for="inputChoosePassword" class="form-label">Kata Sandi</label>
                                                    <div class="input-group" id="showHide">
                                                        <input type="password" class="form-control border border-dark" id="password" placeholder="Masukan Kata Sandi" name="password">
                                                        <a href="#" class="input-group-text bg-transparent border border-dark"><i class='bx bx-hide'></i></a>
                                                    </div>
                                                </div>
                                                <div class="col-md-6"><a href="#" class="text-success">Lupa Kata Sandi?</a></div>
                                                {{-- <div class="col-md-6 text-end"><a href="/registrasi" class="text-black">Belum Punya Akun?</a></div> --}}
                                                <div class="col-12">
                                                    <div class="d-grid">
                                                        <button type="submit" class="btn btn-success"><i class="bx bxs-lock-open"></i>Masuk</button>
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
    <footer class="bg-success shadow-sm border-top border-2 p-2 text-center fixed-bottom">
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
    <script src="{{ asset('assets/js/particles.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
 </body>

 </html>
