@extends('Pages.Admin.Layout.index')
@section('content')
<div class="card">
    <div class="py-3 px-4">
        <x-add-button/>
        <table id="dataTable" class="table responsive">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Peran</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->username }}</td>
                    <td>
                        @if($item->roles == 'Cashier')
                            Kasir
                        @elseif($item->roles == 'Guest')
                            Tamu
                        @else
                            {{ $item->roles }}
                        @endif
                    </td>
                    <x-show-delete-button/>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


@endsection
@push('scripts')
<script>
    $().ready(function(){
        initTable('#dataTable');
    });
</script>
@endpush
