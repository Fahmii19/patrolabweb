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
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"> <i data-feather="home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Wilayah</li>
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
                <form action="{{ route('project-model.store') }}" method="POST">

                    @csrf
                    <div class="row row-cols-1 row-cols-lg-2">
                        <div class="col">

                            <div class="mb-3">
                                <label for="namaWilayah" class="form-label">Kode Wilayah <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('namaWilayah') is-invalid @enderror"
                                    name="namaWilayah" id="namaWilayah" value="{{ old('namaWilayah') }}"
                                    placeholder="Masukkan kode wilayah">
                                @error('namaWilayah')
                                    <span class="text-danger d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="namaProyek" class="form-label">Nama Proyek <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('namaProyek') is-invalid @enderror"
                                    name="namaProyek" id="namaProyek" value="{{ old('namaProyek') }}"
                                    placeholder="Masukkan nama proyek">
                                @error('namaProyek')
                                    <span class="text-danger d-block">{{ $message }}</span>
                                @enderror
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
            active_menu("#data_master", "#project")
        </script>
    @endpush



    <!-- Container-fluid Ends-->
@endsection
