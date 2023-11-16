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
                    <li class="breadcrumb-item">Round</li>
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
            <div class="d-flex mb-3 justify-content-end">
                <a href="{{route('round.create')}}" class="btn btn-success">Tambah Round</a>
            </div>
            <table id="#mytable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th style="max-width: 40px;">No</th>
                        <th>Nama</th>
                        <th>Jumlah Check Point</th>
                        <th>Status</th>
                        <th>Area</th>
                        <th>Project</th>
                        <th>Wilayah</th>
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
        ajax: "{{ route('check-point.datatable') }}",
        columns: [{
                data: 'DT_RowIndex',
                name: 'No'
            },
            {
                data: 'nama',
                name: 'Nama CheckPoint'
            },
            {
                data: 'kode',
                name: 'Nama CheckPoint'
            },
            {
                data: 'lokasi',
                name: 'Nama CheckPoint'
            },
            {
                data: 'status',
                render: function(data, type, row) {
                    if (row.status == 'aktif') {
                        return '<span class="badge badge-success">' + row.status + '</span>'
                    } else {
                        return '<span class="badge badge-danger">' + row.status + '</span>'
                    }
                }
            },
            {
                data: 'id_area',
                name: 'Nama Area'
            },
            {
                data: 'id_project',
                name: 'Nama Project'
            },
            {
                data: 'id_wilayah',
                name: 'Nama Wilayah'
            }
        ]
    });
    active_menu("#menu-round", "#sub-round-list")
</script>

@endpush

@endsection