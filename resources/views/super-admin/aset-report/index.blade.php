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
                    <li class="breadcrumb-item">Reporting</li>
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
                        <th>Kode Aset</th>
                        <th>Nama Aset</th>
                        <th>Tipe</th>
                        <th>Pleton</th>
                        <th>Tanggal Patrol</th>
                        <th>Status</th>
                        <th>Laporan</th>
                        <th>Deskripsi</th>
                        <th>Gambar</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@push('js')
<script>
    $('#mytable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('aset-report.datatable') }}",
        columns: [{
                data: 'DT_RowIndex',
                name: 'No'
            }, {
                data: 'asset_code',
                name: 'Kode Asset'
            }, {
                data: 'asset_name',
                name: 'Nama Aset'
            }, {
                data: 'asset_type',
                name: 'Tipe Aset'
            }, {
                data: 'pleton',
                name: 'Nama Pleton'
            }, {
                data: 'patrol_date',
                name: 'Tanggal Patrol'
            }, {
                data: 'asset_status',
                name: 'Status Patrol'
            }, {
                data: 'asset_info',
                name: 'Info'
            }, {
                data: 'description',
                name: 'Deskripsi'
            }, {
                data: 'image',
                name: 'Gambar',
                orderable: false,
                searchable: false,
            }
        ]
    });
    active_menu("#menu-report", "#sub-list-asset-report")
</script>
@endpush

@endsection