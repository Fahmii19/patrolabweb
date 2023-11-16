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
                    <li class="breadcrumb-item">Shift</li>
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
            <form action="{{ route('shift.update',$shift->id) }}" method="post">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-body">
                        <div class="row row-cols-1 row-cols-lg-2">

                            <div class="col">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Shift <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" id="nama" placeholder="Masukkan Nama Shift" value="{{ old('nama') ? old('nama') : $shift->nama }}">
                                    @error('nama')<span class="text-danger d-block">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <div class="col">
                                <div class="mb-3">
                                    <label for="mulai" class="form-label">Mulai <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('mulai') is-invalid @enderror" name="mulai" id="mulai" placeholder="Masukkan Mulai" value="{{ old('mulai') ? old('mulai') : $shift->mulai }}">
                                    @error('mulai')<span class="text-danger d-block">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <div class="col">
                                <div class="mb-3">
                                    <label for="selesai" class="form-label">Selesai <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('selesai') is-invalid @enderror" name="selesai" id="selesai" placeholder="Masukkan Selesai" value="{{ old('selesai') ? old('selesai') : $shift->selesai }}">
                                    @error('selesai')<span class="text-danger d-block">{{ $message }}</span>@enderror
                                </div>
                            </div>

                        </div>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@push('js')
<script>
    active_menu("#data_master", "#shift")
</script>
@endpush
<!-- Container-fluid Ends-->
@endsection