@extends('layouts.admin')
@section('content')
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
                    <button onclick="window.location.href='{{ route('branch.index') }}'" class="btn btn-warning text-dark">
                        << Kembali
                    </button>
                </div>
                <form action="{{ route('branch.update', $branch->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf 
                    @method('PUT')
                    <div class="row row-cols-1 row-cols-lg-2">
                        <div class="col">
                            <!-- Kode Branch -->
                            <div class="mb-3">
                                <label for="code" class="form-label">Kode Branch <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" id="code" value="{{ old('code', $branch->code) }}" placeholder="Masukkan kode branch" required>
                                @error('code') <span class="text-danger d-block">{{$message}}</span> @enderror
                            </div>
                            <!-- Nama Branch -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Branch <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name', $branch->name) }}" placeholder="Masukkan Nama Branch" required>
                                @error('name') <span class="text-danger d-block">{{$message}}</span> @enderror
                            </div>
                            <!-- Status -->
                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="ACTIVED" id="status" name="status" @if(old('status', $branch->status) == 'ACTIVED') checked @endif>
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
    <!-- Container-fluid Ends-->

    @push('js')
        <script>
            active_menu("#data_master", "#branch")
        </script>
    @endpush
@endsection
