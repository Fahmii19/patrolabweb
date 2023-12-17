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
                    <button onclick="window.location.href='{{ route('area.index') }}'" class="btn btn-warning text-dark">
                        << Kembali
                    </button>
                </div>
                <form action="{{ route('area.update', $area->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf 
                    @method('PUT')
                    <div class="row row-cols-1 row-cols-lg-2">
                        <div class="col">
                            <!-- Project -->
                            <div class="mb-3">
                                <label for="project_id" class="form-label">Nama Project <span class="text-danger">*</span></label>
                                <select class="form-select @error('project_id') is-invalid @enderror" name="project_id" id="project_id">
                                    <option value="" disabled selected>Pilih Project</option>
                                    @foreach ($projects as $project)
                                    <option value="{{ $project->id }}" {{ old('project_id', $area->project_id) == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                                    @endforeach
                                </select>
                                @error('project_id')
                                <span class="text-danger d-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Kode Area -->
                            <div class="mb-3">
                                <label for="code" class="form-label">Kode Area <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" id="code" value="{{ old('code', $area->code) }}" placeholder="Masukkan kode area">
                                @error('code') <span class="text-danger d-block">{{$message}}</span> @enderror
                            </div>
                            <!-- Nama Area -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Area <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name', $area->name) }}" placeholder="Masukkan Nama Area">
                                @error('name') <span class="text-danger d-block">{{$message}}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi Lengkap <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" placeholder="Masukkan deskripsi lengkap" rows="4">{{ old('description', $area->description) }}</textarea>
                                @error('description') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                            <!-- Status -->
                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="ACTIVED" name="status" @if($area->status == 'ACTIVED') checked @endif>
                                    <label class="form-check-label" for="status">
                                        ACTIVED
                                    </label>
                                </div>
                                @error('status') <span class="text-danger d-block">{{ $message }}</span>  @enderror
                            </div>
                        </div>
                        <div class="col">
                            <!-- Gambar -->
                            <div class="mb-3">
                                <label for="img_location" class="form-label">Tambah Gambar Area</label>
                                <input type="file" class="form-control @error('img_location') is-invalid @enderror" name="img_location[]" id="img_location" multiple>
                                <small class="form-text">Ekstensi gambar yang diperbolehkan: jpeg, png & jpg</small>
                                @error('img_location') <span class="text-danger d-block">{{$message}}</span> @enderror

                                <!-- Tampilkan gambar saat ini atau gambar default -->
                                <div class="row align-items-strecth mt-3">
                                    @foreach(explode(',', $area->img_location) as $index => $image)
                                        <div class="col-6 col-sm-4 col-md-3 col-lg-6 col-xxl-4 img-container d-inline-block mr-2">
                                            <img src="{{ $image ? asset('gambar/area/' . $image) : asset('gambar/no-image.png') }}" class="img-thumbnail">
                                            <!-- Checkbox untuk menghapus gambar -->
                                            @if ($image)
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="checkbox" name="delete_images[]" id="deleteImage{{ $index }}" value="{{ $image }}">
                                                <label class="form-check-label" for="deleteImage{{ $index }}">Hapus gambar</label>
                                            </div>
                                            @endif
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

@push('js')
<script>
    active_menu("#data_master", "#area")
</script>
@endpush
@endsection
