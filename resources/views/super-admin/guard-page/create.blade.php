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
                        <!-- Kolom no_badge -->
                        <div class="mb-3">
                            <label for="no_badge" class="form-label">Nomor Badge <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('no_badge') is-invalid @enderror" name="no_badge" id="no_badge" placeholder="Masukkan Nomor Badge" value="{{ old('no_badge') }}">
                            @error('no_badge')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Kolom nama -->
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" id="nama" placeholder="Masukkan Nama" value="{{ old('nama') }}">
                            @error('nama')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Kolom ttl (Tempat Tanggal Lahir) -->
                        <div class="mb-3">
                            <label for="ttl" class="form-label">Tempat Tanggal Lahir <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('ttl') is-invalid @enderror" name="ttl" id="ttl" value="{{ old('ttl') }}">
                            @error('ttl')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Kolom jenis_kelamin -->
                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select class="form-select @error('jenis_kelamin') is-invalid @enderror" name="jenis_kelamin" id="jenis_kelamin">
                                <option value="" selected disabled>--Pilih--</option>
                                <option value="laki-laki" {{ old('jenis_kelamin') == 'laki-laki' ? 'selected' : '' }}>Laki-Laki</option>
                                <option value="perempuan" {{ old('jenis_kelamin') == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Kolom email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Masukkan Email" value="{{ old('email') }}">
                            @error('email')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Kolom wa (Whatsapp) -->
                        <div class="mb-3">
                            <label for="wa" class="form-label">Nomor Whatsapp <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('wa') is-invalid @enderror" name="wa" id="wa" placeholder="Masukkan Nomor Whatsapp" value="{{ old('wa') }}">
                            @error('wa')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col">

                        {{-- select option wilayah --}}
                        <div class="mb-3">
                            <label for="id_wilayah" class="form-label">Wilayah <span class="text-danger">*</span></label>
                            <select class="form-select @error('id_wilayah') is-invalid @enderror" name="id_wilayah" id="id_wilayah" onchange="get_project(this.value)">
                                <option value="" selected disabled>--Pilih--</option>
                                @foreach ($wilayah as $item)
                                <option value="{{ $item->id }}" {{ old('id_wilayah') == $item->id ? 'selected' : '' }}>{{ $item->nama }}</option>
                                @endforeach
                            </select>
                            @error('id_wilayah')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Select option area --}}
                        <div class="mb-3">
                            <label for="id_area" class="form-label">Area <span class="text-danger">*</span></label>
                            <select class="form-select @error('id_area') is-invalid @enderror" name="id_area" id="id_area">
                                <option value="" selected disabled>--Pilih--</option>
                                @foreach ($area as $item)
                                <option value="{{ $item->id }}" {{ old('id_area') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('id_area')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>



                        <!-- Kolom alamat -->
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="alamat" placeholder="Masukkan Alamat" value="{{ old('alamat') }}">
                            @error('alamat')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Kolom password -->
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
            url: "{{ url('/super-admin/project-by-wilayah') }}/" + id_wilayah
            , method: 'get'
            , data: {
                id_project: "{{ old('id_project') ? implode(',',old('id_project')) : '' }}"
            },
            //menghapus checkbox sebelumnya jika di select form lain
            beforeSend: function() {
                project_base.html('<span>Mengambil data <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></span>')
            },

            success: function(response) {
                let data = response.data
                project_base.html(data)
            }
            , error: function(response) {
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
