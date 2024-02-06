@php $page = 'dashboard'; @endphp

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
                    <li class="breadcrumb-item">Profile</li>
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
            <form action="{{ route('profile.update', $user->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="row row-cols-1 row-cols-lg-2">
                    <div class="col">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Masukkan Nama" value="{{ $user->name }}" required>
                            @error('name') <span class="text-danger d-block">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Masukkan Email" value="{{ $user->email }}" required>
                            @error('email') <span class="text-danger d-block">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="text" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Masukkan Password Baru" value="">
                            <small class="form-text">Jika password kosong, maka tetap menggunakan passsword yang lama</small>
                            @error('password') <span class="text-danger d-block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="img_avatar" class="form-label">Gambar Profile </label>
                            <input type="file" accept="image/jpeg, image/jpg, image/png" class="form-control @error('img_avatar') is-invalid @enderror" name="img_avatar" id="img_avatar">
                            <small class="form-text d-block mb-2">Ekstensi gambar yang diperbolehkan: jpeg, png & jpg</small>
                            @error('img_avatar') <span class="text-danger d-block">{{$message}}</span> @enderror
                            <img src="{{ $user->img_avatar ? asset('gambar/profile/' . $user->img_avatar) : URL::asset('/template/assets/images/dashboard/profile.jpg') }}" width="200">
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-start">
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Container-fluid Ends-->
@push('js')
@endpush

@endsection