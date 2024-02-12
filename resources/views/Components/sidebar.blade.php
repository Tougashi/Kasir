<div class="container w-20p bg-white position-absolute shadow overflow-auto" id="sidebar" style="border-right: 2px solid #007bff;">
    {{-- <div class="position-absolute bg-body border border-start-0 my-2 rounded-3 rounded-start-0"
        style="left: 215px; z-index: 100;">
        <div class="" onclick="toggleSidebar()" id="sidebarToggler">
            <i class="bi bi-list h2"></i>
        </div>
    </div> --}}
    <div class="px-2 mt-4 pb-4">
        <img src="/assets/images/logo-text2.png" alt="logo" class="img-fluid mt-2">
    </div>
    <hr class="text-primary">
    <h5 class="sidebar-title text-white text-center mb-3 menu bg-primary rounded">MENU</h5>
    <hr class="text-primary">
    <div class="sidebar-menu mt-4 mb-5">
        <ul class="">
            <li class="metismenu">
                <a href="/admin/dashboard" class="{{$title == 'Dashboard' ? 'metismenu-active' : ''}}">
                    <div class="parent-icon"><i class='bi bi-house-door'></i></div>
                    <div class="menu-title">Dashboard</div>
                </a>
            </li>
            <li class="">
                <ul class="metismenu d-block" id="menu" >
                    <li class="{{$title == 'Daftar Produk' || $title == 'Tambah Produk' || $title == 'Stock-in Produk' ? 'mm-active' : ''}}">
                        <a class="has-arrow {{$title == 'Daftar Produk' || $title == 'Tambah Produk' ? 'metismenu-active' : ''}}" href="javascript:void(0)" aria-expanded=""><i class="bi bi-database-gear"></i> Data Produk</a>
                        <ul>
                            <li class="mm-show">
                                <a href="/admin/products" class="{{$title == 'Daftar Produk' ? 'metismenu-active' : ''}}">
                                    <div class="parent-icon"><i class="bi bi-dash-lg"></i></div>
                                    <div class="menu-title">List Produk</div>
                                </a>
                            </li>
                            <li class="mm-show">
                                <a href="/admin/products/add" class="{{$title == 'Tambah Produk' ? 'metismenu-active' : ''}}">
                                    <div class="parent-icon"><i class="bi bi-dash-lg"></i></div>
                                    <div class="menu-title">Tambah Produk</div>
                                </a>
                            </li>
                            <li class="mm-show">
                                <a href="/admin/products/stock-in" class="{{$title == 'Stock-in Produk' ? 'metismenu-active' : ''}}">
                                    <div class="parent-icon"><i class="bi bi-dash-lg"></i></div>
                                    <div class="menu-title">Stock-in Produk</div>
                                </a>
                            </li>

                        </ul>
                    </li>
                </ul>
            </li>
            <li class="">
                <ul class="metismenu d-block" id="menu">
                    <li class="{{$title == 'Daftar Kategori' || $title == 'Tambah Kategori' ? 'mm-active' : ''}}">
                        <a class="has-arrow {{$title == 'Daftar Kategori' || $title == 'Tambah Kategori' ? 'metismenu-active' : ''}}" href="javascript:void(0)" aria-expanded=""><i class="bi bi-tags"></i> Kategori Produk</a>
                        <ul>
                            <li class="mm-show">
                                <a href="/admin/products/categories" class="{{$title == 'Daftar Kategori' ? 'metismenu-active' : ''}}">
                                    <div class="parent-icon"><i class="bi bi-dash-lg"></i></div>
                                    <div class="menu-title">Daftar Kategori</div>
                                </a>
                            </li>
                            <li class="mm-show">
                                <a href="/admin/products/categories/add" class="{{$title == 'Tambah Kategori' ? 'metismenu-active' : ''}}">
                                    <div class="parent-icon"><i class="bi bi-dash-lg"></i></div>
                                    <div class="menu-title">Tambah Kategori</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="metismenu">
                <a href="/admin/suppliers" class="{{$title == 'Supplier' || $title == 'Tambah Supplier' ? 'metismenu-active' : ''}}">
                    <div class="parent-icon"><i class="bi bi-truck"></i></div>
                    <div class="menu-title">Supplier</div>
                </a>
            </li>
            <li class="metismenu">
                <a href="/admin/transaction" class="{{$title == 'Transaksi' ? 'metismenu-active' : ''}}">
                    <div class="parent-icon"><i class='bi bi-credit-card-2-front'></i></div>
                    <div class="menu-title">Transaksi</div>
                </a>
            </li>
            <li class="metismenu">
                <a href="/admin/account" class="{{$title == 'Akun' ? 'metismenu-active' : ''}}">
                    <div class="parent-icon"><i class='bi bi-people'></i></div>
                    <div class="menu-title">Akun</div>
                </a>
            </li>
        </ul>
    </div>
</div>

<div class="vh-100 bg-white position-absolute shadow container hide-sidebar overflow-auto pb-5" id="sidebarIconOnly" style="">
    {{-- <div class="position-absolute bg-body border border-start-0 my-2 rounded-3 rounded-start-0"
        style="left: 75px; z-index: 100;">
        <div class="" onclick="toggleSidebar()" id="sidebarToggler">
            <i class="bi bi-list h2"></i>
        </div>
    </div> --}}
    <div class="mt-3 pb-5">
        <img src="/assets/images/logo-text2.png" alt="logo" class="img-fluid mt-2">
    </div>
    <div class="sidebar-menu d-flex justify-content-center">
        <ul class="metismenu" id="menuIconOnly">
            <li class="">
                <a href="/admin/dashboard" class="{{$title == 'Dashboard' ? 'metismenu-active' : ''}}" data-toggle="tooltip" title="Dashboard">
                    <div class="parent-icon"><i class='bi bi-house-door'></i></div>
                </a>
            </li>
            <li>
                <a href="/admin/products/add" class="{{$title == 'Daftar Produk' ? 'metismenu-active' : ''}}" data-toggle="tooltip" title="Daftar Produk">
                    <div class="parent-icon"><i class ="bi bi-list-columns"></i></div>
                </a>
            </li>

        </ul>
    </div>
</div>

@push('scripts')
<script>
        $().ready(function() {
            $('.metismenu').metisMenu();
        });

        let resizeScreen = () => {
            return $(window).width();
        }


        $(window).on('resize', function(){
            let screenWidth = resizeScreen();
            if(screenWidth <= 1000){
                $('#sidebar').addClass('hide-sidebar');
                $('#sidebarIconOnly').removeClass('hide-sidebar');
                $('#content').removeClass('w-80p');
            }else{
                $('#sidebar').removeClass('hide-sidebar');
                $('#sidebarIconOnly').addClass('hide-sidebar');
                $('#content').addClass('w-80p');
            }
        });

    </script>
@endpush
