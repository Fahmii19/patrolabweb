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
                    <li class="breadcrumb-item">Reporting</li>
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
            <div class="d-flex justify-content-end">
                <button onclick="window.history.back()" class="btn btn-warning">
                    << Kembali</button>
            </div>
        </div>
    </div>
    <form action="{{ route('self-patrol.store') }}" method="POST" enctype="multipart/form-data" class="row">
        @csrf        
        <div class="col-sm-12 col-lg-12 col-xl-5">
            <div class="card">
                <div class="card-body row switch-showcase height-equal">
                    <div class="col-12 mb-3">
                        <label for="idGuard" class="form-label">Nama Guard<span class="text-danger">*</span></label>
                        <select class="form-select @error('id_guard') is-invalid @enderror" name="id_guard" id="idGuard" required>
                            <option value="" selected disabled>--Pilih--</option>
                            @foreach ($guard as $item)
                                <option value={{ $item->id }} {{ old('id_guard') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="select-checkpoint" class="form-label">Nama Checkpoint <span class="text-danger">*</span></label>
                        <select class="form-select @error('id_checkpoint') is-invalid @enderror" name="id_checkpoint" id="select-checkpoint" onchange="get_asset(this.value)" required>
                            <option value="" selected disabled>--Pilih--</option>
                            @foreach ($checkpoint as $item)
                                <option value={{ $item->id }} {{ old('id_checkpoint') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger d-block" id="checkpoint-alert"></span>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="patrolDate" class="form-label">Tanggal Patrol <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('patrol_date') is-invalid @enderror" name="patrol_date" id="patrolDate" value="{{old('patrol_date')}}">
                        @error('patrol_date') <span class="text-danger d-block">{{$message}}</span> @enderror
                    </div>
                    <div class="col-6">
                        <label for="patrolStartTime" class="form-label">Jam Mulai <span class="text-danger">*</span></label>
                        <input type="time" class="form-control @error('patrol_start_time') is-invalid @enderror" name="patrol_start_time" id="patrolStartTime" value="{{old('patrol_start_time')}}">
                        @error('patrol_start_time') <span class="text-danger d-block">{{$message}}</span> @enderror
                    </div>
                    <div class="col-6">
                        <label for="patrolFinishTime" class="form-label">Jam Selesai <span class="text-danger">*</span></label>
                        <input type="time" class="form-control @error('patrol_finish_time') is-invalid @enderror" name="patrol_finish_time" id="patrolFinishTime" value="{{old('patrol_finish_time')}}">
                        @error('patrol_finish_time') <span class="text-danger d-block">{{$message}}</span> @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-12 col-xl-7">
            <div class="card">
                <div class="card-body row switch-showcase height-equal">
                    <div class="mb-3">
                        <label for="id_area" class="form-label">Daftar Asset pada Checkpoint</label>
                    </div>
                    <div class="asset-wrapper mb-3"></div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-primary" type="submit">Insert</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- Container-fluid Ends-->

@push('js')
<script>
    function get_asset(id_checkpoint) {
        let checkpoint_base = $('#select-checkpoint')
        //let project_item = $('#project_item').clone().removeAttr('id')
        let checkpoint_alert = $('#checkpoint-alert')
        let asset_wrapper = $('.asset-wrapper')
        $.ajax({
            url: "{{ url('/super-admin/checkpoint-get-all-asset') }}/" + id_checkpoint,
            method: 'get',
            data: {
                id_checkpoint: "{{ old('id_checkpoint') }}"
            },
            //menghapus checkbox sebelumnya jika di select form lain
            beforeSend: function() {
                checkpoint_alert.removeClass('text-danger').addClass('text-black').text('Mengambil data checkpoint')
            },

            success: function(response) {
                let data = response.data
                // console.log(response);
                asset_wrapper.html(`
                    <div class="accordion" id="accordionAsset">
                        ${data}
                    </div>
                `);
                checkpoint_alert.text('')
            },
            error: function(response) {
                console.log(response);
                asset_wrapper.html('<div class="bg-warning p-3 rounded-3 text-dark">Tidak ada asset</div>')
                checkpoint_alert.removeClass('text-black').addClass('text-danger').text('Tidak ada data asset pada checkpoint ini')
            }
        })
    }

    function selectStatus(event) {
        const selectTarget = $(event.target);
        const selectData = $(selectTarget).data('unsafe-form');
        const selectUnsafe = $(selectData).find('select[name="option_id[]"]');
        const hiddenOption = $(selectData).find('input[name="asset_unsafe_option_id[]"]');
        const inputImage = $(selectData).find('input[name="unsafe_image[]"]');
        const selectValue = $(selectTarget).val();
        if (selectValue == "UNSAFE") {
            $(selectData).removeClass("d-none").addClass("d-block");
        } else {
            $(selectData).removeClass("d-block").addClass("d-none");
            $(selectUnsafe).val("");
            $(hiddenOption).val("");
            $(inputImage).val("");
        }
    }

    function selectOption(event) {
        const selectTarget = $(event.target);
        const hiddenOption = $(selectTarget).parent().find('input[name="asset_unsafe_option_id[]"]');
        hiddenOption.val($(selectTarget).find(":selected").val())
    }
    active_menu("#menu-report", "#sub-report-self-patrol")
</script>

@endpush
@endsection