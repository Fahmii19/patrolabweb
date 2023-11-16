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
                        <li class="breadcrumb-item">Master Data User</li>
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
                    <button type="buton" onclick="window.history.back()" class="btn btn-warning">
                        << Kembali</button>
                </div>
                <form action="{{ route('user.store') }}" method="post">
                    @csrf
                    <div class="row row-cols-1 row-cols-lg-2">
                        <div class="col">
                            <div class="mb-3">
                                <label for="guard_id" class="form-label">Pilih Guard <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('guard_id') is-invalid @enderror" name="guard_id"
                                    id="myselect0">
                                    <option value="" selected disabled>--Pilih--</option>
                                    @foreach ($guard as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('guard_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('guard_id')
                                    <span class="text-danger d-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- <div class="mb-3">
                                <label for="role" class="form-label">Pilih Hak Akses <span
                                        class="text-danger">*</span></label>
                                <div class="row row-cols-1 row-cols-lg-3">
                                    @foreach ($role as $item)
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="{{ $item->name }}"
                                                    name="role[]">
                                                <label class="form-check-label" for="">
                                                    {{ $item->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @error('role')
                                    <span class="text-danger d-block">{{ $message }}</span>
                                @enderror
                            </div> -->

                            <div class="mb-3">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('password') is-invalid @enderror"
                                    name="password" id="password" placeholder="Masukkan Password"
                                    value="{{ old('password') }}">
                                @error('password')
                                    <span class="text-danger d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" name="status" id="status">
                                    <option value="ACTIVED" {{ old('status') == 'ACTIVED' ? 'selected' : '' }}>Aktif</option>
                                    <option value="INACTIVED" {{ old('status') == 'INACTIVED' ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                                @error('status')<span class="text-danger d-block">{{ $message }}</span>@enderror
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
    <!-- Container-fluid Ends-->
    @push('js')
        <script>
            active_menu("#data_master", "#user")
        </script>
    @endpush
@endsection
