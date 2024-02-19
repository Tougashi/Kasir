@extends('Pages.Admin.Layout.index')
@section('content')
<div class="search-form">
    <input type="text" class="search-input" id="searchInput" placeholder="Search...">
    {{-- <button class="search-btn" onclick="searchProducts()">Search</button> --}}
</div>
<br>
<div id="alertExpProduct"></div>
<div class="container mt-5">
    <div class="row row-cols-1 row-cols-md-3 g-4" id="productContainer">
        @foreach ($products as $item)
        <div class="col">
            <div class="product-card flex-column justify-content-between d-flex {{$item->expiredDate <= now() ? 'card-danger' : ''}}" data-code="{{ $item->code }}" >
                <div class="product-image">
                    @if ($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" alt="Product Image" height="300" width="200">
                    @else
                        <img src="https://via.placeholder.com/300x200" alt="Product Image" height="40" width="auto">
                    @endif

                </div>  
                <div class="product-info" class="product">
                    <h6 class="product-code">Kode : {{ $item->code }}</h6>
                    <h5 class="product-title">{{ $item->name }}</h5>
                    <p class="product-category">{{ $item->category->name }}</p>
                    <p class="product-price">STOK : {{ $item->stock }}</p>
                    <p class="product-price">Rp {{ $item->price }}</p>
                    <p class="product-date">Tanggal Masuk {{ \Illuminate\Support\Carbon::parse($item->entryDate)->format('d F Y') }}</p>
                    <p class="product-date">Tanggal Kadaluarsa {{ \Illuminate\Support\Carbon::parse($item->expiredDate)->format('d F Y') }}</p>           
                    <div class="d-flex order-actions justify-content-between bg-danger">
                        <a href="javascript:void(0)" class="btn btn-primary btn-lg" onclick="edit('{{ $item->code }}')">
                            <i class='bi bi-eye-fill'></i>
                        </a>
                        <a href="javascript:void(0)" class="btn btn-danger btn-lg" onclick="deleteModal('{{ $item->code }}')">
                            <i class='bi bi-trash-fill'></i>
                        </a>
                    </div>
                    
                </div>
            </div>
        </div>
        @endforeach

        <div class="modal modal-lg" tabindex="-1" id="editModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    </div>
                </div>
            </div>
        </div>
        <x-show-to-edit />
    </div>
</div>


@endsection

@push('scripts')
@php
    $cek = \App\Models\Product::where('expiredDate', '<=', now())->count();
@endphp
@if ($cek > 0)
    <script>
        alertExpProduct();
    </script>
@endif
    <script>
        $().ready(function() {
            initTable('#product');
        });

        $('#editModal').on('hidden.bs.modal', function() {
            $('.modal-title, .modal-body').empty();
        });

        let categories;
        let suppliers;

        function showEditModal(data) {
            categories = data.categories;
            suppliers = data.suppliers;
            $('#editModal').modal('show');
            $('.modal-title').text('Edit data Produk ' + data.product.name);
            $('.modal-body').append(`
                <form action="${currentUrl+'/update/'+data.product.code}" method="POST" class="row" enctype="multipart/form-data">
                    @csrf
                    <div class="col-6">
                        <div class="form-group">
                            <label for="code">Kode Produk</label>
                            <input type="text" name="code" readonly value="${data.product.code}" id="code" class="form-control">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">Nama Produk</label>
                            <input type="text" name="name" readonly value="${data.product.name}" id="name" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label for="image">Gambar Produk</label>
                        <input type="file" name="image" id="image" value="${data.product.image}" class="form-control @if($errors->has('image')) is-invalid mb-0 @endif" onchange="previewImage()">
                        @if($errors->has('image'))
                            <div class="invalid-feedback mt-0">
                                {{$errors->first('image')}}
                            </div>
                        @endif
                        <img id="image-preview" src="#" alt="Preview" style="display: none; width: 100px; height: 100px; margin-top: 20px; margin-bottom: 20px;">
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="price">Harga Produk</label>
                            <input type="text" name="price" readonly value="${data.product.price}" id="price" class="form-control">
                        </div>
                    </div>
                    <input type="hidden" value="${data.product.stock}" name="stock">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="expiredDate">Tanggal Kadaluarsa</label>
                            <input type="date" name="expiredDate" readonly value="${data.product.expiredDate}" id="expiredDate" class="form-control">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="categoryId">Kategori Produk</label>
                            <select name="categoryId" disabled id="categoryId" class="form-control">
                                <option value=""></option>
                                <!-- Gunakan forEach untuk melakukan iterasi pada array suppliers -->
                                ${categories.map(category => {
                                    if (category.id == data.product.categoryId) {
                                        return `<option value="${category.id}" selected>${category.name}</option>`;
                                    } else {
                                        return `<option value="${category.id}">${category.name}</option>`;
                                    }
                                }).join('')}
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="supplierId">Supplier Produk</label>
                            <select name="supplierId" disabled id="supplierId" class="form-control">
                                <option value=""></option>
                                <!-- Gunakan forEach untuk melakukan iterasi pada array suppliers -->
                                ${suppliers.map(supplier => {
                                    if (supplier.id == data.product.supplierId) {
                                        return `<option value="${supplier.id}" selected>${supplier.name}</option>`;
                                    } else {
                                        return `<option value="${supplier.id}">${supplier.name}</option>`;
                                    }
                                }).join('')}
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="description">Deskripsi Produk</label>
                            <textarea name="description" id="description" readonly cols="30" class="form-control">${data.product.description}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" onclick="changeToEdit(event)"
                            id="submitBtn">Edit</button>
                    </div>
                </form>
                `);
        }

        function removeProductFromUI(code) {
            var productCard = $('.product-card[data-code="' + code + '"]');
            productCard.remove();
        }
        function deleteProduct(code) {
            $.ajax({
                url: '/delete-product',
                type: 'POST',
                data: { code: code },
                success: function(response) {
                    removeProductFromUI(code);
                    alert('Produk berhasil dihapus.');
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    alert('Terjadi kesalahan saat menghapus produk.');
                }
            });
        }

        $().ready(function() {
        initTable('#product');
        });
        function searchProducts() {
            var input, filter, productCards, productName, productCode, i;
            input = document.querySelector('.search-input');
            filter = input.value.toUpperCase();
            productCards = document.querySelectorAll('.product-card');

            for (i = 0; i < productCards.length; i++) {
                productName = productCards[i].querySelector('.product-title').textContent.toUpperCase();
                productCode = productCards[i].dataset.code.toUpperCase();
                if (productName.indexOf(filter) > -1 || productCode.indexOf(filter) > -1) {
                    productCards[i].style.display = "";
                } else {
                    productCards[i].style.display = "none";
                }
            }
        }

        document.querySelector('.search-input').addEventListener('input', function() {
            if (this.value === "") {

                var productCards = document.querySelectorAll('.product-card');
                productCards.forEach(function(card) {
                    card.style.display = "";
                });
            } else {
                searchProducts();
            }
        });


</script>

@endpush