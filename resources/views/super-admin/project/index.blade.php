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
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"> <i data-feather="home"></i></a>
                        </li>
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
                            <th style="width:40px">No</th>
                            <th>Nama Project</th>
                            <th>Nama Region</th>
                            <th>Nama Branch</th>
                            <th>Waktu</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

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
        active_menu("#data_master", "#project")

    </script>

    <script>
        function delete_item(formId) {
            if (confirm('Apakah Anda yakin ingin menghapus item ini?')) {
                document.getElementById(formId).submit();
            }
        }


        $(document).ready(function() {
            $('#mytable').DataTable({
                processing: true
                , serverSide: true
                , ajax: "{{ route('project.datatable') }}"
                , columns: [{
                        data: 'DT_RowIndex'
                        , name: 'DT_RowIndex'
                    }
                    , {
                        data: 'name'
                        , name: 'name'
                    }
                    , {
                        data: 'wilayah'
                        , name: 'wilayah'
                    }

                    , {
                        data: 'branch'
                        , name: 'branch'
                    }

                    , {
                        data: 'created_at'
                        , name: 'created_at'
                    }
                    , {
                        data: 'action'
                        , name: 'action'
                        , orderable: false
                        , searchable: false
                        , render: function(data, type, full, meta) {
                            return `
                           <div class="d-flex">
                               <a href="${data.detailurl}" class="btn btn-primary me-2">Detail</a>
                               <a href="${data.editurl}" class="btn btn-warning me-2">Edit</a>
                     <form action="${data.deleteurl}" method="post" id="delete_form${meta.row}">
                         @csrf
                         @method('delete')
                         <button type="button" class="btn btn-danger" onclick="delete_item('delete_form${meta.row}')">Hapus</button>
                     </form>

                           </div>
                           `;
                        }
                    }

                ]
            });
        });

    </script>


    @endpush
    @endsection
