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
                <a href="{{ route('guard.create') }}" class="btn btn-success">Tambah Guard</a>
            </div>
            <table id="mytable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th style="max-width: 40px;">No</th>
                        <th class="text-nowrap">No Badge</th>
                        <th class="text-nowrap">Nama</th>
                        <th class="text-nowrap">Email</th>
                        <th class="text-nowrap">Created At</th>
                        <th class="text-nowrap">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<div id="actionbase" class="d-none">
    <div class="d-flex">
        <form method="post" class="d-flex">
            @csrf
            @method('delete')

            <a id="show" class="btn btn-primary me-2">Detail</a>
            <a id="edit" class="btn btn-warning me-2">Edit</a>
            <button onclick="hapus_data(event)" class="btn btn-danger me-2" type="button">Hapus</button>
        </form>
    </div>
</div>
<!-- Container-fluid Ends-->
@push('js')
<script>
    $('#mytable').addClass('w-100').DataTable({
        scrollX: true
        , processing: true
        , serverSide: true
        , ajax: "{{ route('guard.datatable') }}"
        , columns: [{
                data: 'DT_RowIndex'
                , name: 'No'
            }
            , {
                data: 'no_badge'
                , name: 'no_badge'
            }
            , {
                data: 'nama'
                , name: 'nama'
            }
            , {
                data: 'email'
                , name: 'email'
            }
            , {
                data: 'created_at'
                , name: 'created_at'
            }
            , {
                name: "Action"
                , render: function(data, type, row) {
                    console.log(row)
                    let html = $('#actionbase').clone()
                    html = html.find('.d-flex')
                    html.find('#show').attr('href', row.action.showurl)
                    html.find('#edit').attr('href', row.action.editurl)
                    let form = html.find('form').attr('action', row.action.deleteurl)
                        .attr('id', 'delete_form' + row.id)
                    form.find('button').attr('form-id', '#delete_form' + row.id)
                    return html.html()
                }
            }
        ]
    });

</script>
<!-- <div class="d-flex">
    <a class="btn btn-warning me-2">Edit</a>
    <button class="btn btn-danger me-2">Hapus</button>
</div> -->
<script>
    active_menu("#menu-guard", "#sub-list-guard")

</script>
@endpush
@endsection
