@extends('Pages.Admin.Layout.index')
@section('content')
<div class="card p-3">
    <div class="container">
        <table class="table table-responsive dt">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th>Tanggal Pembuatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ( $categories as $category )
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$category->name}}</td>
                        <td>{{$category->description}}</td>
                        <td>{{$category->created_at->format('d F Y H:i')}}</td>
                        <td>
                            <a href="javascript:void(0)" class="badge btn btn-secondary" onclick="edit('{{$category->slug}}')"><i class="bi bi-pencil-square m-auto"></i></a>
                            <a href="javascript:void(0)" class="badge btn btn-danger" onclick="deleteModal('{{$category->slug}}')"><i class="bi bi-trash m-auto"></i></a>
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
  <x-show-to-edit/>
@endsection

@push('scripts')
    <script>
        $().ready(function(){
            initTable('.dt');
        });


        $('#editModal').on('hidden.bs.modal', function(){
            $('.modal-title, .modal-body').empty();
        });

        function showEditModal(data){
            $('#editModal').modal('show');
            $('.modal-title').text('Edit Data Kategori '+data.name);
            $('.modal-body').append(`
            <form class="row" action="${currentUrl+/update/+data.slug}" method="POST">
                @csrf
                <div class="col-12">
                    <label for="name">Nama Kategori</label>
                    <input type="text" name="name" id="name" readonly value="${data.name}" class="form-control">
                </div>
                <div class="col-12">
                    <label for="desc">Deskripsi</label>
                    <textarea name="description" id="desc" readonly class="form-control">${data.description}</textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" onclick="changeToEdit(event)" id="submitBtn">Edit</button>
            </div>
            </form>
            `);
        }

        function reinitDatatable(data){
            console.log(data);
            refreshDatatable(data, [
                {
                    data: null,
                    render: function(data, type, row, meta){
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                },
                {
                    data: "name"
                },
                {
                    data: "description"
                },
                {
                    data: "created_at"
                },
                {
                    data: null,
                    render: function(data, type, row){
                        return `
                        <a href="javascript:void(0)" class="badge btn btn-secondary" onclick="edit('${row.slug}')"><i class="bi bi-pencil-square m-auto"></i></a>
                        <a hrefjavascript:void(0)" class="badge btn btn-danger" onclick="deleteModal('${row.slug}')"><i class="bi bi-trash m-auto"></i></a>
                        `;
                    }
                }
            ]);
        }



    </script>
@endpush
