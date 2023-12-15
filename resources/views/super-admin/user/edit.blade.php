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
                <button type="buton" onclick="window.location.href='{{ route('user.index') }}'" class="btn btn-warning">
                    << Kembali
                </button>
            </div>
            <form action="{{ route('user.update', $user->id) }}" method="post">
                @csrf
                @method('put')
                <div class="row row-cols-1 row-cols-lg-2">
                    <div class="col">
                        <div class="mb-3">
                            <label for="role" class="form-label">Hak Akses <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('role') is-invalid @enderror" name="role" id="role" value="{{ $roleNames[0] }}" required readonly>
                        </div>
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

                        @if($roleNames[0] == 'admin-area')
                            <div class="mb-3">
                                <label for="accessArea" class="form-label d-block">Akses Area</label>
                                @php
                                    $areas = explode(',', $user->access_area);
                                @endphp
                                @for ($i=0; $i < count($area); $i++)
                                <div class="form-check d-inline-block me-3">
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        value="{{ $area[$i]->id }}" 
                                        name="area[]" 
                                        id="checkboxArea{{ $area[$i]->id }}"
                                        @if(in_array($area[$i]->id, $areas)) checked @endif
                                    >
                                    <label class="form-check-label" for="checkboxArea{{ $area[$i]->id }}">
                                        {{ $area[$i]->name }}
                                    </label>
                                </div>
                                @endfor
                                @error('area') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                        @endif
                        <div class="mb-3">
                            <label for="status" class="form-label d-block">Status</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="ACTIVED" name="status" @if($user->status == 'ACTIVED') checked @endif>
                                <label class="form-check-label" for="status">
                                    ACTIVED
                                </label>
                            </div>
                            @error('status') <span class="text-danger d-block">{{$message}}</span> @enderror
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
    <script>
        active_menu("#data_master", "#user")
    </script>
@endpush
@endsection
