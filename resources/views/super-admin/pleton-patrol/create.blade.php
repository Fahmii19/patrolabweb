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
                    <button onclick="window.location.href='{{ route('pleton-patrol-area.index') }}'" class="btn btn-warning text-dark">
                        << Kembali
                    </button>
                </div>
                <form action="{{ route('pleton-patrol-area.store') }}" method="POST">
                    @csrf
                    <div class="row row-cols-1 row-cols-lg-2">
                        <div class="col">
                            <div class="mb-3">
                                <label for="pleton_id" class="form-label">Nama Pleton <span class="text-danger">*</span></label>
                                <select class="form-select" name="pleton_id" id="pleton_id" required>
                                    <option value="" selected disabled>--Pilih--</option>
                                    @foreach ($pleton as $item)
                                        <option value="{{ $item->id }}" {{ old('pleton_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('pleton_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="patrol_area_id" class="form-label">Patrol Area <span class="text-danger">*</span></label>
                                <select class="form-select" name="patrol_area_id" id="patrol_area_id" required>
                                    <option value="" selected disabled>--Pilih--</option>
                                    @foreach ($patrol_area as $item)
                                        <option value="{{ $item->id }}" {{ old('patrol_area_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('patrol_area_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </form>
            </div>
        </div>
    </div>
    @push('js')
        <script>
            active_menu("#menu-guard", "#sub-pleton-patrol")
        </script>
    @endpush
@endsection
