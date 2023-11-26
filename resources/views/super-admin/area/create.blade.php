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
            <form action="{{route('area.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row row-cols-1 row-cols-lg-2">
                    <div class="col">
                        <div class="mb-3">
                            <label for="code" class="form-label">Kode Area <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" id="code" value="{{old('code')}}" placeholder="Masukkan kode area">
                            @error('code') <span class="text-danger d-block">{{$message}}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Area <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{old('name')}}" placeholder="Masukkan Nama Area">
                            @error('name') <span class="text-danger d-block">{{$message}}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="img_location" class="form-label">Lokasi Image <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('img_location') is-invalid @enderror" name="img_location" id="img_location">
                            @error('img_location') <span class="text-danger d-block">{{$message}}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" name="status" id="status">
                                <option value="" disabled selected>Pilih Status</option>
                                <option value="ACTIVED" {{ old('status') == 'ACTIVED' ? 'selected' : '' }}>ACTIVED</option>

                                <option value="INACTIVED" {{ old('status') == 'INACTIVED' ? 'selected' : '' }}>INACTIVED</option>

                            </select>
                            @error('status')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="project_id" class="form-label">Nama Project <span class="text-danger">*</span></label>
                            <select class="form-select" name="project_id" id="myselect0">
                                <option selected value="" disabled>Pilih Project</option>
                                @foreach ($project as $item)
                                <option value="{{ $item->id }}" {{ old('project_id') == $item->id ? 'selected' : '' }}>{{ $item->nama_project }}</option>
                                @endforeach
                            </select>
                            @error('project_id')
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
    active_menu("#data_master", "#area")

</script>
@endpush
<!-- Container-fluid Ends-->
@endsection
