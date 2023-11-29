@extends('layouts.admin')

@section('content')
@component('components.dashboard.headpage')
@slot('title')
Edit Pleton
@endslot
@slot('bread')
<li class="breadcrumb-item">Pleton Management</li>
<li class="breadcrumb-item active">Edit Pleton</li>
@endslot
@endcomponent

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-end">
                <button onclick="window.history.back()" class="btn btn-warning">
                    << Kembali</button>
            </div>
            <form action="{{ route('pleton.update', $pleton->id) }}" method="post">
                @csrf
                @method('put')

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Pleton</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name', $pleton->name) }}">
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="code" class="form-label">Kode Pleton</label>
                    <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" id="code" value="{{ old('code', $pleton->code) }}">
                    @error('code')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status Pleton</label>
                    <select class="form-select @error('status') is-invalid @enderror" name="status" id="status">
                        <option value="" disabled>--Pilih Status--</option>
                        <option value="ACTIVED" {{ old('status', $pleton->status) == 'ACTIVED' ? 'selected' : '' }}>ACTIVED</option>
                        <option value="INACTIVED" {{ old('status', $pleton->status) == 'INACTIVED' ? 'selected' : '' }}>INACTIVED</option>
                    </select>
                    @error('status')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="area_id" class="form-label">Area</label>
                    <select class="form-select @error('area_id') is-invalid @enderror" name="area_id" id="area_id">
                        <option value="" disabled>--Pilih Area--</option>
                        @foreach ($areas as $area)
                        <option value="{{ $area->id }}" {{ old('area_id', $pleton->area_id) == $area->id ? 'selected' : '' }}>{{ $area->name }}</option>
                        @endforeach
                    </select>
                    @error('area_id')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>



                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    active_menu("#menu-guard", "#sub-list-pleton");

</script>
@endpush
