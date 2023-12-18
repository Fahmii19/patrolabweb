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
            <form action="{{route('area.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row row-cols-1 row-cols-lg-2">
                    <div class="col">
                        <div class="mb-3">
                            <label for="project_id" class="form-label">Nama Project <span class="text-danger">*</span></label>
                            <select class="form-select" name="project_id" id="project_id">
                                <option value="" selected disabled>--Pilih--</option>
                                @foreach ($project as $item)
                                    <option value="{{ $item->id }}" {{ old('project_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('project_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="code" class="form-label">Kode Area <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" id="code" value="{{old('code')}}" placeholder="Masukkan kode area" required>
                            @error('code') <span class="text-danger d-block">{{$message}}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Area <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{old('name')}}" placeholder="Masukkan Nama Area" required>
                            @error('name') <span class="text-danger d-block">{{$message}}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="img_location" class="form-label">Lokasi Image <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('img_location') is-invalid @enderror" name="img_location[]" id="img_location" multiple>
                            <small class="form-text">Ekstensi gambar yang diperbolehkan: jpeg, png & jpg</small>
                            @error('img_location[]') <span class="text-danger d-block">{{$message}}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi Lengkap <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" placeholder="Masukkan deskripsi lengkap" rows="4" required>{{ old('description') }}</textarea>
                            @error('description') <span class="text-danger d-block">{{ $message }}</span> @enderror
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
    active_menu("#data_master", "#area")
</script>
@endpush
@endsection
