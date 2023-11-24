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
                    << Kembali
                </button>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm-12 col-xl-6 col-lg-12 col-md-6">
            <div class="card">
                <div class="card-body row switch-showcase height-equal">
                    <form action="{{route('round.store')}}" method="POST">
                        @csrf
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
                            <label for="name" class="form-label">Nama Rute <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="rute" id="name" value="{{old('nama')}}" placeholder="Masukkan Nama Rute">
                            @error('nama') <span class="text-danger d-block">{{$message}}</span> @enderror
                        </div>
                        <div class="mb-3 align-middle">
                            <input type="checkbox" class="form-check-input fs-5 mt-0 me-2 @error('status') is-invalid @enderror" name="status" id="roundStatus" value="aktif">
                            <label for="roundStatus" class="align-middle mb-0">Aktif</label>
                            @error('status') <span class="text-danger d-block">{{$message}}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-xl-6 col-lg-12 col-md-6">
            <div class="card">
                <div class="card-body row switch-showcase height-equal">
                    <div class="mb-3">
                        <label for="id_rute" class="form-label">Pilih Round<span class="text-danger">*</span></label>
                        <select class="form-select @error('id_round') is-invalid @enderror" name="id_round" onchange="get_checkpoint(this.value)" id="id_rute">
                            <option value="" selected disabled>--Pilih--</option>
                            @foreach ($round as $item)
                                <option value="{{ $item->id }}" {{ old('id_round') == $item->id ? 'selected' : '' }}>{{ $item->rute }}
                                </option>
                            @endforeach
                        </select>
                        <div class="table-responsive mt-3">
                            <table class="table" id="tableCheckpoint">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width:40px;">No</th>
                                        <th scope="col">Check Point</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- <tr>
                                        <th scope="row">5</th>
                                        <td>Will 5</td>
                                        <td>Zamrud</td>
                                    </tr> --}}
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
                id_project: "{{ old('id_project') }}"
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
                id_area: "{{ old('id_area') }}"
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

    function get_checkpoint(id_round) {
        const area_table = $('#tableCheckpoint tbody')
        console.log(area_table);
        console.log(id_round);
        $.ajax({
            url: "{{ url('/super-admin/checkpoint-by-round') }}/" + id_round,
            method: 'get',
            data: {
                id_area: "{{ old('id_round') }}"
            },
            success: function(response) {
                console.log(response);
                let data = response.data
                area_table.html(data)
            },
            error: function(response) {
                area_table.html(`
                    <tr class="text-center">
                        <td colspan="2">Tidak ada checkpoint</td>
                    </tr>
                `)
            }
        })
    }
    active_menu("#menu-round", "#sub-round-create")
</script>

@endpush
@endsection