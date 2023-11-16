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
                    <li class="breadcrumb-item">Atensi</li>
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
                        <th>User</th>
                        <th>Judul</th>
                        <th>Prioritas</th>
                        <th>Deskripsi</th>
                        <th>Wilayah</th>
                        <th>Project</th>
                        <th>Area</th>
                        <th>Mulai</th>
                        <th>Selesai</th>
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
        ajax: "{{ route('atensi.datatable') }}",
        columns: [{
                data: 'DT_RowIndex',
                name: 'No'
            },
            {
                data: 'user',
                name: 'Nama Pengguna'
            },
            {
                data: 'judul',
                name: 'Judul'
            },
            {
                data: 'prioritas',
                render: function(data, type, row) {
                    if (row.prioritas == 'High') {
                        return '<span class="badge badge-danger">' + row.prioritas + '</span>'
                    } else if (row.prioritas == 'Medium') {
                        return '<span class="badge badge-warning">' + row.prioritas + '</span>'
                    } else {
                        return '<span class="badge badge-success">' + row.prioritas + '</span>'
                    }
                }
            },
            {
                data: 'deskripsi',
                name: 'Nama CheckPoint'
            },
            {
                data: 'wilayah',
                name: 'Nama Wilayah'
            },
            {
                data: 'project',
                name: 'Nama Project'
            },
            {
                data: 'area',
                name: 'Nama Ara'
            },
            {
                data: 'mulai',
                name: 'Tanggal Mulai'
            },
            {
                data: 'selesai',
                name: 'Tanggal Selesai'
            }
        ]
    });
    active_menu("#menu-patrol", "#sub-notice")
</script>

@endpush

@endsection