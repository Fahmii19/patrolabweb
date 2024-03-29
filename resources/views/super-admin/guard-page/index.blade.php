@extends('layouts.admin')
@section('content')
    @component('components.dashboard.headpage')
        @slot('title') {{ $title }} @endslot
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
                    <a href="{{ route('guard.create') }}" class="btn btn-success">Tambah Guard</a>
                </div>
                <div class="table-responsive">
                    <table id="mytable" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th style="max-width: 40px;">No</th>
                                <th class="text-nowrap">Badge</th>
                                <th class="text-nowrap">Nama</th>
                                <th class="text-nowrap">Position</th>
                                <th class="text-nowrap">Email</th>
                                <th class="text-nowrap">Gender</th>
                                <th class="text-nowrap">DOB</th>
                                <th class="text-nowrap">Pleton</th>
                                <th class="text-nowrap">Shift</th>
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
        $('#mytable').DataTable({
            scrollX: true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('guard.datatable') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'No',
                    orderable: false,
                    searchable: false,
                },
                {
                    data: 'badge_number',
                    name: 'badge_number',
                },
                {
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'position',
                    name: 'position',
                },
                {
                    data: 'email',
                    name: 'email',
                },
                {
                    data: 'gender',
                    name: 'gender',
                },
                {
                    data: 'dob',
                    name: 'dob',
                    render: function(data) {
                        return data ? new Date(data).toLocaleDateString() : '-';
                    }
                },
                {
                    data: 'pleton',
                    name: 'gender',
                },
                {
                    data: 'shift',
                    name: 'gender',
                },
                {
                    name: "Action",
                    render: function(data, type, row) {
                        let html = $('#actionbase').clone();
                        html = html.find('.d-flex');
                        html.find('#show').attr('href', row.action.showurl);
                        html.find('#edit').attr('href', row.action.editurl);
                        let form = html.find('form').attr('action', row.action.deleteurl).attr('id', 'delete_form' + row.id);
                        form.find('button').attr('form-id', '#delete_form' + row.id);
                        return html.html();
                    }
                }
            ]
        });

        active_menu("#menu-guard", "#sub-list-guard")
    </script>
@endpush
