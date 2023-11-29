@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <!-- Page Title dan Breadcrumb -->
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h3>Edit Branch</h3>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"> <i data-feather="home"></i></a></li>
                    <li class="breadcrumb-item">Branch</li>
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
                <form action="{{ route('branch.update', $branch->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="row row-cols-1 row-cols-lg-2">
                        <div class="col">
                            <!-- Bidang Kode Branch -->
                            <div class="mb-3">
                                <label for="code" class="form-label">Kode Branch <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" id="code" value="{{ old('code', $branch->code) }}" placeholder="Masukkan kode branch">
                                @error('code') <span class="text-danger d-block">{{$message}}</span> @enderror
                            </div>
                            <!-- Bidang Nama Branch -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Branch <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name', $branch->name) }}" placeholder="Masukkan Nama Branch">
                                @error('name') <span class="text-danger d-block">{{$message}}</span> @enderror
                            </div>
                            <!-- Bidang Status -->
                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" name="status" id="status">
                                    <option value="" disabled>Pilih Status</option>
                                    <option value="ACTIVED" {{ old('status', $branch->status) == 'ACTIVED' ? 'selected' : '' }}>ACTIVED</option>
                                    <option value="INACTIVED" {{ old('status', $branch->status) == 'INACTIVED' ? 'selected' : '' }}>INACTIVED</option>
                                </select>
                                @error('status')
                                <span class="text-danger d-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Hapus Bidang yang tidak relevan untuk Branch -->
                            <!-- ... -->
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
    active_menu("#data_master", "#branch")

</script>
@endpush
@endsection
