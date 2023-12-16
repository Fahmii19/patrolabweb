@extends('layouts.admin')
@section('content')
<div class="container-fluid">
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
                    <button onclick="window.location.href='{{ route('project.index') }}'" class="btn btn-warning text-dark">
                        << Kembali
                    </button>
                </div>
                <form action="{{ route('project.update', $project->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row row-cols-1 row-cols-lg-2">
                        <div class="col">
                            <!-- Code -->
                            <div class="mb-3">
                                <label for="code" class="form-label">Kode <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" id="code" value="{{ old('code', $project->code) }}" placeholder="Masukkan kode" required>
                                @error('code') <span class="text-danger d-block">{{ $message }}</span>  @enderror
                            </div>
                            <!-- Project Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Proyek <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name', $project->name) }}" placeholder="Masukkan nama proyek" required>
                                @error('name') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                            <!-- Address -->
                            <div class="mb-3">
                                <label for="address" class="form-label">Alamat <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" id="address" value="{{ old('address', $project->address) }}" placeholder="Masukkan alamat" required>
                                @error('address') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                            <!-- Location Longitude and Latitude -->
                            <div class="mb-3">
                                <label for="location_long_lat" class="form-label">Longitude dan Latitude <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('location_long_lat') is-invalid @enderror" name="location_long_lat" id="location_long_lat" value="{{  $project->location_long_lat }}" placeholder="Longitude, Latitude" required>
                                @error('location_long_lat') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                            <!-- Status -->
                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="ACTIVED" name="status" @if($project->status == 'ACTIVED') checked @endif>
                                    <label class="form-check-label" for="status">
                                        ACTIVED
                                    </label>
                                </div>
                                @error('status') <span class="text-danger d-block">{{ $message }}</span>  @enderror
                            </div>
                        </div>

                        <div class="col">
                            <!-- Wilayah ID -->
                            <div class="mb-3">
                                <label for="wilayah_id" class="form-label">Wilayah ID <span class="text-danger">*</span></label>
                                <select class="form-select @error('wilayah_id') is-invalid @enderror" name="wilayah_id" required>
                                    <option value="" disabled>--Pilih--</option>
                                    @foreach ($wilayah as $item)
                                        <option value="{{ $item->id }}" {{ old('wilayah_id', $project->wilayah_id) == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('wilayah_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Branch -->
                            <div class="mb-3">
                                <label for="branch_id" class="form-label">Branch <span class="text-danger">*</span></label>
                                <select class="form-select @error('branch_id') is-invalid @enderror" name="branch_id" required>
                                    <option value="" disabled>--Pilih Branch--</option>
                                    @foreach ($branchs as $branch)
                                        <option value="{{ $branch->id }}" {{ old('branch_id', $project->branch_id) == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                                @error('branch_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
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
    active_menu("#data_master", "#project")
</script>
@endpush

@endsection
