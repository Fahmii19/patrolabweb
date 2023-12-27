@extends('layouts.admin')
@section('content')
    @component('components.dashboard.headpage')
        @slot('title')
            {{ $title }}s
        @endslot
        @slot('bread')
            <li class="breadcrumb-item">Guard Management</li>
            <li class="breadcrumb-item">{{ $title }}</li>
        @endslot
    @endcomponent
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-end">
                    <button onclick="window.location.href='{{ route('guard.index') }}'" class="btn btn-warning text-dark">
                        << Kembali
                    </button>
                </div>
                <form action="{{ route('guard.update', $guard->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="row row-cols-1 row-cols-lg-2">
                        <div class="col">
                            <!-- Kolom badge_number -->
                            <div class="mb-3">
                                <label for="badge_number" class="form-label">Nomor Badge <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('badge_number') is-invalid @enderror" name="badge_number" id="badge_number" placeholder="Masukkan Nomor Badge" value="{{ old('badge_number', $guard->badge_number) }}" required>
                                @error('badge_number') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                            <!-- Kolom name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Masukkan Nama" value="{{ old('name', $guard->name) }}" required>
                                @error('name') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                            <!-- Kolom gender -->
                            <div class="mb-3">
                                <label for="gender" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select class="form-select @error('gender') is-invalid @enderror" name="gender" id="gender" required>
                                    <option value="" selected disabled>--Pilih--</option>
                                    <option value="MALE" {{ old('gender', $guard->gender) == 'MALE' ? 'selected' : '' }}>Laki-Laki</option>
                                    <option value="FEMALE" {{ old('gender', $guard->gender) == 'FEMALE' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('gender') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                            <!-- Kolom dob -->
                            <div class="mb-3">
                                <label for="dob" class="form-label">DOB <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('dob') is-invalid @enderror" name="dob" id="dob" value="{{ old('dob', \Carbon\Carbon::parse($guard->dob)->format('Y-m-d')) }}" required>
                                @error('dob') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                            <!-- Kolom email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Masukkan Email" value="{{ old('email', $guard->email) }}" required>
                                @error('email') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                            <!-- Kolom Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Masukkan Password" value="{{ old('password') }}">
                                <small class="form-text">Jika password kosong, maka tetap menggunakan passsword yang lama</small>
                                @error('password') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                            <!-- Kolom address -->
                            <div class="mb-3">
                                <label for="address" class="form-label">Alamat <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('address') is-invalid @enderror" name="address" id="address" placeholder="Deskripsi tentang area patrol" rows="3" required>{{ old('address', $guard->address) }}</textarea>
                                @error('address') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="img_avatar" class="form-label">Gambar Profile </label>
                                <input type="file" accept="image/jpeg, image/jpg, image/png" class="form-control @error('img_avatar') is-invalid @enderror" name="img_avatar" id="img_avatar">
                                <small class="form-text d-block mb-2">Ekstensi gambar yang diperbolehkan: jpeg, png & jpg</small>
                                @error('img_avatar') <span class="text-danger d-block">{{$message}}</span> @enderror
                                <img src="{{ $guard->img_avatar ? asset('gambar/guard/' . $guard->img_avatar) : asset('gambar/no-image.png') }}" width="200">
                            </div>
                            <!-- Kolom wa -->
                            <div class="mb-3">
                                <label for="wa" class="form-label">Nomor WhatsApp <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('wa') is-invalid @enderror" name="wa" id="wa" placeholder="Masukkan Nomor WhatsApp" value="{{ old('wa', $guard->wa) }}" required>
                                @error('wa') <span class="text-danger d-block">{{ $message }}</span>  @enderror
                            </div>
                            <!-- Kolom pleton_id -->
                            <div class="mb-3">
                                <label for="pleton_id" class="form-label">Pleton ID <span class="text-danger">*</span></label>
                                <select class="form-select @error('pleton_id') is-invalid @enderror" name="pleton_id" id="pleton_id" required>
                                    <option value="" selected disabled>--Pilih Pleton--</option>
                                    @foreach ($pletons as $pleton)
                                        <option value="{{ $pleton->id }}" {{ old('pleton_id', $guard->pleton_id) == $pleton->id ? 'selected' : '' }}>{{ $pleton->name }}</option>
                                    @endforeach
                                </select>
                                @error('pleton_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                            <!-- Kolom shift_id -->
                            <div class="mb-3">
                                <label for="shift_id" class="form-label">Shift ID <span class="text-danger">*</span></label>
                                <select class="form-select @error('shift_id') is-invalid @enderror" name="shift_id" id="shift_id" required>
                                    <option value="" selected disabled>--Pilih Shift--</option>
                                    @foreach ($shifts as $shift)
                                        <option value="{{ $shift->id }}" {{ old('shift_id', $guard->shift_id) == $shift->id ? 'selected' : '' }}>{{ $shift->name }}</option>
                                    @endforeach
                                </select>
                                @error('shift_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    active_menu("#menu-guard", "#sub-list-guard")
</script>
@endpush