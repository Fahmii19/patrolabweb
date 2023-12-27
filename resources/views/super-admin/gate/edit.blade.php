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
                <form action="{{route('gate.update', $gate->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row row-cols-2">
                        <div class="col">
                            <div class="mb-3">
                                <label for="selectArea" class="form-label">Nama Area <span class="text-danger">*</span></label>
                                <select class="form-select @error('area_id') is-invalid @enderror" name="area_id" onchange="get_patrol_area(this.value)" id="selectArea" required>
                                    <option value="" selected disabled>--Pilih--</option>
                                    @foreach ($area as $item)
                                        <option value="{{ $item->id }}" {{ old('area_id', $gate->patrol_area->area_id) == $item->id ? 'selected' : '' }}>{{ $item->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('area_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="selectPatrolArea" class="form-label">Nama Patrol Area <span class="text-danger">*</span></label>
                                <select class="form-select @error('patrol_area_id') is-invalid @enderror" name="patrol_area_id" id="selectPatrolArea" required>
                                    <option value="" selected disabled>--Pilih--</option>
                                    @foreach ($patrol_area as $item)
                                        <option value="{{ $item->id }}" {{ old('patrol_area_id', $gate->patrol_area->id) == $item->id ? 'selected' : '' }}>{{ $item->name }} </option>
                                    @endforeach
                                </select>
                                <span class="text-danger d-block" id="patrol-area-alert"></span>
                                @error('patrol_area_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="code" class="form-label">Kode Gate <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" id="name" value="{{old('code', $gate->code)}}" placeholder="Masukkan Kode Gate" required>
                                @error('code') <span class="text-danger d-block">{{$message}}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Gate <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{old('name', $gate->name)}}" placeholder="Masukkan Nama Gate" required>
                                @error('name') <span class="text-danger d-block">{{$message}}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="ACTIVED" id="status" name="status" @if($gate->status == 'ACTIVED') checked @endif>
                                    <label class="form-check-label" for="status">
                                        ACTIVED
                                    </label>
                                </div>
                                @error('status') <span class="text-danger d-block">{{ $message }}</span>  @enderror
                            </div>

                            <button class="btn btn-success">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

    @push('js')
    <script>
        function get_patrol_area(area_id) {
            let patrol_area_base = $('#selectPatrolArea')
            let patrol_area_alert = $('#patrol-area-alert')
            $.ajax({
                url: "{{ url('/super-admin/patrol-area-by-area') }}/" + area_id,
                method: 'get',
                data: {
                    area_id: "{{ old('area_id') }}"
                },
                beforeSend: function() {
                    patrol_area_alert.removeClass('text-danger').addClass('text-black').text('Mengambil data patrol area')
                },

                success: function(response) {
                    let data = response.data
                    patrol_area_base.html(data)
                    patrol_area_alert.text('')
                },
                error: function(response) {
                    patrol_area_base.html('<option value="" selected disabled>--Pilih--</option>')
                    patrol_area_alert.removeClass('text-black').addClass('text-danger').text('Tidak ada data patrol area di area ini')
                }
            })
        }

        active_menu("#data_master", "#gate")
    </script>
    @endpush
@endsection