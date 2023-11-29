@extends('layouts.admin')

@section('content')
@component('components.dashboard.headpage')
@slot('title')
{{ $title }}
@endslot
@slot('bread')
<li class="breadcrumb-item">Pleton Management</li>
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
            <table id="mytable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th style="max-width: 40px;">No</th>
                        <th class="text-nowrap">Nama Pleton</th>
                        <th class="text-nowrap">Kode Pleton</th>
                        <th class="text-nowrap">Status</th>
                        <th class="text-nowrap">Area ID</th>
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
    $(document).ready(function() {
        $('#mytable').DataTable({
            scrollX: true
            , processing: true
            , serverSide: true
            , ajax: "{{ route('pleton.datatable') }}"
            , columns: [{
                    data: 'DT_RowIndex'
                    , name: 'DT_RowIndex'
                    , orderable: false
                    , searchable: false
                }
                , {
                    data: 'name'
                    , name: 'name'
                }
                , {
                    data: 'code'
                    , name: 'code'
                }
                , {
                    data: 'status'
                    , name: 'status'
                }
                , {
                    data: 'area'
                    , name: 'area'
                }
                , {
                    name: "Action"
                    , render: function(data, type, row) {
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

</script>

<script>
    active_menu("#menu-guard", "#sub-list-pleton")

</script>
@endpush

@endsection
