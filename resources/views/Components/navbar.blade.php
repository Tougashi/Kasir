<nav class="navbar navbar-dark navbar-expand-lg w-80p float-end bg-white d-none d-lg-block">
    <div class="container">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mb-2 mb-lg-0 ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-primary" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Halo, {{auth()->user()->username}}</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item {{$title == 'Info Akun' ? 'active' : ''}}" href="/user/info"></a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="/logout">Log Out</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
