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
            <table id="mytable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th style="max-width: 40px;">No</th>
                        <th>Nama Rute</th>
                        <th>Jumlah Check Point</th>
                        <th>Status</th>
                        <th>Area</th>
                        <th>Project</th>
                        <th>Wilayah</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div id="actionbase" class="d-none">
    <div class="d-flex">
        <a class="btn btn-warning me-2" id="btnEdit">Edit</a>
        <form method="post" class="d-inline">
            @csrf
            @method('delete')
            <button onclick="hapus_data(event)" class="btn btn-danger me-2" type="button">Hapus</button>
        </form>
        <a href="{{route('round.detail')}}" class="btn btn-success me-2">Detail</a>
    </div>
</div>
<!-- Container-fluid Ends-->
@push('js')
<script>
    $('#mytable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('round.datatable') }}",
        columns: [{
            data: 'DT_RowIndex',
            name: 'No'
        }, {
            data: 'nama',
            name: 'Nama Rute'
        }, {
            data: 'jumlah',
            name: 'Jumlah Checkpoint'
        }, {
            data: 'status',
            render: function(data, type, row) {
                if (row.status == 'aktif') {
                    return '<span class="badge badge-success">' + row.status + '</span>'
                } else {
                    return '<span class="badge badge-danger">' + row.status + '</span>'
                }
            }
        }, {
            data: 'id_area',
            name: 'Nama Area'
        }, {
            data: 'id_project',
            name: 'Nama Project'
        }, {
            data: 'id_wilayah',
            name: 'Nama Wilayah'
        }, {
            name: "action",
            render: function(data, type, row) {
                let html = $('#actionbase').clone()
                html = html.find('.d-flex')
                html.find('#btnEdit').attr('href', row.action.editurl)
                let form = html.find('form').attr('action', row.action.deleteurl)
                .attr('id', 'delete_form' + row.id)
                form.find('button').attr('form-id', '#delete_form' + row.id)
                return html.html()
            }
        }]
    });
    active_menu("#menu-round", "#sub-round-list")
</script>
@endpush

@endsection