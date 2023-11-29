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
                    <li class="breadcrumb-item">Checkpoint</li>
                    <li class="breadcrumb-item">{{ $title }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-end">
                <button onclick="window.history.back()" class="btn btn-warning">
                    << Kembali
                </button>
            </div>
            <form action="{{route('check-point.store')}}" method="POST">
                @csrf
                @method('post')
                <div class="row row-cols-2">
                    <div class="col">
                        <div class="mb-3">
                            <label for="idRound" class="form-label">Nama Round <span class="text-danger">*</span></label>
                            <select class="form-select @error('round_id') is-invalid @enderror" name="round_id" id="idRound" required>
                                <option value="" selected disabled>--Pilih--</option>
                                @foreach ($round as $item)
                                    <option value="{{ $item->id }}" {{ old('round_id') == $item->id ? 'selected' : '' }}>{{ $item->rute }}
                                </option>
                                @endforeach
                            </select>

                            @error('round_id')
                                <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                            <span class="text-danger d-block" id="area-alert"></span>
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Checkpoint <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" id="nama" value="{{old('nama')}}" placeholder="Masukkan Nama CheckPoint">
                            @error('nama') <span class="text-danger d-block">{{$message}}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="lokasi" class="form-label">Lokasi Checkpoint <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('lokasi') is-invalid @enderror" name="lokasi" id="lokasi" value="{{old('lokasi')}}" placeholder="Masukkan Lokasi CheckPoint">
                            @error('nama') <span class="text-danger d-block">{{$message}}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="dangerStatus" class="form-label">Danger Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('danger_status') is-invalid @enderror" name="danger_status" id="dangerStatus">
                                <option value="" disabled selected> --Pilih-- </option>
                                <option value="LOW" {{ old('danger_status') == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="MIDDLE" {{ old('danger_status') == 'middle' ? 'selected' : '' }}>Middle</option>
                                <option value="HIGH" {{ old('danger_status') == 'high' ? 'selected' : '' }}>High</option>
                            </select>
                            @error('danger_status')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Update</button>
            </form>
        </div>
    </div>
</div>
<!-- Container-fluid Ends-->

@push('js')
    <script>
        active_menu("#menu-checkpoint", "#sub-add-checkpoint")
    </script>
@endpush
@endsection