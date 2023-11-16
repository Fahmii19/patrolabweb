@php
$page = 'audit_log';
@endphp
@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h3>{{ $title }}</h3>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"> <i data-feather="home"></i></a></li>
                    <li class="breadcrumb-item">Log</li>
                    <li class="breadcrumb-item">{{ $title }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-lg-end mb-3">
                <a class="btn btn-success" href="{{ route('audit-log.create') }}">Delete AuditLog</a>
            </div>
            <div class="table-responsive">
                <table id="mytable" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-nowrap" style="width:50px">No</th>
                            <th class="text-nowrap">Activity</th>
                            <th class="text-nowrap">Subject</th>
                            <th class="text-nowrap">Causer</th>
                            <th class="text-nowrap">Role Causer</th>
                            <th class="text-nowrap">Note</th>
                            <th class="text-nowrap">Date</th>
                            <th class="text-nowrap">Time</th>
                            <th class="text-nowrap" style="width: 100px">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="actionbase" class="d-none">
    <div class="d-flex">
        <a class="btn btn-warning me-2">Edit</a>
        <form method="post">
            @csrf
            @method('delete')
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
        ajax: "{{ route('audit-log.datatable') }}",
        columns: [{
                data: 'DT_RowIndex',
                name: 'No'
            },
            {
                data: 'activity',
                name: 'activity'
            },
            {
                data: 'subject',
                name: 'subject'
            },
            {
                data: 'causer',
                name: 'causer'
            },
            {
                data: 'role_causer',
                name: 'role_causer'
            },
            {
                data: 'note',
                name: 'note'
            },
            {
                data: 'date',
                name: 'date'
            },
            {
                data: 'time',
                name: 'time'
            },
            {
                name: "Action",
                render: function(data, type, row) {
                    let html = $('#actionbase').clone()
                    html = html.find('.d-flex')
                    html.find('a').attr('href', row.action.editurl)
                    let form = html.find('form').attr('action', row.action.deleteurl)
                        .attr('id', 'delete_form' + row.id)
                    form.find('button').attr('form-id', '#delete_form' + row.id)
                    return html.html()
                }
            }
        ]
    });
    active_menu("#menu-audit", "#menu-audit")
</script>
<div class="d-flex">
    <a class="btn btn-warning me-2">Edit</a>
    <button class="btn btn-danger me-2">Hapus</button>
</div>
@endpush

@endsection