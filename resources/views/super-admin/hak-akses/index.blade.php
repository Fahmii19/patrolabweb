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
                    <li class="breadcrumb-item">Hak Akses</li>
                    <li class="breadcrumb-item">{{ $title }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-lg-end mb-3">
            <a class="btn btn-success" href="{{ route('hak-akses.create') }}">Tambah Hak Akses</a>
        </div>
        <table class="table table-hover table-bordered" id="mytable">
            <thead class="bg-light">
                <tr>
                    <th class="text-nowrap" style="width:50px">No</th>
                    <th class="text-nowrap">Name</th>
                    <th class="text-nowrap">Permission</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Button trigger modal -->
<!-- Modal -->
<div class="modal fade" id="detail_permission" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Detail Permission</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Permission</th>
                                <th scope="col">Menu</th>
                                <th scope="col">Lihat</th>
                                <th scope="col">Buat</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Detail</th>
                                <th scope="col">Hapus</th>
                            </tr>
                        </thead>
                        <tbody id="base_akses">

                        </tbody>
                    </table>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div id="actionbase" class="d-none">
    <div class="akses">
        <button type="button" class="btn btn-primary" id="button_permission">Detail</button>
    </div>
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
    $('#mytable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('hak-akses.datatable') }}",
        columns: [{
                data: 'DT_RowIndex',
                name: 'No'
            },
            {
                data: 'name',
                name: 'Name'
            },
            {
                data: 'permission',
                render: function(data, type, row) {
                    let html = $('#actionbase').clone()
                    html = html.find('.akses')
                    html.find('#button_permission').attr('onclick', 'lihat_akses(' + row.id + ')')
                    return html.html()
                }
            }
        ]
    });
    active_menu("#data_master", "#hak_akses")

    function lihat_akses(id) {
        let modal = $('#detail_permission')
        $.ajax({
            url: "{{ route('get-hak-akses') }}",
            data: {
                id: id
            },
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            },
            beforeSend: function() {

            },
            success: function(response) {
                console.log(response)
                $('#base_akses').html(response.data)
                modal.modal('show')
            },
            error: function(response) {
                console.log(response)
            },
            complete: function() {

            }
        })

    }
</script>
@endpush
@endsection