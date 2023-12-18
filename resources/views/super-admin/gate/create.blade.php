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
                    <button onclick="window.location.href='{{ route('gate.index') }}'" class="btn btn-warning text-dark">
                        << Kembali
                    </button>
                </div>
                <form action="{{route('gate.store')}}" method="POST">
                    @csrf
                    <div class="row row-cols-2">
                        <div class="col">
                            <div class="mb-3">
                                <label for="selectWilayah" class="form-label">Nama Wilayah <span class="text-danger">*</span></label>
                                <select class="form-select @error('id_wilayah') is-invalid @enderror" name="id_wilayah" onchange="get_project(this.value)" id="selectWilayah">
                                    <option value="" selected disabled>--Pilih--</option>
                                    @foreach ($wilayah as $item)
                                        <option value="{{ $item->id }}" {{ old('id_wilayah') == $item->id ? 'selected' : '' }}>{{ $item->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('id_wilayah') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="selectProject" class="form-label">Nama Project <span class="text-danger">*</span></label>
                                <select class="form-select @error('project_id') is-invalid @enderror" name="project_id" id="selectProject" required>
                                    <option value="" selected disabled>--Pilih--</option>
                                </select>
                                <span class="text-danger d-block" id="project-alert"></span>
                                @error('project_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="code" class="form-label">Kode Gate <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" id="name" value="{{old('code')}}" placeholder="Masukkan Kode Gate" required>
                                @error('code') <span class="text-danger d-block">{{$message}}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Gate <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{old('name')}}" placeholder="Masukkan Nama Gate" required>
                                @error('name') <span class="text-danger d-block">{{$message}}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-success">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

    @push('js')
    <script>
        function get_project(id_wilayah) {
            let project_base = $('#selectProject')
            let project_alert = $('#project-alert')
            $.ajax({
                url: "{{ url('/super-admin/project-by-wilayah-select') }}/" + id_wilayah,
                method: 'get',
                data: {
                    id_project: "{{ old('id_project') }}"
                },
                beforeSend: function() {
                    project_alert.removeClass('text-danger').addClass('text-black').text('Mengambil data project')
                },

                success: function(response) {
                    let data = response.data
                    project_base.html(data)
                    project_alert.text('')
                },
                error: function(response) {
                    project_base.html('<option value="" selected disabled>--Pilih--</option>')
                    project_alert.removeClass('text-black').addClass('text-danger').text('Tidak ada data project di wilayah ini')
                }
            })
        }

        active_menu("#data_master", "#gate")
    </script>
    @endpush
@endsection