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
                <div class="d-flex mb-3 justify-content-end">
                    <a href="{{route('round.create')}}" class="btn btn-success">Tambah Rute</a>
                </div>
                <table id="mytable" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th style="max-width: 40px;">No</th>
                            <th>Nama Rute</th>
                            <th>Jumlah Checkpoint</th>
                            <th>Status</th>
                            <th>Patrol Area</th>
                            <th>Area</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div id="actionbase" class="d-none">
        <div class="d-flex">
            <a class="btn btn-warning me-2 text-dark" id="btnEdit">Edit</a>
            <form method="post" class="d-inline">
                @csrf
                @method('delete')
                <button onclick="hapus_data(event)" class="btn btn-danger me-2" type="button">Hapus</button>
            </form>
            <a href="{{route('round.detail')}}" class="btn btn-primary me-2">Detail</a>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection
@push('js')
<script>
    $('#mytable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('round.datatable') }}",
        columns: [{
            data: 'DT_RowIndex',
            name: 'No'
        }, 
        {
            data: 'name',
            name: 'Nama Rute'
        }, 
        {
            data: 'jumlah',
            name: 'Jumlah Checkpoint'
        }, 
        {
            data: 'status',
            render: function(data, type, row) {
                if (row.status == 'ACTIVED') return `<span class="badge badge-success">${row.status}</span>`
                return `<span class="badge badge-danger">${row.status}</span>`
            }
        },
        {
            data: 'patrol_area',
            name: 'Nama Patrol Area'
        }, 
        {
            data: 'area',
            name: 'Nama Area'
        },
        {
            name: "action",
            render: function(data, type, row) {
                console.log(row);
                let html = $('#actionbase').clone()
                html = html.find('.d-flex')
                html.find('#btnEdit').attr('href', row.action.editurl)
                if(row.jumlah > 0) {
                    html.find('form').addClass('d-none');
                } else {
                    html.find('form').removeClass('d-none');
                    let form = html.find('form').attr('action', row.action.deleteurl).attr('id', 'delete_form' + row.id)
                    form.find('button').attr('form-id', '#delete_form' + row.id)
                }
                
                return html.html()
            }
        }]
    });

    active_menu("#menu-round", "#sub-round-list")
</script>
@endpush