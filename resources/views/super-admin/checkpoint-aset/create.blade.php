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
                    <li class="breadcrumb-item">Area</li>
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
                    << Kembali</button>
            </div>
            <form action="{{route('check-point.store')}}" method="POST">
                @csrf
                <div class="row row-cols-1 row-cols-lg-2">
                    <div class="col">
                        <div class="mb-3">
                            <label for="id_area" class="form-label">Nama Wilayah <span class="text-danger">*</span></label>
                            <select class="form-select @error('id_wilayah') is-invalid @enderror" name="id_wilayah" onchange="get_project(this.value)" id="myselect0">
                                <option value="" selected disabled>--Pilih--</option>
                                @foreach ($wilayah as $item)
                                <option value="{{ $item->id }}" {{ old('id_wilayah') == $item->id ? 'selected' : '' }}>{{ $item->nama }}
                                </option>
                                @endforeach
                            </select>
                            @error('id_wilayah')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="id_area" class="form-label">Nama Project <span class="text-danger">*</span></label>
                            <select class="form-select @error('id_wilayah') is-invalid @enderror" name="id_wilayah" onchange="get_project(this.value)" id="myselect0">
                                <option value="" selected disabled>--Pilih--</option>
                                @foreach ($wilayah as $item)
                                <option value="{{ $item->id }}" {{ old('id_wilayah') == $item->id ? 'selected' : '' }}>{{ $item->nama }}
                                </option>
                                @endforeach
                            </select>
                            @error('id_wilayah')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="id_area" class="form-label">Nama Area <span class="text-danger">*</span></label>
                            <select class="form-select @error('id_wilayah') is-invalid @enderror" name="id_wilayah" onchange="get_project(this.value)" id="myselect0">
                                <option value="" selected disabled>--Pilih--</option>
                                @foreach ($wilayah as $item)
                                <option value="{{ $item->id }}" {{ old('id_wilayah') == $item->id ? 'selected' : '' }}>{{ $item->nama }}
                                </option>
                                @endforeach
                                </select>
                                @error('id_wilayah')
                                <span class="text-danger d-block">{{ $message }}</span>
                                @enderror
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama CheckPoint <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" id="nama" value="{{old('nama')}}" placeholder="Masukkan Nama CheckPoint">
                            @error('nama') <span class="text-danger d-block">{{$message}}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="lokasi" class="form-label">Lokasi CheckPoint <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('lokasi') is-invalid @enderror" name="lokasi" id="lokasi" value="{{old('lokasi')}}" placeholder="Masukkan Lokasi CheckPoint">
                            @error('nama') <span class="text-danger d-block">{{$message}}</span> @enderror
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
    active_menu("#menu-checkpoint", "#sub-add-checkpoint")
</script>
@endpush
@endsection