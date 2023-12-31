@extends('layouts.admin')
@section('content')
    @component('components.dashboard.headpage')
        @slot('title')
            {{ $title }}
        @endslot
        @slot('bread')
            <li class="breadcrumb-item">Gate Access</li>
            <li class="breadcrumb-item">{{ $title }}</li>
        @endslot
    @endcomponent
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <table id="mytable" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th style="max-width: 40px;">No</th>
                            <th>Kode</th>
                            <th>Aset</th>
                            <th>Wilayah</th>
                            <th>Area</th>
                            <th>Jenis Aset</th>
                            <th>Tanggal Pembelian</th>
                            <th>Keterangan</th>
                            <th>Foto</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Tanggal Posting</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
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
@endsection
@push('js')
<script>
    // $('#mytable').DataTable({
    //     processing: true,
    //     serverSide: true,
    //     ajax: "{{ route('aset-location.datatable') }}",
    //     columns: [{
    //             data: 'DT_RowIndex',
    //             name: 'No'
    //         },
    //         {
    //             data: 'kode',
    //             name: 'kode'
    //         },
    //         {
    //             data: 'id_aset',
    //             name: 'id_aset'
    //         },
    //         {
    //             data: 'id_wilayah',
    //             name: 'id_wilayah'
    //         },
    //         {
    //             data: 'id_area',
    //             name: 'id_area'
    //         },
    //         {
    //             data: 'jenis_aset',
    //             name: 'jenis_aset'
    //         },
    //         {
    //             data: 'tanggal_pembelian',
    //             name: 'tanggal_pembelian'
    //         },
    //         {
    //             data: 'keterangan',
    //             name: 'keterangan'
    //         },
    //         {
    //             data: 'foto',
    //             name: 'foto'
    //         },
    //         {
    //             data: 'jumlah',
    //             name: 'jumlah'
    //         },
    //         {
    //             data: 'status',
    //             name: 'status'
    //         },
    //         {
    //             data: 'created_at',
    //             name: 'created_at'
    //         },
    //         {
    //             name: "Action",
    //             render: function(data, type, row) {
    //                 let html = $('#actionbase').clone()
    //                 html = html.find('.d-flex')
    //                 html.find('a').attr('href', row.action.editurl)
    //                 let form = html.find('form').attr('action', row.action.deleteurl)
    //                     .attr('id', 'delete_form' + row.id)
    //                 form.find('button').attr('form-id', '#delete_form' + row.id)
    //                 return html.html()
    //             }
    //         }
    //     ]
    // });
    active_menu("#menu-aset", "#location_asset")
</script>
@endpush