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
                    <li class="breadcrumb-item">Branch Project</li>
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
                <a href="{{ route('branch.create') }}" class="btn btn-success">Tambah Branch</a>
            </div>
            <table id="mytable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-nowrap" style="max-width: 40px;">No</th>
                        <th class="text-nowrap">Kode Branch</th>
                        <th class="text-nowrap">Nama Branch</th>
                        <th class="text-nowrap">Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<!-- Container-fluid Ends-->
<!-- Bagian action template -->
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



@push('js')
<script>
    // Konfigurasi DataTables
    $('#mytable').addClass('w-100').DataTable({
        processing: true
        , serverSide: true
        , ajax: "{{ route('branch.datatable') }}"
        , columns: [{
                data: 'DT_RowIndex'
                , name: 'No'
            , }
            , {
                data: 'code'
                , name: 'Kode Branch'
            }
            , {
                data: 'name'
                , name: 'Nama Branch'
            },

            {
                data: 'status'
                , name: 'Status Branch'
            }
            , {
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
                , orderable: false
                , searchable: false
            , }
        ]
    });

    active_menu("#data_master", "#branch");

</script>
@endpush

@endsection
