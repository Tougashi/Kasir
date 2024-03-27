<div class="sidebar close">
    <div class="logo-details">
        <i class="icon"><img src="{{ asset('assets/images/logo.png') }}" alt="" width="30" class="img-fluid"></i>
        <span class="logo_name mt-1">KOPERASI SISWA</span>
    </div>
    <ul class="nav-links">
        <li>
            <a href="/dashboard">
                <i class='bx bx-grid-alt' ></i>
                <span class="link_name">Dashboard</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="#">Dashboard</a></li>
            </ul>
        </li>
        <li>
            <div class="iocn-link">
                <a href="#">
                    <i class='bx bx-collection' ></i>
                    <span class="link_name">Produk</span>
                </a>
                <i class='bx bxs-chevron-down arrow'></i>
            </div>
            <ul class="sub-menu">
                <li><a class="link_name" href="#">Produk</a></li>
                <li><a href="/products">Daftar Produk</a></li>
                <li><a href="/products/add">Tambah Produk</a></li>
                <li><a href="/products/stock-in">Tambah Stok</a></li>
            </ul>
        </li>
        <li>
            <div class="iocn-link">
                <a href="/transactions">
                    <i class='bx bx-cart' ></i>
                    <span class="link_name">Transaksi</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">Transaksi</a></li>
                </ul>
            </div>
        </li>
        <li>
            <div class="iocn-link">
                <a href="#">
                    <i class='bx bx-purchase-tag-alt'></i>
                    <span class="link_name">Kategori</span>
                </a>
                <i class='bx bxs-chevron-down arrow'></i>
            </div>
            <ul class="sub-menu">
                <li><a class="link_name" href="#">Kategori</a></li>
                <li><a href="/products/categories">Daftar Kategori</a></li>
                <li><a href="/products/categories/add">Tambah Kategori</a></li>
            </ul>
        </li>
        <li>
            <a href="/suppliers">
                <i class='bx bx-package' ></i>
                <span class="link_name">Pemasok</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="#">Pemasok</a></li>
            </ul>
        </li>
        <li>
            <div class="iocn-link">
                <a href="#">
                    <i class='bx bx-history'></i>
                    <span class="link_name">Riwayat</span>
                </a>
                <i class='bx bxs-chevron-down arrow'></i>
            </div>
            <ul class="sub-menu">
                <li><a class="link_name" href="#">Riwayat</a></li>
                <li><a href="/history/transactions">Transaksi</a></li>
                <li><a href="/history/stock-in">Stok Masuk</a></li>
            </ul>
        </li>
        <li>
            <a href="/account">
                <i class='bx bx-group' ></i>
                <span class="link_name">Akun</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="#">Akun</a></li>
            </ul>
        </li>
        <li>
            <div class="profile-details">
                <div class="profile-content">
                    @php
                    $user = auth()->user();
                    $profileImage = $user->image ? asset('storage/' . $user->image) : asset('assets/images/icons/profile-icon.jpg');
                    @endphp
                    <a href="/profile">
                        <img src="{{ $profileImage }}" alt="profileImg" class="img-fluid rounded-circle bg-dark p-1"/>
                    </a>
                    <ul class="sub-menu blank">
                        <li><a class="link_name" href="#">Profil</a></li>
                    </ul>
                </div>
                <div class="name-job">
                    @if (auth()->check())
                        <div class="profile_name">{{ $user->username }}</div>
                        <div class="job
                        @if (auth()->user()->roles)
                            @if (auth()->user()->roles === 'Admin') text-primary
                            @elseif (auth()->user()->roles === 'Kasir') text-success
                            @endif
                        @endif">{{ auth()->user()->roles }}</div>
                    @endif
                </div>
                <div class="profile-actions">
                    <a href="{{ route('logout') }}"><i class="bx bx-log-out" id="log_out"></i></a>
                </div>
            </div>
        </li>
        
    </ul>
</div>



@push('scripts')
    <script>
        let arrow = document.querySelectorAll(".arrow");
        for (var i = 0; i < arrow.length; i++) {
            arrow[i].addEventListener("click", (e)=>{
        let arrowParent = e.target.parentElement.parentElement;
        arrowParent.classList.toggle("showMenu");
            });
        }
        let sidebar = document.querySelector(".sidebar");
        let sidebarBtn = document.querySelector(".bx-menu");
        console.log(sidebarBtn);
        sidebarBtn.addEventListener("click", ()=>{
            sidebar.classList.toggle("close");
        });
    </script>    
@endpush
