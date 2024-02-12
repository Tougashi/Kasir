@extends('Pages.Admin.Layout.index')
@section('content')
    <div class="card">
        <div class="container py-3 px-4">
            <x-add-button />
            <table class="table table-resposive dt">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Supplier</th>
                        <th>Nama Supplier</th>
                        <th>Dibuat Pada</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($suppliers as $supplier)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $supplier->code }}</td>
                            <td>{{ $supplier->name }}</td>
                            <td>{{ $supplier->created_at->format('d F Y H:i') }}</td>
                            <td>
                                <a href="javascript:void(0)" class="badge btn btn-secondary"
                                    onclick="edit('{{ $supplier->code }}')"><i class="bi bi-pencil-square m-auto"></i></a>
                                <a href="javascript:void(0)" class="badge btn btn-danger"
                                    onclick="deleteModal('{{ $supplier->code }}')"><i class="bi bi-trash m-auto"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal" tabindex="-1" id="editModal">
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
    <x-show-to-edit />
@endsection
@push('scripts')
    <script>
        $().ready(function() {
            initTable('.dt');
        });

        $('#editModal').on('hidden.bs.modal', function(){
            $('.modal-title, .modal-body').empty();
        });

        function showEditModal(data) {
            $('#editModal').modal('show');
            $('.modal-title').text('Edit data supplier');
            $('.modal-body').append(`
            <form action="${currentUrl + '/update'}" method="POST" class="row">
                    @csrf
                    <div class="col-12">
                        <label for="code">Kode Supplier</label>
                        <input type="text" name="code" id="code" value="${data.code}" readonly class="form-control">
                    </div>
                    <div class="col-12">
                        <label for="name">Nama Supplier</label>
                        <input type="text" name="name" id="name" value="${data.name}" readonly class="form-control">
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
                    data: "code"
                },
                {
                    data: "name"
                },
                {
                    data: "created_at"
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
