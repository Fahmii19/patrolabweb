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
                    <li class="breadcrumb-item">Asset Patroli</li>
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
            <div class="d-flex justify-content-lg-end mb-3">
                <a class="btn btn-success" href="{{ route('aset-patroli.create') }}">Tambah Aset Patroli</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="my_table">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-nowrap" style="width:50px">No</th>
                            <th class="text-nowrap">Kode</th>
                            <th class="text-nowrap">Aset</th>
                            <th class="text-nowrap">Wilayah</th>
                            <th class="text-nowrap">Area</th>
                            <th class="text-nowrap">Tanggal Penyerahan</th>
                            <th class="text-nowrap">Foto</th>
                            <th class="text-nowrap">Jumlah</th>
                            <th class="text-nowrap">Status</th>
                            <th class="text-nowrap" style="width: 100px">Tindakan</th>
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
        ajax: "{{ route('aset-location.datatable') }}",
        columns: [{
                data: 'DT_RowIndex',
                name: 'No'
            },
            {
                data: 'kode',
                name: 'kode'
            },
            {
                data: 'id_aset',
                name: 'id_aset'
            },
            {
                data: 'id_wilayah',
                name: 'id_wilayah'
            },
            {
                data: 'id_area',
                name: 'id_area'
            },
            {
                data: 'jenis_aset',
                name: 'jenis_aset'
            },
            {
                data: 'tanggal_pembelian',
                name: 'tanggal_pembelian'
            },
            {
                data: 'keterangan',
                name: 'keterangan'
            },
            {
                data: 'foto',
                name: 'foto'
            },
            {
                data: 'jumlah',
                name: 'jumlah'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'created_at',
                name: 'created_at'
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
                }
            }
        ]
    });
    active_menu("#menu_aset", "#patroli_asset")
</script>
<div class="d-flex">
    <a class="btn btn-warning me-2">Edit</a>
    <button class="btn btn-danger me-2">Hapus</button>
</div>
@endpush

@endsection