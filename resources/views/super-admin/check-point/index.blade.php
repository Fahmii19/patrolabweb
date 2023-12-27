@extends('layouts.admin')
@section('content')
    @component('components.dashboard.headpage')
        @slot('title')
            {{ $title }}
        @endslot
        @slot('bread')
            <li class="breadcrumb-item">Checkpoint</li>
            <li class="breadcrumb-item">{{ $title }}</li>
        @endslot
    @endcomponent
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="d-flex mb-3 justify-content-end">
                    <a href="{{route('check-point.create')}}" class="btn btn-success">Tambah CheckPoint</a>
                </div>
                <table id="mytable" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th style="max-width: 30px;">No.</th>
                            <th>Checkpoint</th>
                            <th>QR Kode</th>
                            <th>Lokasi</th>
                            <th>Koordinat</th>
                            <th>Status</th>
                            <th>Danger Status</th>
                            <th>Nama Round</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div id="actionbase" class="d-none">
        <div class="d-flex">
            <a class="btn btn-warning me-2 text-dark">Edit</a>
            <form method="post" class="d-inline">
                @csrf
                @method('delete')
                <button onclick="hapus_data(event)" class="btn btn-danger me-2" type="button">Hapus</button>
            </form>
        </div>
    </div>

    <!-- Modal Body -->
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
@endsection

@push('js')
    <script>
        $('#mytable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('check-point.datatable') }}",
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'No'
                },
                {
                    data: 'name',
                    name: 'Checkpoint'
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
                    data: 'location',
                    name: 'Location'
                },
                {
                    data: 'location_long_lat',
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
                    data: 'danger_status',
                    render: function(data, type, row) {
                        if (row.danger_status == 'LOW') return `<span class="badge badge-success">${row.danger_status}</span>`
                        if (row.danger_status == 'MIDDLE') return `<span class="badge badge-warning text-dark">${row.danger_status}</span>`
                        if (row.danger_status == 'HIGH') return `<span class="badge badge-danger">${row.danger_status}</span>`
                    }
                },
                {
                    data: 'round',
                    name: 'Nama Round'
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
                    },
                    orderable: false,
                    searchable: false,
                }
            ]
        });
        active_menu("#menu-checkpoint", "#sub-list-checkpoint")
    </script>
@endpush