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
                    <li class="breadcrumb-item">Wilayah</li>
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

            <form action="{{ route('project-model.store') }}" method="POST">
                @csrf
                <div class="row row-cols-1 row-cols-lg-2">
                    <div class="col">

                        <!-- Project Name (Name) -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Proyek <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}" placeholder="Masukkan nama proyek">
                            @error('name')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Code -->
                        <div class="mb-3">
                            <label for="code" class="form-label">Kode <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" id="code" value="{{ old('code') }}" placeholder="Masukkan kode">
                            @error('code')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>



                        <!-- Wilayah ID -->
                        <div class="mb-3">
                            <label for="wilayah_id" class="form-label">Wilayah ID <span class="text-danger">*</span></label>
                            <select class="form-select @error('wilayah_id') is-invalid @enderror" name="wilayah_id">
                                <option value="" selected disabled>--Pilih--</option>
                                @foreach ($wilayah as $item)
                                <option value="{{ $item->id }}" {{ old('wilayah_id') == $item->id ? 'selected' : '' }}>{{ $item->nama }}</option>
                                @endforeach
                            </select>
                            @error('wilayah_id')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="branch_id" class="form-label">Branch <span class="text-danger">*</span></label>
                            <select class="form-select @error('branch_id') is-invalid @enderror" name="branch_id">
                                <option value="" selected disabled>--Pilih Branch--</option>
                                @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                                @endforeach
                            </select>
                            @error('branch_id')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>


                    </div>

                    <div class="col">

                        <!-- Address -->
                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" id="address" value="{{ old('address') }}" placeholder="Masukkan alamat">
                            @error('address')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Location Longitude and Latitude -->

                        <div class="mb-3">
                            <label for="location_long_lat" class="form-label">Longitude dan Latitude</label>

                            <input type="text" class="form-control @error('location_long_lat') is-invalid @enderror" name="location_long_lat" id="location_long_lat" value="{{ old('location_long_lat') }}" placeholder="Longitude, Latitude">
                            @error('location_long_lat')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                            <small id="auto-fill-info" class="form-text"></small>
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" name="status">
                                <option value="ACTIVED" {{ old('status') == 'ACTIVED' ? 'selected' : '' }}>Aktif</option>
                                <option value="INACTIVED" {{ old('status') == 'INACTIVED' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                            @error('status')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>


                    </div>
                </div>

                <button type="submit" class="btn btn-success">Simpan</button>
            </form>


        </div>
    </div>
</div>

@push('js')
<script>
    active_menu("#data_master", "#project");

</script>

<script>
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(fillLocation, showError);
        } else {
            document.getElementById('auto-fill-info').textContent = "Geolocation is not supported by this browser.";
        }
    }

    function fillLocation(position) {
        var latlong = position.coords.latitude + "," + position.coords.longitude;
        document.getElementById('location_long_lat').value = latlong;
        document.getElementById('auto-fill-info').textContent = 'Koordinat diisi otomatis berdasarkan lokasi Anda saat ini.';
    }

    function showError(error) {
        let message = "";
        switch (error.code) {
            case error.PERMISSION_DENIED:
                message = "Akses lokasi ditolak oleh pengguna.";
                break;
            case error.POSITION_UNAVAILABLE:
                message = "Informasi lokasi tidak tersedia.";
                break;
            case error.TIMEOUT:
                message = "Permintaan mendapatkan lokasi pengguna telah habis waktu.";
                break;
            default:
                message = "Terjadi kesalahan yang tidak diketahui.";
                break;
        }
        document.getElementById('auto-fill-info').textContent = message;
    }

    window.onload = getLocation; // Memanggil fungsi saat halaman dimuat

</script>



@endpush



<!-- Container-fluid Ends-->
@endsection
