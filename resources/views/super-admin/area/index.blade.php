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
                    <li class="breadcrumb-item">Area Project</li>
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
                <a href="{{route('area.create')}}" class="btn btn-success">Tambah Area</a>
            </div>
            <table id="mytable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-nowrap" style="max-width: 40px;">No</th>
                        <th class="text-nowrap">Kode Area</th>
                        <th class="text-nowrap">Nama Area</th>
                        <th class="text-nowrap">Lokasi Image</th>
                        <th class="text-nowrap">Nama Project</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<!-- Container-fluid Ends-->
@push('js')
<script>
    $('#mytable').addClass('w-100').DataTable({
        scrollX: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('area.datatable') }}",
        columns: [{
                data: 'DT_RowIndex',
                name: 'No'
            },
            {
                data: 'code',
                name: 'Kode area'
            },
            {
                data: 'name',
                name: 'Nama area'
            },
            {
                data: 'img_location',
                name: 'Lokasi Image'
            },
            {
                data: 'project_id',
                name: 'Nama Project'
            }
        ]
    });
    active_menu("#data_master", "#area")
</script>
@endpush

@endsection