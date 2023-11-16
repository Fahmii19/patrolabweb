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
                    <li class="breadcrumb-item">Self Patrol</li>
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
            <table id="mytable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th style="max-width: 40px;">No</th>
                        <th>Petugas</th>
                        <th>Wilayah</th>
                        <th>Project</th>
                        <th>Area</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Deskripsi</th>
                        <th>Foto</th>
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
        ajax: "{{ route('self-patrol.datatable') }}",
        columns: [{
                data: 'DT_RowIndex',
                name: 'No'
            },
            {
                data: 'petugas',
                name: ''
            },
            {
                data: 'wilayah',
                name: ''
            },
            {
                data: 'project',
                name: ''
            },
            {
                data: 'area',
                name: ''
            },
            {
                data: 'tanggal',
                name: ''
            },
            {
                data: 'status',
                render: function(data, type, row) {
                    if (row.status == 'aman') {
                        return '<span class="badge badge-success">' + row.status + '</span>'
                    } else {
                        return '<span class="badge badge-danger">' + row.status + '</span>'
                    }
                }
            },
            {
                data: 'deskripsi',
                name: ''
            },
            {
                data: 'foto',
                name: ''
            }
        ]
    });
    active_menu("#menu-report", "#sub-report-self-patrol")
</script>

@endpush

@endsection