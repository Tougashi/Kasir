@extends('Pages.Admin.Layout.index')
@section('content')
    <div class="card">
        <div class="py-3 px-4">
            <x-add-button />
            <table class="table responsive dt" id="productTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Tanggal Kadaluarsa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->category->name }}</td>
                        <td>{{ $item->stock }}</td>
                        <td>{{ $item->price }}</td>
                        <td>{{ \Illuminate\Support\Carbon::parse($item->expiredDate)->format('d F Y') }}</td>
                        <td>
                            <a href="javascript:void(0)" class="badge btn btn-secondary"
                                onclick="edit('{{ $item->code }}')"><i class="bi bi-pencil-square m-auto"></i></a>
                            <a href="javascript:void(0)" class="badge btn btn-danger"
                                onclick="deleteModal('{{ $item->code }}')"><i class="bi bi-trash m-auto"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
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
@endsection
@push('scripts')
    <script>
        $().ready(function() {
            initTable('#productTable');
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
                <form action="${currentUrl+'/update/'+data.product.code}" method="POST" class="row">
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
                                    // Periksa apakah ID pemasok cocok dengan ID pemasok produk
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

        function reinitDatatable(data){
            refreshDatatable(data, [
                {
                    data: null,
                    render: function(data, type, row, meta){
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "name",
                },
                {
                    data: "category.name",
                },
                {
                    data: "stock",
                },
                {
                    data: "price",
                },
                {
                    data: null,
                    render: function(data, type, row){
                        return `
                        <a href="javascript:void(0)" class="badge btn btn-secondary"
                                onclick="edit('${row.code}')"><i class="bi bi-pencil-square m-auto"></i></a>
                        <a href="javascript:void(0)" class="badge btn btn-danger"
                            onclick="deleteModal('${row.code}')"><i class="bi bi-trash m-auto"></i></a>
                        `;
                    }
                }
            ]);
        }
    </script>
@endpush
