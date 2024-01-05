@extends('layouts.admin')
@section('content')
    @component('components.dashboard.headpage')
        @slot('title')
            {{ $title }}
        @endslot
        @slot('bread')
            <li class="breadcrumb-item">Client Asset</li>
            <li class="breadcrumb-item">{{ $title }}</li>
        @endslot
    @endcomponent
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
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
@endsection

@push('js')
<script>
    $('#mytable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('checkpoint-aset-client.datatable') }}",
        columns: [{
            data: 'DT_RowIndex',
            name: 'No'
        }, {
            data: 'checkpoint_name',
            name: 'Checkpoint'
        }, {
            data: 'jumlah_asset',
            name: 'Jumlah Aset'
        }, {
            data: 'location',
            name: 'Lokasi'
        }, {
            data: 'status',
            render: function(data, type, row) {
                if (row.status == 'ACTIVED') return `<span class="badge badge-success">${row.status}</span>`
                return `<span class="badge badge-danger">${row.status}</span>`
            }
        }, {
            render: function() {
                return `<a href="{{route('asset-client-detail')}}" class="btn btn-primary me-2">Detail</a>`
            }
        }]
    });
    active_menu("#menu-checkpointaset-client", "#sub-checkpoint-client-aset-list")
</script>

@endpush