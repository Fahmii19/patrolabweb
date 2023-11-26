@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <!-- Page Title dan Breadcrumb -->
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h3>Edit Aset</h3>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"> <i data-feather="home"></i></a></li>
                    <li class="breadcrumb-item">Aset</li>
                    <li class="breadcrumb-item">Edit</li>
                </ol>
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
                <form action="{{ route('area.update', $area->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="row row-cols-1 row-cols-lg-2">
                        <div class="col">
                            <!-- Bidang Kode Area -->
                            <div class="mb-3">
                                <label for="code" class="form-label">Kode Area <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" id="code" value="{{ old('code', $area->code) }}" placeholder="Masukkan kode area">
                                @error('code') <span class="text-danger d-block">{{$message}}</span> @enderror
                            </div>
                            <!-- Bidang Nama Area -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Area <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name', $area->name) }}" placeholder="Masukkan Nama Area">
                                @error('name') <span class="text-danger d-block">{{$message}}</span> @enderror
                            </div>
                            <!-- Bidang Status -->
                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" name="status" id="status">
                                    <option value="" disabled>Pilih Status</option>
                                    <option value="ACTIVED" {{ old('status', $area->status) == 'ACTIVED' ? 'selected' : '' }}>ACTIVED</option>
                                    <option value="INACTIVED" {{ old('status', $area->status) == 'INACTIVED' ? 'selected' : '' }}>INACTIVED</option>
                                </select>
                                @error('status')
                                <span class="text-danger d-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Bidang Project -->

                            <div class="mb-3">
                                <label for="project_id" class="form-label">Nama Project <span class="text-danger">*</span></label>
                                <select class="form-select @error('project_id') is-invalid @enderror" name="project_id" id="project_id">
                                    <option value="" disabled selected>Pilih Project</option>
                                    @foreach ($projects as $project)
                                    <option value="{{ $project->id }}" {{ old('project_id', $area->project_id) == $project->id ? 'selected' : '' }}>{{ $project->nama_project }}</option>
                                    @endforeach
                                </select>
                                @error('project_id')
                                <span class="text-danger d-block">{{ $message }}</span>
                                @enderror
                            </div>



                            <!-- Bidang Gambar -->
                            <!-- Bidang Gambar -->
                            <div class="mb-3">
                                <label for="img_location" class="form-label">Gambar Area</label>
                                <input type="file" class="form-control @error('img_location') is-invalid @enderror" name="img_location[]" id="img_location" multiple>
                                @error('img_location') <span class="text-danger d-block">{{$message}}</span> @enderror

                                <!-- Tampilkan gambar saat ini atau gambar default -->
                                <div class="existing-images mt-3">
                                    @foreach(explode(',', $area->img_location) as $index => $image)
                                    <div class="img-container d-inline-block mr-2">
                                        <img src="{{ $image ? asset('gambar/area/' . $image) : asset('gambar/no-image.png') }}" width="100" height="100" class="img-thumbnail">
                                        <!-- Checkbox untuk menghapus gambar -->
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="delete_images[]" id="deleteImage{{ $index }}" value="{{ $image }}">
                                            <label class="form-check-label" for="deleteImage{{ $index }}">Hapus</label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>



                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>

@push('js')
<script>
    active_menu("#data_master", "#area")

</script>
@endpush
@endsection
