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
                        <label class="form-label" for="shift">Shift</label>
                        <select class="form-select" id="asd" name="shift">
                            <option selected value="">---Semua---</option>
                            @foreach ($shift as $item)
                                <option value="{{ $item->id }}" {{ old('shift') == $item->id ? 'selected' : '' }}>{{ $item->name }} </option>
                            @endforeach
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
                                <th>Shift</th>
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
                url: "{{ route('shift-patrol.datatable') }}",
                type: "GET",
                data: function(data) {
                    // Menambahkan parameter filter
                    data.patrol_date = $('#patrolDate').val();
                    data.shift = $('#asd').val();
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'No'
                },
                {
                    data: 'shift',
                    name: 'Shift Name'
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

        active_menu("#menu-report", "#sub-report-shift-patrol")
    </script>
@endpush