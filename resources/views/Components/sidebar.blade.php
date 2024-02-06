<div class="container w-20p vh-100 bg-success bg-opacity-75 position-absolute shadow" id="sidebar">
    <div class="px-2 mt-4 pb-5">
        <img src="" alt="logo" class="img-fluid">
    </div>

    <div class="sidebar-menu mt-4">
        <p class="sidebar-title text-light mb-3 h6">Menu</p>
        <a href="#" id="sidebarButton" class="btn w-100"><i class="bi bi-house-door-fill"></i> Dashboard</a>

        <div class="accordion" onclick="toggleOverflowBar()">
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="" aria-controls="collapseOne">
                  Accordion Item #1
                </button>
              </h2>
              <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                </div>
              </div>
            </div>
        </div>

        <a href="#" id="sidebarButton" class="btn w-100"><i class="bi bi-folder2-open"></i> Data Barang</a>
        <a href="#" id="sidebarButton" class="btn w-100"><i class="bi bi-people-fill"></i> Karyawan</a>
    </div>

</div>

@push('scripts')
    <script>
        const sidebarButtons = $('a#sidebarButton');
        sidebarButtons.each(function(){
            $(this).on('mouseenter', function(){
                $(this).addClass('btn-success');
            }).on('mouseleave', function(){
                $(this).removeClass('btn-success');
            });
        });

        let isOverflow = 0;
        function toggleOverflowBar(){
            if(isOverflow == 0){
                isOverflow = 1;
                $('#sidebar').addClass('overflow-scroll');
                // alert('s');
            }else if(isOverflow == 1){
                isOverflow = 0;
                $('#sidebar').removeClass('overflow-scroll');
                // alert('t');
            }
        }


    </script>
@endpush
