@extends('layouts.admin')
@section('content')
    @component('components.dashboard.headpage')
        @slot('title')
            {{ $title }}
        @endslot
        @slot('bread')
            <li class="breadcrumb-item">Checkpoint</li>
            <li class="breadcrumb-item">{{ $title }}</li>
        @endslot
    @endcomponent
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-end">
                    <button onclick="window.location.href='{{ route('check-point.index') }}'" class="btn btn-warning text-dark">
                        << Kembali
                    </button>
                </div>
                <form action="{{route('check-point.update', $checkpoint->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row row-cols-2">
                        <div class="col">
                            <div class="mb-3">
                                <label for="idRound" class="form-label">Nama Round <span class="text-danger">*</span></label>
                                <select class="form-select @error('round_id') is-invalid @enderror" name="round_id" id="idRound" required>
                                    <option value="" selected disabled>--Pilih--</option>
                                    @foreach ($round as $item)
                                        <option value="{{ $item->id }}" {{ $checkpoint->round_id == $item->id ? 'selected' : '' }}>{{ $item->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('round_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                <span class="text-danger d-block" id="area-alert"></span>
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Checkpoint <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="nama" value="{{$checkpoint->name}}" placeholder="Masukkan Nama CheckPoint">
                                @error('name') <span class="text-danger d-block">{{$message}}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="lokasi" class="form-label">Lokasi Checkpoint <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('location') is-invalid @enderror" name="location" id="lokasi" value="{{$checkpoint->location}}" placeholder="Masukkan Lokasi Checkpoint">
                                @error('location') <span class="text-danger d-block">{{$message}}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="koordinat" class="form-label">Koordinat Checkpoint <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('location_long_lat') is-invalid @enderror" name="location_long_lat" id="koordinat" value="{{$checkpoint->location_long_lat}}" placeholder="Masukkan Koordinat Checkpoint">
                                @error('location_long_lat') <span class="text-danger d-block">{{$message}}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="dangerStatus" class="form-label">Danger Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('danger_status') is-invalid @enderror" name="danger_status" id="dangerStatus">
                                    <option value="" disabled selected> --Pilih-- </option>
                                    <option value="LOW" {{ $checkpoint->danger_status == 'LOW' ? 'selected' : '' }}>Low</option>
                                    <option value="MIDDLE" {{ $checkpoint->danger_status == 'MIDDLE' ? 'selected' : '' }}>Middle</option>
                                    <option value="HIGH" {{ $checkpoint->danger_status == 'HIGH' ? 'selected' : '' }}>High</option>
                                </select>
                                @error('danger_status') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="ACTIVED" id="status" name="status" @if(old('status', $checkpoint->status) == 'ACTIVED') checked @endif>
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
        active_menu("#menu-checkpoint")
    </script>
@endpush