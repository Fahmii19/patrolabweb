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
                        <div class="mb-3">
                            <label for="badge_number" class="form-label">Nomor Badge <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('badge_number') is-invalid @enderror" name="badge_number" id="badge_number" placeholder="Masukkan Nomor Badge" value="{{ old('badge_number') }}">
                            @error('badge_number')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Masukkan Nama" value="{{ old('name') }}">
                            @error('name')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="dob" class="form-label">Tempat Tanggal Lahir <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('dob') is-invalid @enderror" name="dob" id="dob" placeholder="Masukkan Tempat Tanggal Lahir" value="{{ old('dob') }}">
                            @error('dob')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select class="form-select @error('gender') is-invalid @enderror" name="gender" id="myselect1">
                                <option value="" selected disabled>--Pilih--</option>
                                <option value="MALE" {{ old('gender') == 'MALE' ? 'selected' : '' }}>Laki Laki</option>
                                <option value="FEMALE" {{ old('gender') == 'FEMALE' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('gender')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Masukkan Email" value="{{ old('email') }}">
                            @error('email')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="wa" class="form-label">Nomor Whatsapp <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('wa') is-invalid @enderror" name="wa" id="wa" placeholder="Masukkan Nomor Whatsapp" value="{{ old('wa') }}">
                            @error('wa')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col">
                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" id="address" placeholder="Masukkan Alamat" value="{{ old('address') }}">
                            @error('address')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="img_avatar" class="form-label">Img Avatar <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('img_avatar') is-invalid @enderror" name="img_avatar" id="img_avatar" placeholder="Masukkan Alamat" value="{{ old('img_avatar') }}">
                            @error('img_avatar')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Masukkan Password" value="{{ old('password') }}">
                                @error('password')
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
    function get_project(id_wilayah) {
        let project_base = $('#data_roject')
        let project_item = $('#project_item').clone().removeAttr('id')

        $.ajax({
            url: "{{ url('/super-admin/project-by-wilayah') }}/" + id_wilayah,
            method: 'get',
            data: {
                id_project: "{{ old('id_project') ? implode(',',old('id_project')) : '' }}"
            },
            //menghapus checkbox sebelumnya jika di select form lain
            beforeSend: function() {
                project_base.html('<span>Mengambil data <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></span>')
            },

            success: function(response) {
                let data = response.data
                project_base.html(data)
            },
            error: function(response) {
                project_base.html('<span>Tidak ada data project di wilayah ini</span>')
            }
        })
    }
</script>
@if (old('id_wilayah'))
<script>
    get_project({
        {
            old('id_wilayah')
        }
    })
</script>
@endif
<script>
    active_menu("#menu-guard", "#sub-list-guard")
</script>
@endpush
@endsection