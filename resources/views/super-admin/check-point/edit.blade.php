@extends('layouts.admin')
@section('content')
    @component('components.dashboard.headpage')
        @slot('title')
            {{ $title }}
        @endslot
        @slot('bread')
            <li class="breadcrumb-item">Checkpoint</li>
            <li class="breadcrumb-item">{{ $title }}</li>
        @endslot
    @endcomponent
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-end">
                    <button onclick="window.location.href='{{ route('check-point.index') }}'" class="btn btn-warning text-dark">
                        << Kembali
                    </button>
                </div>
                <form action="{{route('check-point.update', $checkpoint->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row row-cols-1 row-cols-lg-2">
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label" for="area">Area</label>
                                <select class="form-select" id="area" name="area" onchange="get_patrol_area(this.value)">
                                    <option selected value="0">---Pilih---</option>
                                    @foreach ($area as $item)
                                        <option value="{{ $item->id }}" {{ old('area', $checkpoint->round->patrol_area->area->id)  == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="selectPatrolArea">Patrol Area</label>
                                <select class="form-select" id="selectPatrolArea" name="patrol_area" onchange="get_round(this.value)">
                                    <option selected value="0">---Pilih---</option>
                                    @foreach ($patrol_area as $item)
                                        <option value="{{ $item->id }}" {{ old('area', $checkpoint->round->patrol_area->id)  == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-danger d-block" id="patrol-area-alert"></span>
                            </div>
                            <div class="mb-3">
                                <label for="selectRound" class="form-label">Nama Round <span class="text-danger">*</span></label>
                                <select class="form-select @error('round_id') is-invalid @enderror" name="round_id" id="selectRound" required>
                                    <option value="" selected disabled>--Pilih--</option>
                                    @foreach ($round as $item)
                                        <option value="{{ $item->id }}" {{ old('round_id', $checkpoint->round_id)  == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('round_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                <span class="text-danger d-block" id="round-alert"></span>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status Checkpoint</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="ACTIVED" id="status" name="status" @if(old('status', $checkpoint->status) == 'ACTIVED') checked @endif>
                                    <label class="form-check-label" for="status">
                                        ACTIVED
                                    </label>
                                </div>
                                @error('status') <span class="text-danger d-block">{{ $message }}</span>  @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Checkpoint <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="nama" value="{{$checkpoint->name}}" placeholder="Masukkan Nama CheckPoint">
                                @error('name') <span class="text-danger d-block">{{$message}}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="lokasi" class="form-label">Lokasi Checkpoint <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('location') is-invalid @enderror" name="location" id="lokasi" value="{{$checkpoint->location}}" placeholder="Masukkan Lokasi Checkpoint">
                                @error('location') <span class="text-danger d-block">{{$message}}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="koordinat" class="form-label">Koordinat Checkpoint <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('location_long_lat') is-invalid @enderror" name="location_long_lat" id="koordinat" value="{{$checkpoint->location_long_lat}}" placeholder="Masukkan Koordinat Checkpoint">
                                @error('location_long_lat') <span class="text-danger d-block">{{$message}}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="dangerStatus" class="form-label">Danger Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('danger_status') is-invalid @enderror" name="danger_status" id="dangerStatus">
                                    <option value="" disabled selected> --Pilih-- </option>
                                    <option value="LOW" {{ $checkpoint->danger_status == 'LOW' ? 'selected' : '' }}>Low</option>
                                    <option value="MIDDLE" {{ $checkpoint->danger_status == 'MIDDLE' ? 'selected' : '' }}>Middle</option>
                                    <option value="HIGH" {{ $checkpoint->danger_status == 'HIGH' ? 'selected' : '' }}>High</option>
                                </select>
                                @error('danger_status') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection

@push('js')
    <script>
        function get_patrol_area(area_id) {
            let patrol_area_base = $('#selectPatrolArea')
            let patrol_area_alert = $('#patrol-area-alert')
            $.ajax({
                url: "{{ url('/patrol-area-by-area') }}/" + area_id,
                method: 'get',
                data: {
                    area_id: "{{ old('area') }}"
                },
                beforeSend: function() {
                    patrol_area_alert.removeClass('text-danger').addClass('text-black').text('Mengambil data patrol area')
                },

                success: function(response) {
                    let data = response.data
                    patrol_area_base.html(data)
                    patrol_area_alert.text('')
                    patrol_area_base.find('option:first')
                    .prop('disabled', true)
                    .prop('hidden', true)
                    .text('--Pilih--');
                },
                error: function(response) {
                    patrol_area_base.html('<option value="" selected disabled hidden>--Tidak Ada--</option>')
                    patrol_area_alert.removeClass('text-black').addClass('text-danger').text('Tidak ada data patrol area di area ini')
                }
            })
        }

        function get_round(patrol_area_id) {
            let round_base = $('#selectRound')
            let round_alert = $('#round-alert')
            $.ajax({
                url: "{{ url('/round-by-patrol-area') }}/" + patrol_area_id,
                method: 'get',
                data: {
                    patrol_area_id: "{{ old('patrol_area') }}"
                },
                beforeSend: function() {
                    round_alert.removeClass('text-danger').addClass('text-black').text('Mengambil data round')
                },

                success: function(response) {
                    let data = response.data
                    round_base.html(data)
                    round_alert.text('')
                    round_base.find('option:first')
                    .prop('disabled', true)
                    .prop('hidden', true)
                    .text('--Pilih--');
                },
                error: function(response) {
                    round_base.html('<option value="" selected disabled hidden>--Tidak Ada--</option>')
                    round_alert.removeClass('text-black').addClass('text-danger').text('Tidak ada data round di patrol area ini')
                }
            })
        }

        active_menu("#menu-checkpoint")
    </script>
@endpush