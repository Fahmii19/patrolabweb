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
                    <li class="breadcrumb-item">Round</li>
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
                    << Kembali
                </button>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm-12 col-xl-6 col-lg-12 col-md-6">
            <div class="card">
                <div class="card-body row switch-showcase height-equal">
                    <div class="mb-3">
                        <label for="id_rute" class="form-label">Pilih Round<span class="text-danger">*</span></label>
                        <select class="form-select @error('id_round') is-invalid @enderror" name="id_round" onchange="get_checkpoint(this.value)" id="id_rute">
                            <option value="" selected disabled>--Pilih--</option>
                            @foreach ($round as $item)
                                <option value="{{ $item->id }}" {{ old('id_round') == $item->id ? 'selected' : '' }}>{{ $item->rute }}
                                </option>
                            @endforeach
                        </select>
                        <div class="table-responsive mt-3">
                            <table class="table" id="tableCheckpoint">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width:40px;">No</th>
                                        <th scope="col">Check Point</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- <tr>
                                        <th scope="row">5</th>
                                        <td>Will 5</td>
                                        <td>Zamrud</td>
                                    </tr> --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid Ends-->

@push('js')
<script>
    function get_checkpoint(id_round) {
        const area_table = $('#tableCheckpoint tbody')
        console.log(area_table);
        console.log(id_round);
        $.ajax({
            url: "{{ url('/super-admin/checkpoint-by-round') }}/" + id_round,
            method: 'get',
            data: {
                id_area: "{{ old('id_round') }}"
            },
            success: function(response) {
                console.log(response);
                let data = response.data
                area_table.html(data)
            },
            error: function(response) {
                area_table.html(`
                    <tr class="text-center">
                        <td colspan="2">Tidak ada checkpoint</td>
                    </tr>
                `)
            }
        })
    }
    active_menu("#menu-round", "#sub-round-create")
</script>

@endpush
@endsection