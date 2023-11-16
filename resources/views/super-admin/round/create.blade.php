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
                    <li class="breadcrumb-item">Round</li>
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
            <div class="d-flex justify-content-end">
                <button onclick="window.history.back()" class="btn btn-warning">
                    << Kembali</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-xl-6 col-lg-12 col-md-6">
            <div class="card">
                <div class="card-body row switch-showcase height-equal">
                    <div class="mb-3">
                        <label for="id_area" class="form-label">Nama Wilayah <span class="text-danger">*</span></label>
                        <select class="form-select @error('id_wilayah') is-invalid @enderror" name="id_wilayah" onchange="get_project(this.value)" id="myselect0">
                            <option value="" selected disabled>--Pilih--</option>
                            @foreach ($wilayah as $item)
                            <option value="{{ $item->id }}" {{ old('id_wilayah') == $item->id ? 'selected' : '' }}>{{ $item->nama }}
                            </option>
                            @endforeach
                        </select>
                        @error('id_wilayah')
                        <span class="text-danger d-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="id_area" class="form-label">Nama Project <span class="text-danger">*</span></label>
                        <select class="form-select @error('id_project') is-invalid @enderror" name="id_project" onchange="get_area(this.value)" id="select-project">
                            <option value="" selected disabled>--Pilih--</option>
                        </select>
                        <span class="text-danger d-block" id="project-alert"></span>
                    </div>
                    <div class="mb-3">
                        <label for="id_area" class="form-label">Nama Area <span class="text-danger">*</span></label>
                        <select class="form-select @error('id_area') is-invalid @enderror" name="id_area" id="select-area">
                            <option value="" selected disabled>--Pilih--</option>
                        </select>
                        <span class="text-danger d-block" id="area-alert"></span>
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Rute <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" id="nama" value="{{old('nama')}}" placeholder="Masukkan Nama CheckPoint">
                        @error('nama') <span class="text-danger d-block">{{$message}}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary">Simpan</button>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-sm-12 col-xl-6 col-lg-12 col-md-6">
            <div class="card">
                <div class="card-body row switch-showcase height-equal">
                    <div class="mb-3">
                        <label for="id_area" class="form-label">Pilih Check Point <span class="text-danger">*</span></label>
                        <select class="form-select @error('id_wilayah') is-invalid @enderror" name="id_wilayah" onchange="get_project(this.value)" id="">
                            <option value="" selected disabled>--Pilih--</option>

                        </select>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Check Point</th>
                                        <th scope="col">Area</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>Will 1</td>
                                        <td>Zamrud</td>
                                        <td>
                                            <div class="button btn btn-primary">Del<i class="fa fa-trash ms-2"></i></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>Will 2</td>
                                        <td>Zamrud</td>
                                        <td>
                                            <div class="button btn btn-primary">Del<i class="fa fa-trash ms-2"></i></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td>Will 3</td>
                                        <td>Zamrud</td>
                                        <td>
                                            <div class="button btn btn-primary">Del<i class="fa fa-trash ms-2"></i></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">4</th>
                                        <td>Will 4</td>
                                        <td>Zamrud</td>
                                        <td>
                                            <div class="button btn btn-primary">Del<i class="fa fa-trash ms-2"></i></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">5</th>
                                        <td>Will 5</td>
                                        <td>Zamrud</td>
                                        <td>
                                            <div class="button btn btn-primary">Del<i class="fa fa-trash ms-2"></i></div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid Ends-->

@push('js')
<script>
    function get_project(id_wilayah) {
        let project_base = $('#select-project')
        //let project_item = $('#project_item').clone().removeAttr('id')
        let project_alert = $('#project-alert')
        $.ajax({
            url: "{{ url('/super-admin/project-by-wilayah-select') }}/" + id_wilayah,
            method: 'get',
            data: {
                id_project: "{{ old('id_project') ? implode(',',old('id_project')) : '' }}"
            },
            //menghapus checkbox sebelumnya jika di select form lain
            beforeSend: function() {
                project_alert.removeClass('text-danger').addClass('text-black').text('Mengambil data project')
            },

            success: function(response) {
                let data = response.data
                //console.log(data)
                project_base.html(data)
                project_alert.text('')
            },
            error: function(response) {
                project_base.html('<option value="" selected disabled>--Pilih--</option>')
                project_alert.removeClass('text-black').addClass('text-danger').text('Tidak ada data project di wilayah ini')
                //console.log(response)
            }
        })
    }

    function get_area(id_project) {
        let area_base = $('#select-area')
        //let project_item = $('#project_item').clone().removeAttr('id')
        let area_alert = $('#area-alert')
        $.ajax({
            url: "{{ url('/super-admin/area-by-project') }}/" + id_project,
            method: 'get',
            data: {
                id_area: "{{ old('id_area') ? implode(',',old('id_area')) : '' }}"
            },
            //menghapus checkbox sebelumnya jika di select form lain
            beforeSend: function() {
                area_alert.removeClass('text-danger').addClass('text-black').text('Mengambil data area')
            },

            success: function(response) {
                let data = response.data
                //console.log(data)
                area_base.html(data)
                area_alert.text('')
            },
            error: function(response) {
                area_base.html('<option value="" selected disabled>--Pilih--</option>')
                area_alert.removeClass('text-black').addClass('text-danger').text('Tidak ada data area di project ini')
                //console.log(response)
            }
        })
    }
    active_menu("#menu-round", "#sub-round-create")
</script>

@endpush
@endsection