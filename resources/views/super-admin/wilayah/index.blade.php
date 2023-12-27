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
                <a href="{{route('wilayah.create')}}" class="btn btn-success">Tambah Wilayah</a>
            </div>
            <div class="table-responsive">
                <table id="mytable" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th style="max-width: 40px;">No</th>
                            <th>Provinsi</th>
                            <th>Nama</th>
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
        ajax: "{{ route('wilayah.datatable') }}",
        columns: [{
                data: 'DT_RowIndex',
                name: 'No'
            },
            {
                data: 'province',
                name: 'Provinsi'
            },
            {
                data: 'name',
                name: 'Nama Wilayah'
            },
            {
                name: "action",
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
    
    active_menu("#data_master", "#region")
</script>
@endpush

@endsection