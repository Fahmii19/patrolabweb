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
                <div class="table-responsive">
                    <table id="mytable" class="table">
                        <thead>
                            <tr>
                                <th style="max-width: 30px;">No</th>
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="actionbase" class="d-none">
        <div class="d-flex">
            <a class="btn btn-warning me-2 text-dark">Edit</a>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection

@push('js')
<script>
    $('#mytable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('location-condition.datatable') }}",
        columns: [{
                data: 'DT_RowIndex',
                name: 'No'
            }, {
                data: 'name',
                name: 'Nama'
            }, {
                data: 'description',
                name: 'Deksripsi'
            }, {
                data: 'status',
                render: function(data, type, row) {
                    if (row.status == 'ACTIVED') return `<span class="badge badge-success">${row.status}</span>`
                    return `<span class="badge badge-danger">${row.status}</span>`
                }
            }, {
                name: "Action"
                , render: function(data, type, row) {
                    let html = $('#actionbase').clone()
                    html = html.find('.d-flex')
                    html.find('a').attr('href', row.action.editurl)
                    return html.html()
                }
            }
        ]
    });
    active_menu("#menu-report", "#sub-report-location-condition")
</script>
@endpush