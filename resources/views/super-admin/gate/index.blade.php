@extends('layouts.admin')
@section('content')
    @component('components.dashboard.headpage')
        @slot('title')
            {{ $title }}
        @endslot
        @slot('bread')
            <li class="breadcrumb-item">Master Data</li>
            <li class="breadcrumb-item">{{ $title }}</li>
        @endslot
    @endcomponent
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="d-flex mb-3 justify-content-end">
                    <a href="{{route('gate.create')}}" class="btn btn-success">Tambah Gate</a>
                </div>
                <div class="table-responsive">
                    <table id="mytable" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-nowrap" style="max-width: 40px;">No</th>
                                <th class="text-nowrap">Kode Gate</th>
                                <th class="text-nowrap">Nama Gate</th>
                                <th class="text-nowrap">Patrol Area</th>
                                <th class="text-nowrap">Area</th>
                                <th class="text-nowrap">Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Container-fluid Ends-->
    <div id="actionbase" class="d-none">
        <div class="d-flex">
            <a class="btn btn-warning me-2 text-dark">Edit</a>
            <form method="post" class="d-inline">
                @csrf
                @method('delete')
                <button onclick="hapus_data(event)" class="btn btn-danger me-2" type="button">Hapus</button>
            </form>
        </div>
    </div>

    @push('js')
    <script>
        $('#mytable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('gate.datatable') }}",
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'No',
                },
                {
                    data: 'code',
                    name: 'Kode Gate',
                }, 
                {
                    data: 'name',
                    name: 'Nama Gate',
                },
                {
                    data: 'patrol_area',
                    name: 'Nama Patrol Area',
                },
                {
                    data: 'area',
                    name: 'Nama Area',
                },
                {
                    data: 'status',
                    render: function(data, type, row) {
                        if (row.status == 'ACTIVED') return `<span class="badge badge-success">${row.status}</span>`
                        return `<span class="badge badge-danger">${row.status}</span>`
                    }
                },
                {
                    name: 'Action',
                    data: 'action',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        let html = $('#actionbase').clone()
                        html = html.find('.d-flex')
                        html.find('a').attr('href', row.action.editurl)
                        let form = html.find('form').attr('action', row.action.deleteurl)
                            .attr('id', 'delete_form' + row.id)
                        form.find('button').attr('form-id', '#delete_form' + row.id)
                        return html.html();
                    },
                },
            ]
        });

        active_menu("#data_master", "#gate")
    </script>
    @endpush
@endsection
