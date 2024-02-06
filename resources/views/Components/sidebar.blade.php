<div class="container w-20p vh-100 bg-white position-absolute shadow" id="sidebar" style="border-right: 2px solid #007bff;">
    <div class="px-2 mt-4 pb-4">
        <img src="/assets/images/logo-text2.png" alt="logo" class="img-fluid mt-2">
    </div>
    <hr class="text-primary">
    <h5 class="sidebar-title text-white text-center mb-3 menu bg-primary rounded">MENU
    </h5>
    
    <hr class="text-primary">
    <div class="sidebar-menu mt-4">
        <a href="#" id="sidebarButton" class="btn w-100 text-primary"><i class="bx bx-home-alt"></i> Dashboard</a>
    
        <div class="accordion" onclick="toggleOverflowBar()">
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="" aria-controls="collapseOne">
                  <div class="text"><i class=""></i>Accordion Item #1</div>
                </button>
              </h2>
              <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                </div>
              </div>
            </div>
        </div>
    
        <a href="#" id="sidebarButton" class="btn w-100 text-primary"><i class="bi bi-folder2-open"></i>Data Barang</a>
        <a href="#" id="sidebarButton" class="btn w-100 text-primary"><i class="bi bi-people-fill"></i> Karyawan</a>
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

        let isOverflow = 0;
        function toggleOverflowBar(){
            if(isOverflow == 0){
                isOverflow = 1;
                $('#sidebar').addClass('overflow-scroll');
            }else if(isOverflow == 1){
                isOverflow = 0;
                $('#sidebar').removeClass('overflow-scroll');
            }
        }


    </script>
@endpush
