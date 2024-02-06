<div class="container w-20p bg-white position-absolute shadow" id="sidebar" style="border-right: 2px solid #007bff;">
    <div class="px-2 mt-4 pb-4">
        <img src="/assets/images/logo-text2.png" alt="logo" class="img-fluid mt-2">
    </div>
    <hr class="text-primary">
    <h5 class="sidebar-title text-white text-center mb-3 menu bg-primary rounded">MENU</h5>
    <hr class="text-primary">
    <div class="sidebar-menu mt-4">
        <ul class="metismenu" id="menu">
          <li>
            <a href="/admin/dashboard" class="">
              <div class="parent-icon"><i class='bi bi-house-door'></i></div>
              <div class="menu-title">Dashboard</div>
            </a>
          </li>
          <li class="mm-active">
            <a href="#" class="has-arrow" aria-expanded="true">
              <div class="parent-icon"><i class="bx bx-category"></i></div>
              <div class="menu-title">Data Barang</div>
            </a>
            <ul>
              <li><a href=""><i class="bx bx-right-arrow-alt"></i>Email</a></li>
            </ul>
          </li>
          <li>
            <a href="/admin/products/list" class="">
              <div class="parent-icon"><i class="bi bi-list-columns"></i></div>
              <div class="menu-title">List Produk</div>
            </a>
          </li>
        </ul>
      </div>
</div>

@push('scripts')
    <script>
        const sidebarButtons = $('a#sidebarButton');
        sidebarButtons.each(function(){
            $(this).on('mouseenter', function(){
                $(this).addClass('btn-primary text-white');
            }).on('mouseleave', function(){
                $(this).removeClass('btn-primary text-white');
            });
        });


        $(document).ready(function () {
            $('#menu').metisMenu();
        });




    </script>
@endpush
