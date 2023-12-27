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
                    <button onclick="window.location.href='{{ route('notice-boards.index') }}'" class="btn btn-warning text-dark">
                        << Kembali
                    </button>
                </div>
                <form action="{{route('notice-boards.store')}}" method="POST">
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
                                <label for="title" class="form-label">Judul Pengumuman <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" value="{{old('title')}}" placeholder="Masukkan judul pengumuman" required>
                                @error('code') <span class="text-danger d-block">{{$message}}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" placeholder="Deskripsi tentang area patrol" rows="4" required>{{ old('description') }}</textarea>
                                @error('description') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">Simpan</button>
                </form>
            </div>
        </div>
    </div>

    @push('js')
        <script> active_menu("#menu-patrol", "#sub-notice") </script>
    @endpush
@endsection
