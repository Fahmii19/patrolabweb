@extends('layouts.admin')
@section('content')
    @component('components.dashboard.headpage')
    @slot('title')
        {{ $title }}
    @endslot
    @slot('bread')
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item">Region</li>
        <li class="breadcrumb-item">{{ $title }}</li>
    @endslot
    @endcomponent
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-end">
                    <button onclick="window.location.href='{{ route('wilayah.index') }}'" class="btn btn-warning text-dark">
                        << Kembali
                    </button>
                </div>
                <form action="{{ route('wilayah.store') }}" method="POST">
                    @csrf
                    <div class="row row-cols-1 row-cols-lg-2">
                        <div class="col">
                            <div class="mb-3">
                                <label for="province_id" class="form-label">Nama Provinsi <span class="text-danger">*</span></label>
                                <select class="form-select @error('province_id') is-invalid @enderror" name="province_id">
                                    <option value="" selected disabled>--Pilih--</option>
                                    @foreach ($province as $item)
                                        <option value="{{ $item->id }}" {{ old('province_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('province_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Wilayah <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}" placeholder="Masukkan Nama wilayah" required>
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
            active_menu("#data_master", "#region")
        </script>
    @endpush
    <!-- Container-fluid Ends-->
@endsection
