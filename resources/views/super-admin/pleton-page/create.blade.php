@extends('layouts.admin')
@section('content')
    @component('components.dashboard.headpage')
        @slot('title')
        {{ $title }}
        @endslot
        @slot('bread')
            <li class="breadcrumb-item">Guard Management</li>
            <li class="breadcrumb-item">{{ $title }}</li>
        @endslot
    @endcomponent

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-end">
                    <button onclick="window.location.href='{{ route('pleton.index') }}'" class="btn btn-warning text-dark">
                        << Kembali
                    </button>
                </div>
                <form action="{{ route('pleton.store') }}" method="POST">
                    @csrf
                    <div class="row row-cols-1 row-cols-lg-2">
                        <div class="col">
                            <div class="mb-3">
                                <label for="area_id" class="form-label">Area <span class="text-danger">*</span></label>
                                <select class="form-select @error('area_id') is-invalid @enderror" name="area_id" id="area_id" required>
                                    <option value="" disabled selected>--Pilih Area--</option>
                                    @foreach ($area as $areaItem)
                                        <option value="{{ $areaItem->id }}" {{ old('area_id') == $areaItem->id ? 'selected' : '' }}>{{ $areaItem->name }}</option>
                                    @endforeach
                                </select>
                                @error('area_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="code" class="form-label">Kode Pleton</label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" id="code" value="{{ old('code') }}" placeholder="Masukkan kode pleton" required>
                                @error('code')
                                <span class="text-danger d-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Pleton <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}" placeholder="Masukkan nama pleton" required>
                                @error('name') <span class="text-danger d-block">{{ $message }}</span> @enderror
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
        active_menu("#menu-guard", "#sub-list-pleton")
    </script>
    @endpush
@endsection