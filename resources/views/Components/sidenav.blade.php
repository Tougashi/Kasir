 <!-- navbar -->
 <nav class="navbar">
    <div class="logo_item">
      <i class="bx bx-menu" id="sidebarOpen"></i>
      <img src="{{ asset('assets/images/logo.png') }}" alt="">Koperasi Siswa
    </div>
    <div class="navbar_content">
      <i class='bx bx-sun' id="darkLight"></i>
      <img src="{{ asset('assets/images/profile-icon.jpg') }}" alt="" class="profile" /> {{ auth()->user()->username }}
    </div>
  </nav>

  <!-- sidebar -->
  <nav class="sidebar">
    <div class="menu_content">
        <div class="top_content">
            <div class="top expand_sidebar">
              <span >MENU</span>
              <i class="bi bi-arrow-right-square-fill"></i>
            </div>
            <div class="top collapse_sidebar">
              <span>MENU</span>
              <i class="bi bi-arrow-left-square-fill"></i>
            </div>
          </div>
      <ul class="menu_items">
        <!-- start -->
        <li class="item">
            <a href="/admin/dashboard" class="nav_link {{$title == 'Dashboard' ? 'active' : ''}}">
                <span class="navlink_icon">
                    <i class="bi bi-house-door-fill"></i>
                </span>
                <span class="navlink">Dashboard</span>
            </a>
        </li>
          <!-- start -->
        <li class="item">
              <div href="#" class="nav_link submenu_item">
                  <span class="navlink_icon">
              <i class="bi bi-box-seam-fill"></i>
            </span>
            <span class="navlink">Produk</span>
            <i class="bx bx-chevron-right arrow-left"></i>
          </div>
          <ul class="menu_items submenu">
            <a href="/admin/products" class="nav_link sublink">Daftar Produk</a>
            <a href="/admin/products/add" class="nav_link sublink">Tambah Produk</a>
            <a href="/admin/products/stock-in" class="nav_link sublink">Tambah Stok</a>
          </ul>
        </li>
        <li class="item">
            <a href="/admin/transactions" class="nav_link">
                <span class="navlink_icon">
                    <i class="bi bi-cart-fill"></i>
                </span>
                <span class="navlink">Transaksi</span>
            </a>
        </li>
        <li class="item">
            <div href="#" class="nav_link submenu_item">
                <span class="navlink_icon">
                    <i class="bi bi-tags-fill"></i>
                </span>
                <span class="navlink">Kategori</span>
                <i class="bx bx-chevron-right arrow-left"></i>
                </div>
            <ul class="menu_items submenu">
                <a href="/admin/products/categories" class="nav_link sublink">Daftar Kategori</a>
                <a href="/admin/products/categories/add" class="nav_link sublink">Tambah Kategori</a>
            </ul>
        </li>
        <li class="item">
            <a href="/admin/suppliers" class="nav_link">
                <span class="navlink_icon">
                    <i class="bi bi-send-plus-fill"></i>
                </span>
                <span class="navlink">Pemasok</span>
            </a>
        </li>
        <li class="item">
            <div href="#" class="nav_link submenu_item">
                <span class="navlink_icon">
                <i class="bi bi-clock-fill"></i>
                </span>
                <span class="navlink">Riwayat</span>
                <i class="bx bx-chevron-right arrow-left"></i>
                </div>
            <ul class="menu_items submenu">
                <a href="/admin/history/transactions" class="nav_link sublink">Transaksi</a>
                <a href="/admin/history/stock-in" class="nav_link sublink">Stok Masuk</a>
            </ul>
        </li>
        <li class="item">
            <a href="/admin/account" class="nav_link">
                <span class="navlink_icon">
                    <i class="bi bi-people-fill"></i>
                </span>
                <span class="navlink">Akun</span>
            </a>
        </li>
        <!-- end -->
      </ul>
  </nav>


@push('scripts')
    <script>
        const body = document.querySelector("body");
        const darkLight = document.querySelector("#darkLight");
        const sidebar = document.querySelector(".sidebar");
        const submenuItems = document.querySelectorAll(".submenu_item");
        const sidebarOpen = document.querySelector("#sidebarOpen");
        const sidebarClose = document.querySelector(".collapse_sidebar");
        const sidebarExpand = document.querySelector(".expand_sidebar");
        sidebarOpen.addEventListener("click", () => sidebar.classList.toggle("close"));

        sidebarClose.addEventListener("click", () => {
        sidebar.classList.add("close", "hoverable");
        });
        sidebarExpand.addEventListener("click", () => {
        sidebar.classList.remove("close", "hoverable");
        });

        sidebar.addEventListener("mouseenter", () => {
        if (sidebar.classList.contains("hoverable")) {
            sidebar.classList.remove("close");
        }
        });
        sidebar.addEventListener("mouseleave", () => {
        if (sidebar.classList.contains("hoverable")) {
            sidebar.classList.add("close");
        }
        });

        darkLight.addEventListener("click", () => {
        body.classList.toggle("dark");
        if (body.classList.contains("dark")) {
            document.setI;
            darkLight.classList.replace("bx-sun", "bx-moon");
        } else {
            darkLight.classList.replace("bx-moon", "bx-sun");
        }
        });

        submenuItems.forEach((item, index) => {
        item.addEventListener("click", () => {
            item.classList.toggle("show_submenu");
            submenuItems.forEach((item2, index2) => {
            if (index !== index2) {
                item2.classList.remove("show_submenu");
            }
            });
        });
        });

        if (window.innerWidth < 768) {
        sidebar.classList.add("close");
        } else {
        sidebar.classList.remove("close");
        }

    </script>
@endpush
