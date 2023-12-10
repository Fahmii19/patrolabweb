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
            <div class="d-flex mb-3 justify-content-end">
                <a href="{{route('self-patrol.create')}}" class="btn btn-success">Tambah CheckPoint Report</a>
            </div>
            <table id="mytable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th style="max-width: 40px;">No</th>
                        <th>Nama CheckPoint</th>
                        <th>Lokasi CheckPoint</th>
                        <th>Nama Guard</th>
                        <th>Shift</th>
                        <th>Tanggal</th>
                        <th>Mulai</th>
                        <th>Selesai</th>
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
        ajax: "{{ route('checkpoint-report.datatable') }}",
        columns: [{
                data: 'DT_RowIndex',
                name: 'No'
            }, {
                data: 'checkpoint_name',
                name: 'Nama CheckPoint'
            }, {
                data: 'checkpoint_loc',
                name: 'Lokasi CheckPoint'
            }, {
                data: 'guard',
                name: 'Nama Guard'
            }, {
                data: 'shift',
                name: 'Nama Shift'
            }, {
                data: 'patrol_date',
                name: 'Tanggal Patrol'
            }, {
                data: 'start_time',
                name: 'Jam Mulai'
            }, {
                data: 'finish_time',
                name: 'Jam Selesai'
            }
        ]
    });
    active_menu("#menu-report", "#sub-list-checkpoint-report")
</script>

@endpush

@endsection