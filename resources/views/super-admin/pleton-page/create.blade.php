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
                    <li class="breadcrumb-item">Area</li>
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
            <form action="{{route('pleton.store')}}" method="POST">
                @csrf
                <div class="row row-cols-1 row-cols-lg-2">
                    <div class="col">
                        <div class="mb-3">
                            <label for="id_pleton" class="form-label">Nama Pleton <span class="text-danger">*</span></label>
                            <select class="form-select @error('id_pleton') is-invalid @enderror" name="id_pleton" onchange="get_project(this.value)" id="myselect0">
                                <option value="" selected disabled>--Pilih--</option>
                                @foreach ($pletons as $item)
                                <option value="{{ $item->id }}" {{ old('id_pleton') == $item->id ? 'selected' : '' }}>{{ $item->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('id_pleton')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="id_guard" class="form-label">Nama Guard <span class="text-danger">*</span></label>
                            <select class="form-select @error('id_guard') is-invalid @enderror" name="id_guard" onchange="get_project(this.value)" id="myselect0">
                                <option value="" selected disabled>--Pilih--</option>
                                @foreach ($guards as $item)
                                <option value="{{ $item->id }}" {{ old('id_guard') == $item->id ? 'selected' : '' }}>{{ $item->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('id_guard')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </div>
</div>
<!-- Container-fluid Ends-->

@push('js')
<script>
    active_menu("#menu-checkpoint", "#sub-add-checkpoint")
</script>
@endpush
@endsection