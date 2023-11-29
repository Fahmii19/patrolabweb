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
            <form action="{{route('round.update', $round->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="row row-cols-2">
                    <div class="col">
                        <div class="mb-3">
                            <label for="selectWilayah" class="form-label">Nama Wilayah <span class="text-danger">*</span></label>
                            <select class="form-select @error('id_wilayah') is-invalid @enderror" name="id_wilayah" onchange="get_project(this.value)" id="selectWilayah">
                                <option value="" selected disabled>--Pilih--</option>
                                @foreach ($wilayah as $item)
                                <option value="{{ $item->id }}" {{ $round->id_wilayah == $item->id ? 'selected' : '' }}>{{ $item->nama }}
                                </option>
                                @endforeach
                            </select>
                            @error('id_wilayah')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="selectProject" class="form-label">Nama Project <span class="text-danger">*</span></label>
                            <select class="form-select @error('id_project') is-invalid @enderror" name="id_project" onchange="get_area(this.value)" id="selectProject">
                                <option value="" selected disabled>--Pilih--</option>
                                @foreach ($project as $item)
                                <option value="{{ $item->id }}" {{ $round->id_project == $item->id ? 'selected' : '' }}>{{ $item->name }}
                                </option>
                                @endforeach
                            </select>
                            <span class="text-danger d-block" id="project-alert"></span>
                        </div>
                        <div class="mb-3">
                            <label for="selectArea" class="form-label">Nama Area <span class="text-danger">*</span></label>
                            <select class="form-select @error('id_area') is-invalid @enderror" name="id_area" id="selectArea">
                                <option value="" selected disabled>--Pilih--</option>
                                @foreach ($area as $item)
                                <option value="{{ $item->id }}" {{ $round->id_area == $item->id ? 'selected' : '' }}>{{ $item->name }}
                                </option>
                                @endforeach
                            </select>
                            <span class="text-danger d-block" id="area-alert"></span>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Rute <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="rute" id="name" value="{{$round->rute}}" placeholder="Masukkan Nama Rute">
                            @error('nama') <span class="text-danger d-block">{{$message}}</span> @enderror
                        </div>
                        <div class="mb-3 align-middle">
                            <input type="checkbox" class="form-check-input fs-5 mt-0 me-2 @error('status') is-invalid @enderror" name="status" id="checkPointStatus" value="ACTIVED" checked>
                            <label for="checkPointStatus" class="align-middle mb-0">Aktif</label>
                            @error('status') <span class="text-danger d-block">{{$message}}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Container-fluid Ends-->

@push('js')
<script>
    function get_project(id_wilayah) {
        let project_base = $('#selectProject')
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
                project_base.html(data)
                project_alert.text('')
            },
            error: function(response) {
                project_base.html('<option value="" selected disabled>--Pilih--</option>')
                project_alert.removeClass('text-black').addClass('text-danger').text('Tidak ada data project di wilayah ini')
            }
        })
    }

    function get_area(id_project) {
        let area_base = $('#selectArea')
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

    
    active_menu("#menu-round")
</script>

@endpush
@endsection