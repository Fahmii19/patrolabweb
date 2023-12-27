@extends('layouts.admin')
@section('content')
    @component('components.dashboard.headpage')
        @slot('title')
            {{ $title }}
        @endslot
        @slot('bread')
            <li class="breadcrumb-item">Patrol</li>
            <li class="breadcrumb-item">{{ $title }}</li>
        @endslot
    @endcomponent
<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="d-flex mb-3 justify-content-end">
                <a href="{{route('patrol-area.create')}}" class="btn btn-success">Tambah Patrol Area</a>
            </div>
            <div class="table-responsive">
                <table id="mytable" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width:40px">No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Gambar</th>
                            <th>Koordinat</th>
                            <th>Status</th>
                            <th>Area</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="actionbase" class="d-none">
    <div class="d-flex">
        <form method="post" class="d-inline">
            @csrf
            @method('delete')
            <a id="show" class="btn btn-primary me-2">Detail</a>
            <a id="edit" class="btn btn-warning me-2 my-2 text-dark">Edit</a>
            <button onclick="hapus_data(event)" class="btn btn-danger me-2" type="button">Hapus</button>
        </form>
    </div>
</div>

<!-- Container-fluid Ends-->
@push('js')
<script>
    $('#mytable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('patrol-area.datatable') }}",
        columns: [
            {
                data: 'DT_RowIndex',
                name: 'No'
            },
            {
                data: 'code',
                name: 'Kode'
            },
            {
                data: 'name',
                name: 'Nama'
            },
            {
                data: 'image',
                name: 'Gambar Patrol Area',
                orderable: false,
                searchable: false,
            },
            {
                data: 'coordinat',
                name: 'Koordinat'
            },
            {
                data: 'status',
                render: function(data, type, row) {
                    if (row.status == 'ACTIVED') return `<span class="badge badge-success">${row.status}</span>`
                    return `<span class="badge badge-danger">${row.status}</span>`
                }
            },            
            {
                data: 'area',
                name: 'Nama Area'
            },
            {
                name: 'Action',
                data: 'action',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    console.log(data);
                    let html = $('#actionbase').clone();
                    html.find('#show').attr('href', data.showurl);
                    html.find('#edit').attr('href', data.editurl);
                    let form = html.find('form').attr('action', data.deleteurl)
                               .attr('id', 'delete_form' + row.id);
                    form.find('button').attr('form-id', '#delete_form' + row.id);
                    return html.html();
                }
            }
        ]
    });
    active_menu("#menu-patrol", "#sub-patrol-area")
</script>
@endpush
@endsection