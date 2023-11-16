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
                    <li class="breadcrumb-item">shift</li>
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
            <form action="{{ route('shift.store') }}" method="post">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row row-cols-1 row-cols-lg-2">

                            <div class="col">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Shift <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Masukkan Nama Shift" value="{{ old('name') }}">
                                    @error('name')<span class="text-danger d-block">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <div class="col">
                                <div class="mb-3">
                                    <label for="start_time" class="form-label">Mulai <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control @error('start_time') is-invalid @enderror" name="start_time" id="start_time" placeholder="Masukkan Mulai" value="{{ old('start_time') }}">
                                    @error('start_time')<span class="text-danger d-block">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <div class="col">
                                <div class="mb-3">
                                    <label for="end_time" class="form-label">Selesai <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control @error('end_time') is-invalid @enderror" name="end_time" id="end_time" placeholder="Masukkan Selesai" value="{{ old('end_time') }}">
                                    @error('end_time')<span class="text-danger d-block">{{ $message }}</span>@enderror
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
    active_menu("#data_master", "#wilayah")
</script>
@endpush
<!-- Container-fluid Ends-->
@endsection