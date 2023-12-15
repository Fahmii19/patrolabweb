@extends('layouts.admin')
@section('content')
    @component('components.dashboard.headpage')
        @slot('title')
            {{ $title }}
        @endslot
        @slot('bread')
            <li class="breadcrumb-item">Master Data</li>
            <li class="breadcrumb-item">{{ $title }}</li>
        @endslot
    @endcomponent
<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="d-flex mb-3 justify-content-end">
                <a href="{{route('user.create')}}" class="btn btn-success">Tambah User</a>
            </div>
            <div class="table-responsive">
                <table id="mytable" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th style="max-width: 40px;">No</th>
                            <th>Name</th>
                            <th>No Badge</th>
                            <th>List Area</th>
                            <th>Akses Level</th>
                            <th>Created At</th>
                            <th>Status</th>
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
        <form method="post" class="d-flex">
            @csrf
            @method('delete')
            <a id="edit" class="btn btn-warning me-2">Edit</a>
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
        ajax: "{{ route('user.datatable') }}",
        columns: [
            {
                data: 'DT_RowIndex',
                name: 'No'
            },
            {
                data: 'name',
                name: 'Nama User'
            },
            {
                data: 'no_badge',
                name: 'Nomor Badge'
            },
            {
                data: 'access_area',
                name: 'List Area'
            },
            {
                data: 'role',
                render: function(data, type, row) {
                    return '<span class="text-capitalize">' + row.role + '</span>'
                }
            },
            {
                data: 'created_at',
                name: 'created at'
            },
            {
                data: 'status',
                render: function(data, type, row) {
                    if (row.status == 'ACTIVED') {
                        return '<span class="badge badge-success">' + row.status + '</span>'
                    } else {
                        return '<span class="badge badge-danger">' + row.status + '</span>'
                    }
                }
            },
            {
                name: 'Action',
                data: 'action',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    console.log(data);
                    let html = $('#actionbase').clone();
                    html.find('#edit').attr('href', data.editurl);
                    let form = html.find('form').attr('action', data.deleteurl).attr('id', 'delete_form' + row.id);
                    form.find('button').attr('form-id', '#delete_form' + row.id);
                    return html.html();
                }
            }
        ]
    });
    active_menu("#data_master", "#user")
</script>
@endpush
@endsection
