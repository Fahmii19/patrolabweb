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
                    <li class="breadcrumb-item">Asset Patrol</li>
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
            <div class="d-flex justify-content-end">
                <button onclick="window.history.back()" class="btn btn-warning">
                    << Kembali
                </button>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body row switch-showcase height-equal">
                    <h2 class="fs-5 mb-4">Daftar Asset pada Checkpoint</h2>
                    <div class="mb-3">
                        <label for="idCheckpoint" class="form-label">Pilih Checkpoint<span class="text-danger">*</span></label>
                        <select class="form-select @error('id_checkpoint') is-invalid @enderror" name="id_checkpoint" onchange="get_asset(this.value)" id="idCheckpoint">
                            <option value="" selected disabled>--Pilih--</option>
                            @foreach ($checkpoint as $item)
                                <option value="{{ $item->id }}" {{ old('id_checkpoint') == $item->id ? 'selected' : '' }}>{{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                        <span class="mt-2 d-block" id="checkpoint-alert"></span>
                        <div class="table-responsive mt-3">
                            <table class="table" id="tableAsset">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width:40px;">No</th>
                                        <th scope="col">Kode Aset</th>
                                        <th scope="col">Nama Aset</th>
                                        <th scope="col">Deskripsi</th>
                                        <th scope="col">Tipe</th>
                                        <th scope="col">Catatan</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="fs-5 mb-4">Daftar Asset Patrol</h2>

                    <table id="mytable" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th style="max-width: 40px;">No</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Tipe</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modalBase" class="d-none">
    <div class="modal fade" id="modalInsertAsset" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Insert Asset to Checkpoint</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('checkpoint-aset-patrol.store')}}" class="form-insert-asset">
                        @csrf
                        @method('post')
                        <input type="hidden" name="asset_id">
                        <div class="mb-3">
                            <label for="namaAset" class="form-label">Nama Asset <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_aset') is-invalid @enderror" name="nama_aset" id="namaAset" placeholder="Nama Aset" readonly required>
                            @error('nama_aset') <span class="text-danger d-block">{{$message}}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="idCheck" class="form-label">Nama Checkpoint <span class="text-danger">*</span></label>
                            <select class="form-select @error('insert_checkpoint') is-invalid @enderror" name="insert_checkpoint" id="idCheck" required>
                                <option selected disabled>--Pilih--</option>
                                @foreach ($checkpoint as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="shortDesc" class="form-label">Deskripsi</label>
                            <input type="text" class="form-control @error('short_desc') is-invalid @enderror" name="short_desc" id="shortDesc" placeholder="Deksripsi singkat" required>
                            @error('short_desc') <span class="text-danger d-block">{{$message}}</span> @enderror
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Insert Asset</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <button type="button" data-bs-toggle="modal" id="btnOpenModal" data-bs-target="#insertAsset" class="btn btn-primary">Insert to Checkpoint</button>
</div>
<!-- Container-fluid Ends-->

@push('js')
<script>
    function get_asset(id_checkpoint) {
        const area_table = $('#tableAsset tbody');
        const select_alert = $('#checkpoint-alert');
        $.ajax({
            url: "{{ url('/super-admin/asset-patrol-by-checkpoint') }}/" + id_checkpoint,
            method: 'get',
            data: {
                id_checkpoint: "{{ old('id_checkpoint') }}"
            },
            beforeSend: function() {
                select_alert.text('Mengambil data asset');
            },
            success: function(response) {
                let data = response.data;
                area_table.html(data);
                select_alert.text('');
            },
            error: function(response) {
                area_table.html(`
                    <tr class="text-center">
                        <td colspan="8">Tidak ada asset</td>
                    </tr>
                `);
                select_alert.text('');
            }
        })
    }
    $('#mytable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('asset-patrol-datatable') }}",
        columns: [{
            data: 'DT_RowIndex',
            name: 'No'
        }, {
            data: 'code',
            name: 'Kode'
        }, {
            data: 'name',
            name: 'Asset'
        }, {
            data: 'type',
            name: 'Tipe'
        }, {
            data: 'status',
            render: function(data, type, row) {
                if(row.status == 'ACTIVED') {
                    return '<span class="badge badge-success">' + row.status + '</span>'
                } 
                if(row.status == 'INACTIVED'){
                    return '<span class="badge badge-danger">' + row.status + '</span>'
                }
            }
        }, {
            name: 'action',
            render: function(data, type, row) {
                const html = $('#modalBase').clone()
                const modalInsert = html.find('#modalInsertAsset')

                modalInsert.attr('id', `modalInsertAsset${row.id}`)
                const formInsert = modalInsert.find('.form-insert-asset')
                formInsert.attr('id', `formInsert${row.id}`)

                formInsert.find('input[name="asset_id"]').attr('value', row.id)
                formInsert.find('input[name="nama_aset"]').attr('value', row.name)

                const submitBtn = modalInsert.find('.btn.btn-primary').attr('onclick', 'insert_asset(event)')
                    .attr('form-id', `#formInsert${row.id}`)

                const btnOpenModal = html.find('#btnOpenModal').attr('data-bs-target', `#modalInsertAsset${row.id}`)

                return html.html()
            },
            orderable: false,
            searchable: false,
        }]
    });

    function insert_asset(event) {
        const btnTarget = $(event.target)
        const formId = btnTarget.attr('form-id')
        $(formId).submit();
    }
    active_menu("#menu-checkpointaset-patrol", "#sub-checkpoint-patrol-aset-detail")
</script>

@endpush
@endsection