@extends('layouts.admin')
@section('content')
@component('components.dashboard.headpage')
@slot('title')
{{ $title }}
@endslot
@slot('bread')
<li class="breadcrumb-item">Guard Management</li>
<li class="breadcrumb-item">{{ $title }}</li>
@endslot
@endcomponent
<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-end">
                <button onclick="window.history.back()" class="btn btn-warning">
                    << Kembali</button>
            </div>
            <form action="{{ route('guard.store') }}" method="post">
                @csrf
                <div class="row row-cols-1 row-cols-lg-2">
                    <div class="col">
                        <!-- Kolom badge_number -->
                        <div class="mb-3">
                            <label for="badge_number" class="form-label">Nomor Badge <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('badge_number') is-invalid @enderror" name="badge_number" id="badge_number" placeholder="Masukkan Nomor Badge" value="{{ old('badge_number') }}">
                            @error('badge_number')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Kolom name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Masukkan Nama" value="{{ old('name') }}">
                            @error('name')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Kolom email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Masukkan Email" value="{{ old('email') }}">
                            @error('email')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Kolom gender -->
                        <div class="mb-3">
                            <label for="gender" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select class="form-select @error('gender') is-invalid @enderror" name="gender" id="gender">
                                <option value="" selected disabled>--Pilih--</option>
                                <option value="MALE" {{ old('gender') == 'MALE' ? 'selected' : '' }}>Laki-Laki</option>
                                <option value="FEMALE" {{ old('gender') == 'FEMALE' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('gender')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Kolom dob -->
                        <div class="mb-3">
                            <label for="dob" class="form-label">DOB <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('dob') is-invalid @enderror" name="dob" id="dob" value="{{ old('dob') }}">
                            @error('dob')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col">
                        <!-- Kolom address -->
                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" id="address" placeholder="Masukkan Alamat" value="{{ old('address') }}">
                            @error('address')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Kolom wa -->
                        <div class="mb-3">
                            <label for="wa" class="form-label">Nomor WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('wa') is-invalid @enderror" name="wa" id="wa" placeholder="Masukkan Nomor WhatsApp" value="{{ old('wa') }}">
                            @error('wa')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Kolom pleton_id -->
                        <div class="mb-3">
                            <label for="pleton_id" class="form-label">Pleton ID <span class="text-danger">*</span></label>
                            <select class="form-select @error('pleton_id') is-invalid @enderror" name="pleton_id" id="pleton_id">
                                <option value="" selected disabled>--Pilih Pleton--</option>
                                @foreach ($pletons as $pleton)
                                <option value="{{ $pleton->id }}" {{ old('pleton_id') == $pleton->id ? 'selected' : '' }}>{{ $pleton->name }}</option>
                                @endforeach
                            </select>
                            @error('pleton_id')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Kolom shift_id -->
                        <div class="mb-3">
                            <label for="shift_id" class="form-label">Shift ID <span class="text-danger">*</span></label>
                            <select class="form-select @error('shift_id') is-invalid @enderror" name="shift_id" id="shift_id">
                                <option value="" selected disabled>--Pilih Shift--</option>
                                @foreach ($shifts as $shift)
                                <option value="{{ $shift->id }}" {{ old('shift_id') == $shift->id ? 'selected' : '' }}>{{ $shift->name }}</option>
                                @endforeach
                            </select>
                            @error('shift_id')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Container-fluid Ends-->
@push('js')
<script>
    active_menu("#menu-guard", "#sub-list-guard")

</script>
@endpush
@endsection
