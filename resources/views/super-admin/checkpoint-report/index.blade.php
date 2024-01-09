@extends('layouts.admin')
@section('content')
    @component('components.dashboard.headpage')
        @slot('title')
            {{ $title }}
        @endslot
        @slot('bread')
            <li class="breadcrumb-item">Reporting</li>
            <li class="breadcrumb-item">{{ $title }}</li>
        @endslot
    @endcomponent
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form class="row g-3 needs-validation mb-5" id="formFilter">
                    <div class="col-3">
                        <label class="form-label" for="patrolDate">Tanggal Patrol</label>
                        <input class="datepicker-here form-control digits" type="text" name="patrol_date" id="patrolDate" name="patrolDate" data-range="true" data-multiple-dates-separator=" - " data-language="en" placehoder="Pilih Tanggal Patrol">
                    </div>
                    <div class="col-3">
                        <label class="form-label" for="area">Area</label>
                        <select class="form-select" id="area" name="area" onchange="get_patrol_area(this.value)">
                            <option selected value="0">---Semua---</option>
                            @foreach ($area as $item)
                                <option value="{{ $item->id }}" {{ old('area') == $item->id ? 'selected' : '' }}>{{ $item->name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-3">
                        <label class="form-label" for="selectPatrolArea">Patrol Area</label>
                        <select class="form-select" id="selectPatrolArea" name="patrol_area" onchange="get_round(this.value)">
                            <option selected value="0">---Semua---</option>
                            @foreach ($patrol_area as $item)
                                <option value="{{ $item->id }}" {{ old('patrol_area') == $item->id ? 'selected' : '' }}>{{ $item->name }} </option>
                            @endforeach
                        </select>
                        <span class="text-danger d-block" id="patrol-area-alert"></span>
                    </div>
                    <div class="col-3">
                        <label class="form-label" for="selectRound">Round</label>
                        <select class="form-select" id="selectRound" name="round">
                            <option selected value="">---Semua---</option>
                            @foreach ($round as $item)
                                <option value="{{ $item->id }}" {{ old('round') == $item->id ? 'selected' : '' }}>{{ $item->name }} </option>
                            @endforeach
                        </select>
                        <span class="text-danger d-block" id="round-alert"></span>
                    </div>
                    <div class="col-3">
                        <label class="form-label" for="pleton">Pleton</label>
                        <select class="form-select" id="pleton" name="pleton">
                            <option selected value="">---Semua---</option>
                            @foreach ($pleton as $item)
                                <option value="{{ $item->id }}" {{ old('pleton') == $item->id ? 'selected' : '' }}>{{ $item->name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-3">
                        <label class="form-label" for="status">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option selected value="">---Semua---</option>
                            <option value="safe">SAFE</option>
                            <option value="unsafe">UNSAFE</option>
                        </select>
                    </div>
                    <div class="col-12 text-end">
                        <button class="btn btn-primary">Cari</button>
                    </div>
                </form>

                <div class="table-responsive">
                    <table id="mytable" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th style="max-width: 40px;">No</th>
                                <th>Created By</th>
                                <th>Pleton</th>
                                <th>Tanggal Patrol</th>
                                <th>Checkpoint</th>
                                <th>Lokasi</th>
                                <th>Status</th>
                                <th>Reported at</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        var dataTable = $('#mytable').DataTable({
            searching: false,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('checkpoint-report.datatable') }}",
                type: "GET",
                data: function(data) {
                    // Menambahkan parameter filter
                    data.patrol_date = $('#patrolDate').val();
                    data.round = $('#selectRound').val();
                    data.pleton = $('#pleton').val();
                    data.status = $('#status').val();
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'No'
                },
                {
                    data: 'created_by',
                    name: 'User Name'
                },
                {
                    data: 'pleton',
                    name: 'Pleton Name'
                },
                {
                    data: 'business_date',
                    name: 'Patrol Date'
                },
                {
                    data: 'checkpoint',
                    name: 'CheckPoint Name'
                },
                {
                    data: 'location',
                    name: 'Checkpoint Location'
                },
                {
                    data: 'status',
                    render: function(data, type, row) {
                        if (row.status == 'safe') return `<span class="badge badge-success">${row.status.toUpperCase()}</span>`
                        return `<span class="badge badge-danger">${row.status.toUpperCase()}</span>`
                    }
                },
                {
                    data: 'reported_at',
                    name: 'Report Timestamp'
                },
            ],
            rowCallback: function(row, data) {
                // Set the cursor style to pointer
                $(row).css('cursor', 'pointer');
                // Attach a click event handler to each row
                $(row).on('click', function() {
                    // Handle the row click event
                    location.href = `{{ route('checkpoint-report.show', ':id') }}`.replace(':id', data.id);
                });
            }
        });

        $('#formFilter').submit(function(evt){
            evt.preventDefault();
            dataTable.draw();
        });

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
            let round_base = $('#selectRound')
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
                    round_alert.text('')
                },
                error: function(response) {
                    round_base.html('<option value="" selected disabled hidden>--Tidak Ada--</option>')
                    round_alert.removeClass('text-black').addClass('text-danger').text('Tidak ada data round di patrol area ini')
                }
            })
        }

        active_menu("#menu-report", "#sub-list-checkpoint-report")
    </script>
@endpush