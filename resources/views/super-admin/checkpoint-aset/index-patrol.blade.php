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
                    <li class="breadcrumb-item">Asset Checkpoint Client</li>
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
                <a href="{{route('')}}" class="btn btn-success">Tambah Checkpoint Asset</a>
            </div>
            <table id="mytable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th style="max-width: 30px;">No.</th>
                        <th>Checkpoint</th>
                        <th>Jumlah Asset</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div id="actionbase" class="d-none">
    <div class="d-flex">
        <a class="btn btn-warning me-2">Edit</a>
        <form method="post" class="d-inline">
            @csrf
            @method('delete')
            <button onclick="hapus_data(event)" class="btn btn-danger me-2" type="button">Hapus</button>
        </form>
    </div>
</div>


@push('js')
<script>
    active_menu("#menu-checkpointaset", "#sub-list-checkpoint")
</script>

@endpush

@endsection