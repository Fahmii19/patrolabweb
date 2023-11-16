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
                    <li class="breadcrumb-item">Area Checkpoint</li>
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
                <a href="{{route('check-point.create')}}" class="btn btn-success">Tambah Area CheckPoint</a>
            </div>
            <table id="mytable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th style="max-width: 40px;">No</th>
                        <th>Nama CheckPoint</th>
                        <th>Kode</th>
                        <th>Lattitude</th>
                        <th>Status</th>
                        <th>Danger Status</th>
                        <th>Nama Round</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Modal Body -->
<!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
<div class="modal fade" id="qr_modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">QR Code</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="qr_image"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

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
                data: 'name',
                name: 'Nama CheckPoint'
            },
            {
                data: 'qr_code',
                render: function(data, type, row) {
                    let html = $('<div><span class="badge badge-success"></span></div>')
                    html.find('span').attr('onclick', 'view_qr(\'' + row.qr_code + '\')')
                        .text(row.qr_code)

                    return html.html()
                }
            },
            {
                data: 'location_long_lat',
                name: 'Nama CheckPoint'
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
                data: 'danger_status',
                // name: 'Danger Status'

                render: function(data, type, row) {
                    if (row.danger_status == 'LOW') {
                        return '<span class="badge badge-success">' + row.danger_status + '</span>'
                    } else if (row.danger_status == 'MIDDLE') {
                        return '<span class="badge badge-warning">' + row.danger_status + '</span>'
                    }
                    else {
                        return '<span class="badge badge-danger">' + row.danger_status + '</span>'
                    }
                }
            },
            {
                data: 'id_round',
                name: 'Nama Round'
            },
        ]
    });
    active_menu("#menu-checkpoint", "#sub-list-checkpoint")
</script>

@endpush

@endsection