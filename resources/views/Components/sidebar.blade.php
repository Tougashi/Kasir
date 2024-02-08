<div class="container w-20p bg-white position-absolute shadow" id="sidebar" style="border-right: 2px solid #007bff;">
    <div class="position-absolute bg-body border border-start-0 my-2 rounded-3 rounded-start-0"
        style="left: 215px; z-index: 100;">
        <div class="" onclick="toggleSidebar()" id="sidebarToggler">
            <i class="bi bi-list h2"></i>
        </div>
    </div>
    <div class="px-2 mt-4 pb-4">
        <img src="/assets/images/logo-text2.png" alt="logo" class="img-fluid mt-2">
    </div>
    <hr class="text-primary">
    <h5 class="sidebar-title text-white text-center mb-3 menu bg-primary rounded">MENU</h5>
    <hr class="text-primary">
    <div class="sidebar-menu mt-4">
        <ul class="" id="menu">
            <li>
                <a href="/admin/dashboard" class="">
                    <div class="parent-icon"><i class='bi bi-house-door'></i></div>
                    <div class="menu-title">Dashboard</div>
                </a>
            </li>
            <li class="">
                <ul id="menu" class="metismenu d-block">
                    <li class="">
                        <a class="has-arrow" href="#" aria-expanded="false">Data Produk</a>
                        <ul>
                            <li class="mm-show">
                                <a href="/admin/products/list" class="">
                                    <div class="parent-icon"><i class="bi bi-list-columns"></i></div>
                                    <div class="menu-title">Lst Produk</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>

<div class="vh-100 bg-white position-absolute shadow container hide-sidebar" id="sidebarIconOnly" style="">
    <div class="position-absolute bg-body border border-start-0 my-2 rounded-3 rounded-start-0"
        style="left: 75px; z-index: 100;">
        <div class="" onclick="toggleSidebar()" id="sidebarToggler">
            <i class="bi bi-list h2"></i>
        </div>
    </div>
    <div class="mt-3 pb-5">
        <img src="/assets/images/logo-text2.png" alt="logo" class="img-fluid mt-2">
    </div>
    <div class="sidebar-menu d-flex justify-content-center mt-5">
        <ul class="metismenu" id="menuIconOnly">
            <li>
                <a href="/admin/dashboard" class="">
                    <div class="parent-icon p-1"><i class='bi bi-house-door h5'></i></div>
                </a>
            </li>
            <li class="">
                <a href="/admin/dashboard" class="">
                    <div class="parent-icon p-1"><i class="bi bi-list-columns h5"></i></div>
                </a>
            </li>
            <li class="">
                <a href="/admin/dashboard" class="">
                    <div class="parent-icon p-1"><i class="bi bi-list-columns h5"></i></div>
                </a>
            </li>
            <li class="">
                <a href="/admin/dashboard" class="">
                    <div class="parent-icon p-1"><i class="bi bi-list-columns h5"></i></div>
                </a>
            </li>
            <li class="">
                <a href="/admin/dashboard" class="">
                    <div class="parent-icon p-1"><i class="bi bi-list-columns h5"></i></div>
                </a>
            </li>
        </ul>
    </div>
</div>

@push('scripts')
    <script>
        const sidebarButtons = $('a#sidebarButton');
        sidebarButtons.each(function() {
            $(this).on('mouseenter', function() {
                $(this).addClass('btn-primary text-white');
            }).on('mouseleave', function() {
                $(this).removeClass('btn-primary text-white');
            });
        });


        $().ready(function() {
            $('#menu').metisMenu();
        });



        let isToggledSidebar;
        const toggleSidebar = () => {
            if (isToggledSidebar == true) {
                isToggledSidebar = false;
                $('#sidebar').addClass('hide-sidebar');
                $('#sidebarIconOnly').removeClass('hide-sidebar');
            } else {
                isToggledSidebar = true;
                $('#sidebarIconOnly').addClass('hide-sidebar');
                $('#sidebar').removeClass('hide-sidebar');
            }
        }
    </script>
@endpush
