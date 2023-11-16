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
                    <li class="breadcrumb-item">Log</li>
                    <li class="breadcrumb-item">{{ $title }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h5>Filter Data</h5>
        </div>
        <div class="card-body">
            <form class="row g-3 needs-validation" novalidate="">
                <div class="col-md-3 position-relative">
                    <label class="form-label" for="validationTooltip04">Wilayah</label>
                    <select class="form-select" id="validationTooltip04" required="">
                        <option selected="" disabled="" value="">Pilih Wilayah</option>
                        <option>Riau</option>
                    </select>
                    <div class="invalid-tooltip">Please select a valid state.</div>
                </div>
                <div class="col-md-3 position-relative">
                    <label class="form-label" for="validationTooltip04">Project</label>
                    <select class="form-select" id="validationTooltip04" required="">
                        <option selected="" disabled="" value="">Pilih Project</option>
                        <option>PHR</option>
                    </select>
                    <div class="invalid-tooltip">Please select a valid state.</div>
                </div>
                <div class="col-md-3 position-relative">
                    <label class="form-label" for="validationTooltip04">Gate</label>
                    <select class="form-select" id="validationTooltip04" required="">
                        <option selected="" disabled="" value="">Pilih Gate</option>
                        <option>Gate PHR - GM001</option>
                    </select>
                    <div class="invalid-tooltip">Please select a valid state.</div>
                </div>
                <div class="col-md-3 position-relative">
                    <label class="form-label" for="validationTooltip02">Tanggal</label>
                    <input class="datepicker-here form-control digits" type="text" data-range="true" data-multiple-dates-separator=" - " data-language="en" data-bs-original-title="" title="">
                </div>
                <div class="col-12">
                    <button class="btn btn-primary" type="submit" data-bs-original-title="" title="">Filter</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="mytable" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-nowrap" style="width:30px">No</th>
                            <th class="text-nowrap">NO KARTU</th>
                            <th class="text-nowrap">PLAT</th>
                            <th class="text-nowrap">Pemilik</th>
                            <th class="text-nowrap">Status</th>
                            <th class="text-nowrap">Tanggal Masuk</th>
                            <th class="text-nowrap">Foto Masuk</th>
                            <th class="text-nowrap" style="width: 100px">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="actionbase" class="d-none">
    <div class="d-flex">
        <a class="btn btn-warning me-2">Edit</a>
        <form method="post">
            @csrf
            @method('delete')
            <button onclick="hapus_data(event)" class="btn btn-danger me-2" type="button">Hapus</button>
        </form>
    </div>
</div>
<!-- Container-fluid Ends-->
@push('js')
<script>
    $('#mytable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('incoming-vehicle.datatable') }}",
        columns: [{
                data: 'DT_RowIndex',
                name: 'No'
            },
            {
                data: 'no_kartu',
                name: ''
            },
            {
                data: 'plat',
                name: ''
            },
            {
                data: 'pemilik',
                name: ''
            },
            {
                data: 'status',
                render: function(data, type, row) {
                    if (row.status == 'karyawan') {
                        return '<span class="badge badge-success">' + row.status + '</span>'
                    } else {
                        return '<span class="badge badge-danger">' + row.status + '</span>'
                    }
                }
            },
            {
                data: 'tanggal_masuk',
                name: ''
            },
            {
                data: 'foto_masuk',
                name: ''
            }
        ]
    });
    active_menu("#menu-gate", "#sub_incoming_vehichle")
</script>
<div class="d-flex">
    <a class="btn btn-warning me-2">Edit</a>
    <button class="btn btn-danger me-2">Hapus</button>
</div>
@endpush

@endsection