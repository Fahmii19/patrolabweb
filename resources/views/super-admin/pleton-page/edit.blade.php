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
                    <label for="nama" class="form-label">Nama Pleton</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" id="nama" value="{{ old('nama', $pleton->nama) }}">
                    @error('nama')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="no_badge" class="form-label">Kode Pleton</label>
                    <input type="text" class="form-control @error('no_badge') is-invalid @enderror" name="no_badge" id="no_badge" value="{{ old('no_badge', $pleton->no_badge) }}">
                    @error('no_badge')
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
