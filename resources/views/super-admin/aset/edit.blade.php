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
                    <button onclick="window.location.href='{{ route('aset.index') }}'" class="btn btn-warning text-dark">
                        << Kembali
                    </button>
                </div>
                <form action="{{ route('aset.update', $aset->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="row row-cols-1 row-cols-lg-2">
                        <div class="col">
                            <div class="mb-3">
                                <label for="code" class="form-label">Kode Aset <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" id="code" value="{{ old('code', $aset->code) }}" placeholder="Masukkan kode aset" required>
                                @error('code') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Aset <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name', $aset->name) }}" placeholder="Masukkan nama aset" required>
                                @error('name') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="asset_master_type" class="form-label">Tipe Aset <span class="text-danger">*</span></label>
                                <select class="form-select @error('asset_master_type') is-invalid @enderror" name="asset_master_type" id="asset_master_type" required>
                                    <option value="" disabled selected>Pilih tipe aset</option>
                                    <option value="PATROL" {{ old('asset_master_type', $aset->asset_master_type) == 'PATROL' ? 'selected' : '' }}>Patrol</option>
                                    <option value="CLIENT" {{ old('asset_master_type', $aset->asset_master_type) == 'CLIENT' ? 'selected' : '' }}>Client</option>
                                </select>
                                @error('asset_master_type') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="short_desc" class="form-label">Deskripsi Singkat</label>
                                <textarea class="form-control @error('short_desc') is-invalid @enderror" name="short_desc" id="short_desc" placeholder="Masukkan deskripsi singkat">{{ old('short_desc', $aset->short_desc) }}</textarea>
                                @error('short_desc') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status Aset</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="ACTIVED" name="status" id="status" @if($aset->status == 'ACTIVED') checked @endif>
                                    <label class="form-check-label" for="status">
                                        ACTIVED
                                    </label>
                                </div>
                                @error('status') <span class="text-danger d-block">{{ $message }}</span>  @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="images" class="form-label">Gambar Aset</label>
                                <input type="file" class="form-control @error('images') is-invalid @enderror" name="images" id="images">
                                <small class="form-text d-block">Ekstensi gambar yang diperbolehkan: jpeg, png & jpg</small>
                                @error('images') <span class="text-danger d-block">{{ $message }}</span> @enderror

                                <!-- Tampilkan gambar saat ini jika ada, jika tidak, tampilkan gambar default -->
                                <img src="{{ $aset->images ? asset('gambar/aset/' . $aset->images) : asset('gambar/no-image.png') }}" width="200" class="mt-2">
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
        active_menu("#data_master", "#asset")
    </script>
    @endpush

@endsection
