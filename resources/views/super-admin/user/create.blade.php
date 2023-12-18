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
                <button type="buton" onclick="window.location.href='{{ route('user.index') }}'" class="btn btn-warning text-dark">
                    << Kembali
                </button>
            </div>
            <form action="{{ route('user.store') }}" method="post">
                @csrf
                <div class="row row-cols-1 row-cols-lg-2">
                    <div class="col">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Masukkan Nama" value="{{ old('name') }}" required>
                            @error('name') <span class="text-danger d-block">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Masukkan Email" value="{{ old('email') }}" required>
                            @error('email') <span class="text-danger d-block">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Masukkan Password" value="{{ old('password') }}" required>
                            @error('password') <span class="text-danger d-block">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="accessArea" class="form-label d-block">Akses Area</label>
                            @foreach ($area as $item)
                            <div class="form-check d-inline-block me-3">
                                <input class="form-check-input" type="checkbox" value="{{ $item->id }}" name="area[]">
                                <label class="form-check-label" for="flexCheckChecked">
                                    {{ $item->name }}
                                </label>
                            </div>
                            @endforeach
                            @error('area') <span class="text-danger d-block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-start">
                    <button type="submit "class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Container-fluid Ends-->

@push('js')
    <script>
        active_menu("#data_master", "#user")
    </script>
@endpush
@endsection
