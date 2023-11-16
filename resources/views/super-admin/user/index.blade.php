@extends('layouts.admin')
@section('content')
@component('components.dashboard.headpage')
@slot('title')
{{ $title }}
@endslot
@slot('bread')
<li class="breadcrumb-item">Data Master</li>
<li class="breadcrumb-item">{{ $title }}</li>
@endslot
@endcomponent
<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="d-flex mb-3 justify-content-end">
                <!-- <a href="{{route('user.create')}}" class="btn btn-success">Tambah User</a> -->
            </div>
            <table id="mytable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th style="max-width: 40px;">No</th>
                        <th>Name</th>
                        <th>No Badge</th>
                        <th>Akses Level</th>
                        <th>Created At</th>
                        <th>Status</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<!-- Container-fluid Ends-->
@push('js')
<script>
    $('#mytable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('user.datatable') }}",
        columns: [{
                data: 'DT_RowIndex',
                name: 'No'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'no_badge',
                name: 'no_badge'
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
            }
        ]
    });

    active_menu("#data_master", "#user")
</script>
@endpush

@endsection