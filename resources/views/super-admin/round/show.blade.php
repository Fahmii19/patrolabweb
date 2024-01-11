@extends('layouts.admin')
@section('content')
    @component('components.dashboard.headpage')
        @slot('title')
            {{ $title }}
        @endslot
        @slot('bread')
            <li class="breadcrumb-item">Round</li>
            <li class="breadcrumb-item">{{ $title }}</li>
        @endslot
    @endcomponent
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-end">
                    <button type="buton" onclick="window.location.href='{{ route('round.index') }}'" class="btn btn-warning text-dark">
                        << Kembali
                    </button>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body row switch-showcase height-equal">
                        <h2 class="fs-5 mb-4">Daftar Checkpoint</h2>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-4">
                                    <label class="form-label" for="area">Area</label>
                                    <select class="form-select" id="area" name="area" onchange="get_patrol_area(this.value)">
                                        <option selected value="0">---Semua---</option>
                                        @foreach ($area as $item)
                                            <option value="{{ $item->id }}" {{ old('area') == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4">
                                    <label class="form-label" for="selectPatrolArea">Patrol Area</label>
                                    <select class="form-select" id="selectPatrolArea" name="patrol_area" onchange="get_round(this.value)">
                                        <option selected value="0">---Semua---</option>
                                        @foreach ($patrol_area as $item)
                                            <option value="{{ $item->id }}" {{ old('patrol_area') == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger d-block" id="patrol-area-alert"></span>
                                </div>
                                <div class="col-4">
                                    <label for="id_rute" class="form-label">Round</label>
                                    <select class="form-select @error('id_round') is-invalid @enderror" name="id_round" onchange="get_checkpoint(this.value)" id="id_rute">
                                        <option value="" selected disabled>--Pilih--</option>
                                        @foreach ($round as $item)
                                            <option value="{{ $item->id }}" {{ old('id_round') == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>  
                                    <span class="mt-2 d-block" id="round-alert"></span>
                                </div>
                            </div>
                            <div class="table-responsive mt-3">
                                <table class="table" id="tableCheckpoint">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="width:40px;">No</th>
                                            <th scope="col">Checkpoint</th>
                                            <th scope="col">Lokasi</th>
                                            <th scope="col">Patrol</th>
                                            <th scope="col">Area</th>
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
                        <h2 class="fs-5 mb-4">Checkpoint Tanpa Round</h2>

                        <div class="table-responsive">
                            <table id="mytable" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th style="max-width: 40px;">No</th>
                                        <th>CheckPoint</th>
                                        <th>Lokasi</th>
                                        <th>Status</th>
                                        <th>Danger Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modalBase" class="d-none">
        <div class="modal fade" id="modalUpdateRound" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel">Update Round</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" class="form-update-round">
                            @csrf
                            @method('put')
                            <div class="mb-3">
                                <label for="editNama" class="form-label">Nama Checkpoint <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('edit_nama') is-invalid @enderror" name="edit_nama" id="editNama" placeholder="Nama CheckPoint" readonly required>
                                @error('edit_nama') <span class="text-danger d-block">{{$message}}</span> @enderror
                            </div>
        
                            <label for="editIdRound" class="form-label">Nama Round <span class="text-danger">*</span></label>
                            <select class="form-select @error('edit_id_round') is-invalid @enderror" name="edit_id_round" id="editIdRound" required>
                                <option selected disabled>--Pilih--</option>
                                @foreach ($round as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

        <button type="button" data-bs-toggle="modal" id="btnOpenModal" data-bs-target="#updateRound" class="btn btn-primary">Edit</button>
    </div>
    <!-- Container-fluid Ends-->
@endsection

@push('js')
    <script>
        function get_patrol_area(area_id) {
            let patrol_area_base = $('#selectPatrolArea')
            let patrol_area_alert = $('#patrol-area-alert')
            $.ajax({
                url: "{{ url('/patrol-area-by-area') }}/" + area_id,
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
            let round_base = $('#id_rute')
            let round_alert = $('#round-alert')
            $.ajax({
                url: "{{ url('/round-by-patrol-area') }}/" + patrol_area_id,
                method: 'get',
                data: {
                    patrol_area_id: "{{ old('patrol_area') }}"
                },
                beforeSend: function() {
                    round_alert.removeClass('text-danger').addClass('text-black').text('Mengambil data round')
                },

                success: function(response) {
                    let data = response.data
                    round_base.html(data)
                    round_base.find('option:first')
                        .prop('disabled', true)
                        .prop('hidden', true)
                        .text('--Pilih--');
                    round_alert.text('')
                },
                error: function(response) {
                    round_base.html('<option value="" selected disabled hidden>--Tidak Ada--</option>')
                    round_alert.removeClass('text-black').addClass('text-danger').text('Tidak ada data round di patrol area ini')
                    get_checkpoint(0)
                }
            })
        }

        function get_checkpoint(id_round) {
            const area_table = $('#tableCheckpoint tbody');
            const select_alert = $('#round-alert');
            $.ajax({
                url: "{{ url('/checkpoint-by-round') }}/" + id_round,
                method: 'get',
                data: {
                    id_area: "{{ old('id_round') }}"
                },
                beforeSend: function() {
                    select_alert.text('Mengambil data checkpoint');
                },
                success: function(response) {
                    let data = response.data;
                    area_table.html(data);
                    select_alert.text('');
                },
                error: function(response) {
                    area_table.html(`
                        <tr class="text-center">
                            <td colspan="7">Tidak ada checkpoint</td>
                        </tr>
                    `);
                    select_alert.text('');
                }
            })
        }
        $('#mytable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('check-point.without-round-datatable') }}",
            columns: [{
                data: 'DT_RowIndex',
                name: 'No'
            }, {
                data: 'name',
                name: 'CheckPoint'
            }, {
                data: 'location',
                name: 'Location'
            }, {
                data: 'status',
                render: function(data, type, row) {
                    if (row.status == 'ACTIVED') return `<span class="badge badge-success">${row.status}</span>`
                    return `<span class="badge badge-danger">${row.status}</span>`
                }
            }, {
                data: 'danger_status',
                render: function(data, type, row) {
                    if (row.danger_status == 'LOW') {
                        return '<span class="badge badge-success">' + row.danger_status + '</span>'
                    } 
                    if (row.danger_status == 'MIDDLE') {
                        return '<span class="badge badge-warning">' + row.danger_status + '</span>'
                    }
                    if (row.danger_status == 'HIGH') {
                        return '<span class="badge badge-danger">' + row.danger_status + '</span>'
                    }
                }
            }, {
                name: 'action',
                render: function(data, type, row) {
                    // console.log(row);
                    const html = $('#modalBase').clone()
                    const modalEdit = html.find('#modalUpdateRound')

                    modalEdit.attr('id', `modalUpdateRound${row.id}`)
                    const formEdit = modalEdit.find('.form-update-round')
                    formEdit.attr('id', `formEdit${row.id}`)
                            .attr('action', row.action)

                    formEdit.find('input[name="edit_nama"]').attr('value', row.name)

                    const submitBtn = modalEdit.find('.btn.btn-primary').attr('onclick', 'edit_round(event)')
                        .attr('form-id', `#formEdit${row.id}`)

                    const btnOpenModal = html.find('#btnOpenModal').attr('data-bs-target', `#modalUpdateRound${row.id}`)

                    return html.html()
                },
                orderable: false,
                searchable: false,
            }]
        });

        function edit_round(event) {
            const btnTarget = $(event.target)
            const formId = btnTarget.attr('form-id')
            $(formId).submit();
        }
        active_menu("#menu-round", "#sub-round-detail")
    </script>
@endpush