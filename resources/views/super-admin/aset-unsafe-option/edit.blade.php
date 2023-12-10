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
                    <li class="breadcrumb-item">Aset Management</li>
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
                    << Kembali
                </button>
            </div>
            <form action="{{ route('aset-unsafe-option.update', $option->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="row row-cols-1 row-cols-lg-2">
                    <div class="col">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Aset <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name', $option->option_condition	) }}" placeholder="Masukkan name option">
                            @error('name')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 align-middle">
                            <input type="checkbox" class="form-check-input fs-5 mt-0 me-2 @error('status') is-invalid @enderror" name="status" id="optionStatus" value="ACTIVED" {{ $option->status == 'ACTIVED' ? 'checked' : '' }}>
                            <label for="optionStatus" class="align-middle mb-0">Aktif</label>
                            @error('status') <span class="text-danger d-block">{{$message}}</span> @enderror
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
    active_menu("#menu_aset", "#unsafe-option")
</script>
@endpush

<!-- Container-fluid Ends-->
@endsection
