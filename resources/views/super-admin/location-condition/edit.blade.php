@extends('layouts.admin')
@section('content')
    @component('components.dashboard.headpage')
        @slot('title')
            {{ $title }}
        @endslot
        @slot('bread')
            <li class="breadcrumb-item">Reporting</li>
            <li class="breadcrumb-item">{{ $title }}</li>
        @endslot
    @endcomponent
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-end">
                    <button onclick="window.location.href='{{ route('location-condition.index') }}'" class="btn btn-warning text-dark">
                        << Kembali
                    </button>
                </div>
                <form action="{{ route('location-condition.update', $location->id) }}" method="POST">
                    @csrf 
                    @method('PUT')
                    <div class="row row-cols-1 row-cols-lg-2">
                        <div class="col">
                            <div class="mb-3">
                                <label for="option_condition" class="form-label">Nama Kondisi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('option_condition') is-invalid @enderror" name="option_condition" id="option_condition" value="{{ old('option_condition', $location->option_condition) }}" placeholder="Masukkan nama kondisi">
                                @error('option_condition') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi</label>
                                <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description" value="{{ old('description', $location->description) }}" placeholder="Masukkan name option">
                                @error('description') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                            <!-- Status -->
                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="ACTIVED" id="status" name="status" @if(old('status', $location->status) == 'ACTIVED') checked @endif>
                                    <label class="form-check-label" for="status">
                                        ACTIVED
                                    </label>
                                </div>
                                @error('status') <span class="text-danger d-block">{{ $message }}</span>  @enderror
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-success">Simpan</button>
                            </div>
                        </div>
                    </div>                    
                </form>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection

@push('js')
<script>
    active_menu("#menu-report", "#sub-report-location-condition")
</script>
@endpush