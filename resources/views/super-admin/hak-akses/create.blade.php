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
                    <li class="breadcrumb-item">Hak Akses</li>
                    <li class="breadcrumb-item">{{ $title }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid starts-->
<div class="container-fluid">
    <form action="{{ route('hak-akses.store') }}" method="post">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="row">

                    <div class="col">
                        <div class="mb-3 col-lg-3">
                            <label for="name" class="form-label">Role <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Masukkan Role" value="{{ old('role_name') }}">
                            @error('name')<span class="text-danger d-block">{{ $message }}</span>@enderror
                        </div>


                    </div>


                    <div class="mb-3">
                        <label for="permission_id" class="form-label">Permission <span class="text-danger">*</span></label>
                        <div>
                            <!-- <b>Aset</b> -->

                            <b>Aset</b>
                            <div class="row row-cols-1 row-cols-lg-6 mt-2">
                                @foreach (Spatie\Permission\Models\Permission::where('title','asset')->get() as $item)
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="{{$item->id}}" id="" name="permission_id[]" checked>
                                        <label class="form-check-label" for="">
                                            {{ $item->name }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        @error('permission_id')<span class="text-danger d-block">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="d-flex justify-content-start">
                    <button class="btn btn-success">Simpan</button>
                </div>
            </div>

        </div>
</div>
</form>
</div>


<!-- Container-fluid Ends-->
@endsection