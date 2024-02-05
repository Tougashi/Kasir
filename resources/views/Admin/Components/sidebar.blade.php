<div class="container w-20p vh-100 bg-success bg-opacity-75 position-absolute shadow">
    <div class="px-2 mt-4 pb-5">
        <img src="" alt="logo" class="img-fluid">
    </div>

    <div class="sidebar-menu mt-4">
        <p class="sidebar-title text-light mb-2 h6">Menu</p>
        <a href="#" id="sidebarButton" class="btn w-100">Dashboard</a>
        <a href="#" id="sidebarButton" class="btn w-100">Data Barang</a>
        <a href="#" id="sidebarButton" class="btn w-100">Karyawan</a>
    </div>

</div>

@push('scripts')
    <script>
        let sidebarButtons = $('a#sidebarButton');
       sidebarButtons.each(function(){
        $(this).on('mouseenter', function(){
            $(this).addClass('btn-outline-light');
        }).on('mouseleave', function(){
            $(this).removeClass('btn-outline-light');
        });
       });
    </script>
@endpush
