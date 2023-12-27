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
                <button type="buton" onclick="window.location.href='{{ route('shift.index') }}'" class="btn btn-warning text-dark">
                    << Kembali
                </button>
            </div>
            <form action="{{ route('shift.update', $shift->id) }}" method="post">
                @csrf
                @method('put')
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="row row-cols-1 row-cols-lg-2">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Shift <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Masukkan Nama Shift" value="{{ old('name', $shift->name) }}" required>
                                    @error('name')<span class="text-danger d-block">{{ $message }}</span>@enderror
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="start_time" class="form-label">Mulai <span class="text-danger">*</span></label>
                                            <input type="time" class="form-control @error('start_time') is-invalid @enderror" name="start_time" id="start_time" placeholder="Masukkan Mulai" value="{{ old('start_time', $shift->start_time) }}" required>
                                            @error('start_time')<span class="text-danger d-block">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="end_time" class="form-label">Selesai <span class="text-danger">*</span></label>
                                            <input type="time" class="form-control @error('end_time') is-invalid @enderror" name="end_time" id="end_time" placeholder="Masukkan Selesai" value="{{ old('end_time', $shift->end_time) }}" required>
                                            @error('end_time')<span class="text-danger d-block">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-start">
                            <button class="btn btn-success">Simpan</button>
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
