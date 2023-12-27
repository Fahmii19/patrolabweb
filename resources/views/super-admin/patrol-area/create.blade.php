@extends('layouts.admin')
@section('content')
    @component('components.dashboard.headpage')
        @slot('title')
            {{ $title }}
        @endslot
        @slot('bread')
            <li class="breadcrumb-item">Patrol</li>
            <li class="breadcrumb-item">{{ $title }}</li>
        @endslot
    @endcomponent
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-end">
                    <button onclick="window.location.href='{{ route('patrol-area.index') }}'" class="btn btn-warning text-dark">
                        << Kembali
                    </button>
                </div>
                <form action="{{route('patrol-area.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row row-cols-1 row-cols-lg-2">
                        <div class="col">
                            <div class="mb-3">
                                <label for="area_id" class="form-label">Nama Area <span class="text-danger">*</span></label>
                                <select class="form-select" name="area_id" id="area_id" required>
                                    <option value="" selected disabled>--Pilih--</option>
                                    @foreach ($area as $item)
                                        <option value="{{ $item->id }}" {{ old('area_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('area_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="code" class="form-label">Kode Patrol Area <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" id="code" value="{{old('code')}}" placeholder="Masukkan kode patrol area" required>
                                @error('code') <span class="text-danger d-block">{{$message}}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Patrol Area <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{old('name')}}" placeholder="Masukkan nama patrol area" required>
                                @error('name') <span class="text-danger d-block">{{$message}}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="location_long_lat" class="form-label">Titik Koordinat Patrol Area</label>
                                <input type="text" class="form-control @error('location_long_lat') is-invalid @enderror" name="location_long_lat" id="location_long_lat" value="{{old('location_long_lat')}}" placeholder="Masukkan titik koordinat patrol area">
                                @error('location_long_lat') <span class="text-danger d-block">{{$message}}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="img_location" class="form-label">Thumbnail Patrol Area </label>
                                <input type="file" accept="image/jpeg, image/jpg, image/png" class="form-control @error('img_location') is-invalid @enderror" name="img_location" id="img_location">
                                <small class="form-text">Ekstensi gambar yang diperbolehkan: jpeg, png & jpg</small>
                                @error('img_location') <span class="text-danger d-block">{{$message}}</span> @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" placeholder="Deskripsi tentang area patrol" rows="4">{{ old('description') }}</textarea>
                                @error('description') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="img_desc_location" class="form-label">Gambar Area Patrol</label>
                                <input type="file" class="form-control @error('img_desc_location[]') is-invalid @enderror" name="img_desc_location[]" accept="image/jpeg, image/jpg, image/png" id="img_desc_location" multiple>
                                <small class="form-text">Ekstensi gambar yang diperbolehkan: jpeg, png & jpg</small>
                                @error('img_desc_location[]') <span class="text-danger d-block">{{$message}}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="d-block text-end">
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('js')
        <script> active_menu("#menu-patrol", "#sub-patrol-area") </script>
    @endpush
@endsection
