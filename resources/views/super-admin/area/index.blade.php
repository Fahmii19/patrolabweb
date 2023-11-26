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
                    <li class="breadcrumb-item">Area Project</li>
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
                <a href="{{route('area.create')}}" class="btn btn-success">Tambah Area</a>
            </div>
            <table id="mytable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-nowrap" style="max-width: 40px;">No</th>
                        <th class="text-nowrap">Kode Area</th>
                        <th class="text-nowrap">Lokasi Image</th>
                        {{-- <th class="text-nowrap">Nama Area</th>
                        <th class="text-nowrap">Status</th>
                        <th class="text-nowrap">Nama Project</th> --}}
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<!-- Container-fluid Ends-->
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
    $('#mytable').addClass('w-100').DataTable({
        processing: true
        , serverSide: true
        , ajax: "{{ route('area.datatable') }}"
        , columns: [{
                data: 'DT_RowIndex'
                , name: 'No'
            , }
            , {
                data: 'code'
                , name: 'code'
            }
            , {
                data: 'name'
                , name: 'name'
            },



            {
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
    active_menu("#data_master", "#area")

</script>
@endpush

@endsection
