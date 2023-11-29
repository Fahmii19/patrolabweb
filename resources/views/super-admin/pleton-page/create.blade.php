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
                    <li class="breadcrumb-item">Pleton Management</li>
                    <li class="breadcrumb-item active">{{ $title }}</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-end">
                <button onclick="window.history.back()" class="btn btn-warning">
                    << Kembali</button>
            </div>
            <form action="{{ route('pleton.store') }}" method="POST">
                @csrf
                <div class="row row-cols-1 row-cols-lg-2">
                    <div class="col">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Pleton <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}" placeholder="Masukkan nama pleton" required>
                            @error('name')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="code" class="form-label">Kode Pleton</label>
                            <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" id="code" value="{{ old('code') }}" placeholder="Masukkan kode pleton">
                            @error('code')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status Pleton</label>
                            <select class="form-select @error('status') is-invalid @enderror" name="status" id="status">
                                <option value="" disabled selected>--Pilih Status--</option>
                                <option value="ACTIVED" {{ old('status') == 'ACTIVED' ? 'selected' : '' }}>ACTIVED</option>
                                <option value="INACTIVED" {{ old('status') == 'INACTIVED' ? 'selected' : '' }}>INACTIVED</option>
                            </select>
                            @error('status')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="area_id" class="form-label">Area</label>
                            <select class="form-select @error('area_id') is-invalid @enderror" name="area_id" id="area_id">
                                <option value="" disabled selected>--Pilih Area--</option>
                                @foreach ($area as $areaItem)
                                <option value="{{ $areaItem->id }}" {{ old('area_id') == $areaItem->id ? 'selected' : '' }}>{{ $areaItem->name }}</option>
                                @endforeach
                            </select>
                            @error('area_id')
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
@endsection

@push('js')
<script>
    active_menu("#menu-guard", "#sub-list-pleton")

</script>
@endpush
