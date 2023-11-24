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
                    <li class="breadcrumb-item">Area</li>
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
            <form action="{{route('check-point.store')}}" method="POST">
                @csrf
                <div class="row row-cols-1 row-cols-lg-2">
                    <div class="col">
                        <div class="mb-3">
                            <label for="idRound" class="form-label">Nama Round <span class="text-danger">*</span></label>
                            <select class="form-select @error('round_id') is-invalid @enderror" name="round_id" id="idRound" required>
                                <option value="" selected disabled>--Pilih--</option>
                                @foreach ($round as $item)
                                    <option value="{{ $item->id }}" {{ old('round_id') == $item->id ? 'selected' : '' }}>{{ $item->rute }}
                                </option>
                                @endforeach
                            </select>

                            @error('round_id')
                                <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                            <span class="text-danger d-block" id="area-alert"></span>
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama CheckPoint <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" id="nama" value="{{old('nama')}}" placeholder="Masukkan Nama CheckPoint">
                            @error('nama') <span class="text-danger d-block">{{$message}}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="lokasi" class="form-label">Lokasi CheckPoint <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('lokasi') is-invalid @enderror" name="lokasi" id="lokasi" value="{{old('lokasi')}}" placeholder="Masukkan Lokasi CheckPoint">
                            @error('nama') <span class="text-danger d-block">{{$message}}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="dangerStatus" class="form-label">Danger Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('danger_status') is-invalid @enderror" name="danger_status" id="dangerStatus">
                                <option value="" disabled selected> --Pilih-- </option>
                                <option value="low" {{ old('danger_status') == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="middle" {{ old('danger_status') == 'middle' ? 'selected' : '' }}>Middle</option>
                                <option value="high" {{ old('danger_status') == 'highh' ? 'selected' : '' }}>High</option>
                            </select>
                            @error('danger_status')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>
                        @if( old('status'))
                            <div class="mb-3 align-middle">
                                <input type="checkbox" class="form-check-input fs-5 mt-0 me-2 @error('status') is-invalid @enderror" name="status" id="checkPointStatus" value="aktif" checked>
                                <label for="checkPointStatus" class="align-middle mb-0">Aktif</label>
                                @error('status') <span class="text-danger d-block">{{$message}}</span> @enderror
                            </div>
                        @endif
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
            </form>
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
                id_area: "{{ old('id_area')}}"
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
    active_menu("#menu-checkpoint", "#sub-add-checkpoint")
</script>

@if(old('id_wilayah'))
<script>
    get_project("{{old('id_wilayah')}}")
</script>
@endif

@if(old('id_project'))
<script>
    get_area("{{old('id_project')}}")
</script>
@endif

@endpush
@endsection