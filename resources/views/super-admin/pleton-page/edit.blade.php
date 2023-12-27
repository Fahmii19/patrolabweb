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
                <form action="{{ route('pleton.update', $pleton->id) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="row row-cols-1 row-cols-lg-2">
                        <div class="col">
                            <!-- Area -->
                            <div class="mb-3">
                                <label for="area_id" class="form-label">Area <span class="text-danger">*</span></label>
                                <select class="form-select @error('area_id') is-invalid @enderror" name="area_id" id="area_id" required>
                                    <option value="" disabled>--Pilih Area--</option>
                                    @foreach ($areas as $area)
                                        <option value="{{ $area->id }}" {{ old('area_id', $pleton->area_id) == $area->id ? 'selected' : '' }}>{{ $area->name }}</option>
                                    @endforeach
                                </select>
                                @error('area_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <!-- Code -->
                            <div class="mb-3">
                                <label for="code" class="form-label">Kode Pleton <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" id="code" value="{{ old('code', $pleton->code) }}" placeholder="Masukkan kode pleton" required>
                                @error('code') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <!-- Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Pleton <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name', $pleton->name) }}" placeholder="Masukkan name pleton" required>
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <!-- Status -->
                            <div class="mb-3">
                                <label for="status" class="form-label">Status Pleton</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="ACTIVED" id="status" name="status" @if($pleton->status == 'ACTIVED') checked @endif>
                                    <label class="form-check-label" for="status">
                                        ACTIVED
                                    </label>
                                </div>
                                @error('status') <span class="text-danger d-block">{{ $message }}</span>  @enderror
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
        active_menu("#menu-guard", "#sub-list-pleton");
    </script>
@endpush
