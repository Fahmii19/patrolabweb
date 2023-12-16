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
            <div class="d-flex justify-content-end">
                <button onclick="window.location.href='{{ route('project.index') }}'" class="btn btn-warning text-dark">
                    << Kembali
                </button>
            </div>
            <form action="{{ route('project.store') }}" method="POST">
                @csrf
                <div class="row row-cols-1 row-cols-lg-2">
                    <div class="col">
                        <!-- Code -->
                        <div class="mb-3">
                            <label for="code" class="form-label">Kode Proyek <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" id="code" value="{{ old('code') }}" placeholder="Masukkan kode" required>
                            @error('code') <span class="text-danger d-block">{{ $message }} </span> @enderror
                        </div>
                        <!-- Project Name (Name) -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Proyek <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}" placeholder="Masukkan nama proyek" required>
                            @error('name') <span class="text-danger d-block">{{ $message }} </span> @enderror
                        </div>
                         <!-- Address -->
                         <div class="mb-3">
                            <label for="address" class="form-label">Alamat <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" id="address" value="{{ old('address') }}" placeholder="Masukkan alamat" required>
                            @error('address') <span class="text-danger d-block">{{ $message }}</span> @enderror
                        </div>
                        <!-- Location Longitude and Latitude -->
                        <div class="mb-3">
                            <label for="location_long_lat" class="form-label">Longitude dan Latitude <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('location_long_lat') is-invalid @enderror" name="location_long_lat" id="location_long_lat" value="{{ old('location_long_lat') }}" placeholder="Longitude, Latitude" required>
                            @error('location_long_lat') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            <small id="auto-fill-info" class="form-text"></small>
                        </div>
                    </div>
                    <div class="col">
                       <!-- Wilayah ID -->
                       <div class="mb-3">
                            <label for="city_id" class="form-label">Nama Wilayah <span class="text-danger">*</span></label>
                            <select class="form-select @error('city_id') is-invalid @enderror" name="city_id" required>
                                <option value="" selected disabled>--Pilih--</option>
                                @foreach ($wilayah as $item)
                                    <option value="{{ $item->id }}" {{ old('city_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('city_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                        </div>
                        <!-- Branch ID -->
                        <div class="mb-3">
                            <label for="branch_id" class="form-label">Nama Branch <span class="text-danger">*</span></label>
                            <select class="form-select @error('branch_id') is-invalid @enderror" name="branch_id" required>
                                <option value="" selected disabled>--Pilih Branch--</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('branch_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
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

    active_menu("#data_master", "#project");
</script>
@endpush
@endsection
