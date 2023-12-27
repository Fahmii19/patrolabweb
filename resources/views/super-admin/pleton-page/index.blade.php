@extends('layouts.admin')
@section('content')
    @component('components.dashboard.headpage')
        @slot('title')
            {{ $title }}
        @endslot
        @slot('bread')
            <li class="breadcrumb-item">Guard Management</li>
            <li class="breadcrumb-item">{{ $title }}</li>
        @endslot
    @endcomponent

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="d-flex mb-3 justify-content-end">
                    <a href="{{ route('pleton.create') }}" class="btn btn-success">Tambah Pleton</a>
                </div>
                <div class="table-responsive">
                    <table id="mytable" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th style="max-width: 40px;">No</th>
                                <th class="text-nowrap">Kode</th>
                                <th class="text-nowrap">Nama</th>
                                <th class="text-nowrap">Status</th>
                                <th class="text-nowrap">Nama Area</th>
                                <th class="text-nowrap">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="actionbase" class="d-none">
        <div class="d-flex">
            <form method="post">
                @csrf
                @method('delete')
                <a id="show" class="btn btn-primary me-2">Detail</a>
                <a id="edit" class="btn btn-warning me-2 my-2 text-dark">Edit</a>
                <button onclick="hapus_data(event)" class="btn btn-danger me-2" type="button">Hapus</button>
            </form>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#mytable').DataTable({
                scrollX: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('pleton.datatable') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'code',
                        name: 'Kode Pleton',
                    },
                    {
                        data: 'name',
                        name: 'Nama Pleton',
                    },
                    {
                        data: 'status',
                        render: function(data, type, row) {
                            if (row.status == 'ACTIVED') return `<span class="badge badge-success">${row.status}</span>`
                            return `<span class="badge badge-danger">${row.status}</span>`
                        }
                    },
                    {
                        data: 'area',
                        name: 'Nama Area',
                    },
                    {
                        name: "Action",
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            let html = $('#actionbase').clone();
                            html = html.find('.d-flex');
                            html.find('#show').attr('href', row.action.showurl);
                            html.find('#edit').attr('href', row.action.editurl);
                            let form = html.find('form').attr('action', row.action.deleteurl)
                                .attr('id', 'delete_form' + row.id);
                            form.find('button').attr('form-id', '#delete_form' + row.id);
                            return html.html();
                        }
                    }
                ]
            });
        });

        active_menu("#menu-guard", "#sub-list-pleton")
    </script>
@endpush