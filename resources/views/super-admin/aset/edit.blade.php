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
                    <li class="breadcrumb-item">Aset</li>
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
            <form action="{{ route('aset.update', $aset->id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="row row-cols-1 row-cols-lg-2">
                    <div class="col">
                        <div class="mb-3">
                            <label for="code" class="form-label">code Aset <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" id="code" value="{{ old('code', $aset->code) }}" placeholder="Masukkan code aset">
                            @error('code')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">name Aset <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name', $aset->name) }}" placeholder="Masukkan name aset">
                            @error('name')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-control @error('status') is-invalid @enderror" name="status" id="status">
                                <option value="" disabled>Pilih status aset</option>
                                <option value="ACTIVED" {{ old('status', $aset->status) == 'ACTIVED' ? 'selected' : '' }}>ACTIVED</option>
                                <option value="INACTIVED" {{ old('status', $aset->status) == 'INACTIVED' ? 'selected' : '' }}>INACTIVED</option>
                            </select>
                            @error('status')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="short_desc" class="form-label">Deskripsi Singkat</label>
                            <textarea class="form-control @error('short_desc') is-invalid @enderror" name="short_desc" id="short_desc" placeholder="Masukkan deskripsi singkat">{{ old('short_desc', $aset->short_desc) }}</textarea>
                            @error('short_desc')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="asset_master_type" class="form-label">Tipe Aset</label>
                            <select class="form-control @error('asset_master_type') is-invalid @enderror" name="asset_master_type" id="asset_master_type">
                                <option value="" disabled selected>Pilih tipe aset</option>
                                <option value="PATROL" {{ old('asset_master_type', $aset->asset_master_type) == 'PATROL' ? 'selected' : '' }}>Patrol</option>
                                <option value="CLIENT" {{ old('asset_master_type', $aset->asset_master_type) == 'CLIENT' ? 'selected' : '' }}>Client</option>
                            </select>
                            @error('asset_master_type')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Gambar Aset</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="image">
                            @error('image')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                            <!-- Tampilkan gambar saat ini jika ada, jika tidak, tampilkan gambar default -->
                            <img src="{{ $aset->image ? asset('gambar/aset/' . $aset->image) : asset('gambar/no-image.png') }}" width="100" height="100" class="img-thumbnail mt-2">
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
    active_menu("#data_master", "#asset")

</script>
@endpush

<!-- Container-fluid Ends-->
@endsection
