@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h3>{{ $title }}</h3>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"> <i data-feather="home"></i></a></li>
                    <li class="breadcrumb-item">Asset Management</li>
                    <li class="breadcrumb-item">{{ $title }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="d-flex mb-3 justify-content-end">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createAssetUnsafeOptionModal">
                    Tambah Unsafe Option
                </button>
                {{-- <a href="{{route('aset-unsafe-option.create')}}" class="btn btn-success"></a> --}}
            </div>
            <div class="table-responsive">
                <table id="mytable" class="table">
                    <thead>
                        <tr>
                            <th style="max-width: 30px;">No</th>
                            <th>Nama</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@include('super-admin.aset-unsafe-option.modal-create')

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
<!-- Container-fluid Ends-->
@push('js')
<script>
    $('#mytable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('aset-unsafe-option.datatable') }}",
        columns: [{
                data: 'DT_RowIndex',
                name: 'No'
            }, {
                data: 'name',
                name: 'name'
            }, {
                data: 'status',
                render: function(data, type, row) {
                    if (row.status == 'ACTIVED') {
                        return '<span class="badge badge-success">' + row.status + '</span>'
                    }
                    if (row.status = 'UNACTIVED'){
                        return '<span class="badge badge-danger">' + row.status + '</span>'
                    }
                }
            }, {
                name: "Action"
                , render: function(data, type, row) {
                    let html = $('#actionbase').clone()
                    html = html.find('.d-flex')
                    html.find('a').attr('href', row.action.editurl)
                    let form = html.find('form').attr('action', row.action.deleteurl)
                        .attr('id', 'delete_form' + row.id)
                    form.find('button').attr('form-id', '#delete_form' + row.id)
                    return html.html()
                }
            }
        ]
    });
    active_menu("#menu_aset", "#unsafe-option")
</script>
@endpush

@endsection
