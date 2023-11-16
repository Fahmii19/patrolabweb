<!-- @php
$page = 'data-master';
$section = 'wilayah';
@endphp -->
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
                    <li class="breadcrumb-item">Project</li>
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
            <div class="d-flex justify-content-lg-end mb-3">
                <a class="btn btn-success" href="{{ route('project-model.create') }}">Tambah Project</a>
            </div>
            <table class="table table-hover table-bordered" id="mytable">
                <thead class="bg-light">
                    <tr>
                        <th class="text-nowrap" style="width:50px">No</th>
                        <th class="text-nowrap">Nama Project</th>
                        <th class="text-nowrap">Wilayah</th>
                        <th class="text-nowrap" style="width: 100px">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($project_model as $item)
                    <tr>
                        <td class="text-nowrap">{{ $loop->iteration }}</td>
                        <td class="text-nowrap">{{ $item->nama_project }}</td>
                        <td class="text-nowrap">{{ $item->wilayah }}</td>
                        <td class="text-nowrap">
                            <div class="d-flex">
                                <a href="{{ route('project-model.edit',$item->id) }}" class="btn btn-warning me-2">Edit</a>
                                <form action="{{ route('project-model.destroy',$item->id) }}" method="post" id="delete_form{{ $item->id }}">
                                    @csrf
                                    @method('delete')
                                    <button type="button" class="btn btn-danger" onclick="delete_item('delete_form{{ $item->id }}')">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="actionbase" class="d-none">
    <div class="d-flex">
        <a class="btn btn-warning me-2">Edit</a>
        <form method="post">
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
        ajax: "{{ route('project.datatable') }}",
        columns: [{
                data: 'DT_RowIndex',
                name: 'No'
            },
            {
                data: 'nama_project',
                name: 'Nama Project'
            },
            {
                data: 'wilayah',
                name: 'Nama Wilayah'
            },
            {
                name: "Action",
                render: function(data, type, row) {
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
    active_menu("#data_master", "#project")
</script>
<div class="d-flex">
    <a class="btn btn-warning me-2">Edit</a>
    <button class="btn btn-danger me-2">Hapus</button>
</div>
@endpush

@endsection