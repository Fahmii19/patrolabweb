@extends('layouts.admin')
@section('content')
    @component('components.dashboard.headpage')
        @slot('title')
            {{ $title }}
        @endslot
        @slot('bread')
            <li class="breadcrumb-item">Patrol Asset</li>
            <li class="breadcrumb-item">{{ $title }}</li>
        @endslot
    @endcomponent
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
                            <div class="row">
                                <div class="col-3">
                                    <label class="form-label" for="filterArea">Area</label>
                                    <select class="form-select" id="filterArea" name="area" onchange="get_patrol_area(this.value)">
                                        <option selected value="0">---Semua---</option>
                                        @foreach ($area as $item)
                                            <option value="{{ $item->id }}" {{ old('area') == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-3">
                                    <label class="form-label" for="filterPatrolArea">Patrol Area</label>
                                    <select class="form-select" id="filterPatrolArea" name="patrol_area" onchange="get_round(this.value)">
                                        <option selected value="0">---Semua---</option>
                                        @foreach ($patrol_area as $item)
                                            <option value="{{ $item->id }}" {{ old('patrol_area') == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger d-block" id="patrol-area-alert"></span>
                                </div>
                                <div class="col-3">
                                    <label class="form-label" for="filterRound">Round</label>
                                    <select class="form-select @error('id_round') is-invalid @enderror" name="id_round" onchange="get_checkpoint(this.value)" id="filterRound">
                                        <option value="" selected disabled>--Pilih--</option>
                                        @foreach ($round as $item)
                                            <option value="{{ $item->id }}" {{ old('id_round') == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>  
                                    <span class="mt-2 d-block" id="round-alert"></span>
                                </div>
                                <div class="col-3">
                                    <label class="form-label" for="filterCheckpoint">Pilih Checkpoint<span class="text-danger">*</span></label>
                                    <select class="form-select @error('id_checkpoint') is-invalid @enderror" name="id_checkpoint" onchange="get_asset(this.value)" id="filterCheckpoint">
                                        <option value="" selected disabled>--Pilih--</option>
                                        @foreach ($checkpoint as $item)
                                            <option value="{{ $item->id }}" {{ old('id_checkpoint') == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="mt-2 d-block" id="checkpoint-alert"></span>
                                </div>
                            </div>
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
    <!-- Container-fluid Ends-->
    @include('super-admin.checkpoint-aset.modal-patrol')
@endsection

@push('js')
<script>
    function get_patrol_area(area_id) {
        let patrol_area_base = $('#filterPatrolArea')
        let patrol_area_alert = $('#patrol-area-alert')
        $.ajax({
            url: "{{ url('/super-admin/patrol-area-by-area') }}/" + area_id,
            method: 'get',
            data: {
                area_id: "{{ old('area') }}"
            },
            beforeSend: function() {
                patrol_area_alert.removeClass('text-danger').addClass('text-black').text('Mengambil data patrol area')
            },

            success: function(response) {
                let data = response.data
                patrol_area_base.html(data)
                patrol_area_alert.text('')
            },
            error: function(response) {
                patrol_area_base.html('<option value="" selected disabled hidden>--Tidak Ada--</option>')
                patrol_area_alert.removeClass('text-black').addClass('text-danger').text('Tidak ada data patrol area di area ini')
            }
        })
    }
    function get_round(patrol_area_id) {
        let round_base = $('#filterRound')
        let round_alert = $('#round-alert')
        $.ajax({
            url: "{{ url('/super-admin/round-by-patrol-area') }}/" + patrol_area_id,
            method: 'get',
            data: {
                patrol_area_id: "{{ old('id_round') }}"
            },
            beforeSend: function() {
                round_alert.removeClass('text-danger').addClass('text-black').text('Mengambil data round')
            },

            success: function(response) {
                let data = response.data
                round_base.html(data)
                round_alert.text('')
            },
            error: function(response) {
                round_base.html('<option value="" selected disabled hidden>--Tidak Ada--</option>')
                round_alert.removeClass('text-black').addClass('text-danger').text('Tidak ada data round di patrol area ini')
                get_checkpoint(99999999999);
            }
        })
    }
    function get_checkpoint(round_id) {
        let checkpoint_base = $('#filterCheckpoint')
        let checkpoint_alert = $('#checkpoint-alert')
        $.ajax({
            url: "{{ url('/super-admin/select-checkpoint-by-round') }}/" + round_id,
            method: 'get',
            data: {
                round_id: "{{ old('round_id') }}"
            },
            beforeSend: function() {
                checkpoint_alert.removeClass('text-danger').addClass('text-black').text('Mengambil data checkpoint')
            },

            success: function(response) {
                let data = response.data
                checkpoint_base.html(data)
                checkpoint_base.find('option:first')
                    .prop('disabled', true)
                    .prop('hidden', true)
                    .text('--Pilih--');
                checkpoint_alert.text('')
            },
            error: function(response) {
                checkpoint_base.html('<option value="" selected disabled hidden>--Tidak Ada--</option>')
                checkpoint_alert.removeClass('text-black').addClass('text-danger').text('Tidak ada data checkpoint di round ini')
                get_asset(0)
            }
        })
    }

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

    function modal_patrol_area(area) {
        let area_id = area.value;
        let formParent = $(area).parent().parent();
        let patrol_area_base = formParent.find('.modalPatrolArea');
        let patrol_area_alert = formParent.find('.patrol-area-modal');
        $.ajax({
            url: "{{ url('/super-admin/patrol-area-by-area') }}/" + area_id,
            method: 'get',
            data: {
                area_id: "{{ old('area') }}"
            },
            beforeSend: function() {
                patrol_area_alert.removeClass('text-danger').addClass('text-black').text('Mengambil data patrol area')
            },

            success: function(response) {
                let data = response.data
                patrol_area_base.html(data)
                patrol_area_alert.text('')
            },
            error: function(response) {
                patrol_area_base.html('<option value="" selected disabled hidden>--Tidak Ada--</option>')
                patrol_area_alert.removeClass('text-black').addClass('text-danger').text('Tidak ada data patrol area di area ini')
            }
        })
    }

    function modal_round(patrol_area) {
        let patrol_area_id = patrol_area.value;
        let formParent = $(patrol_area).parent().parent();
        let round_base = formParent.find('.modalRound');
        let round_alert = formParent.find('.round-modal');
        let checkpoint_base = formParent.find('.modalCheckpoint')
        let checkpoint_alert = formParent.find('.checkpoint-modal')
        $.ajax({
            url: "{{ url('/super-admin/round-by-patrol-area') }}/" + patrol_area_id,
            method: 'get',
            data: {
                patrol_area_id: "{{ old('id_round') }}"
            },
            beforeSend: function() {
                round_alert.removeClass('text-danger').addClass('text-black').text('Mengambil data round')
            },

            success: function(response) {
                let data = response.data
                round_base.html(data)
                round_alert.text('')
                checkpoint_base.html('<option value="" selected disabled hidden>--Pilih--</option>')
                checkpoint_alert.text('')
            },
            error: function(response) {
                round_base.html('<option value="" selected disabled hidden>--Tidak Ada--</option>')
                round_alert.removeClass('text-black').addClass('text-danger').text('Tidak ada data round di patrol area ini')
                console.log(checkpoint_base);
                console.log(checkpoint_alert);
                checkpoint_base.html('<option value="" selected disabled hidden>--Tidak Ada--</option>')
                checkpoint_alert.removeClass('text-black').addClass('text-danger').text('Tidak ada data checkpoint di round ini')
            }
        })
    }
    function modal_checkpoint(round) {
        let round_id = round.value;
        let formParent = $(round).parent().parent();
        let checkpoint_base = formParent.find('.modalCheckpoint')
        let checkpoint_alert = formParent.find('.checkpoint-modal')
        $.ajax({
            url: "{{ url('/super-admin/select-checkpoint-by-round') }}/" + round_id,
            method: 'get',
            data: {
                round_id: "{{ old('round_id') }}"
            },
            beforeSend: function() {
                checkpoint_alert.removeClass('text-danger').addClass('text-black').text('Mengambil data checkpoint')
            },

            success: function(response) {
                let data = response.data
                checkpoint_base.html(data)
                checkpoint_base.find('option:first')
                    .prop('disabled', true)
                    .prop('hidden', true)
                    .text('--Pilih--');
                checkpoint_alert.text('')
            },
            error: function(response) {
                checkpoint_base.html('<option value="" selected disabled hidden>--Tidak Ada--</option>')
                checkpoint_alert.removeClass('text-black').addClass('text-danger').text('Tidak ada data checkpoint di round ini')
            }
        })
    }
    
    $('#mytable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('asset-patrol-datatable') }}",
        columns: [
            {
                data: 'DT_RowIndex',
                name: 'No'
            },
            {
                data: 'code',
                name: 'Kode'
            },
            {
                data: 'name',
                name: 'Asset'
            },
            {
                data: 'type',
                name: 'Tipe'
            },
            {
                data: 'status',
                render: function(data, type, row) {
                    if (row.status == 'ACTIVED') return `<span class="badge badge-success">${row.status}</span>`
                    return `<span class="badge badge-danger">${row.status}</span>`
                }
            }, 
            {
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
            }
        ]
    });

    function insert_asset(event) {
        const btnTarget = $(event.target)
        const formId = btnTarget.attr('form-id')
        $(formId).submit();
    }
    active_menu("#menu-checkpointaset-patrol", "#sub-checkpoint-patrol-aset-detail")
</script>
@endpush