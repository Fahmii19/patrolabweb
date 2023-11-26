@extends('layouts.admin')

@section('content')
@component('components.dashboard.headpage')
@slot('title') {{ $title }} @endslot
@slot('bread')
<li class="breadcrumb-item">Guard Management</li>
<li class="breadcrumb-item">{{ $title }}</li>
@endslot
@endcomponent

<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('guard.index') }}" class="btn btn-warning">Kembali</a>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <h5 class="card-title">Detail Guard</h5>
                    <p>Nama Guard: {{ $guard->nama }}</p>
                    <p>Kode Guard: {{ $guard->no_badge }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid Ends-->
@endsection

@push('js')
<script>
    active_menu("#menu-guard", "#sub-list-guard")

</script>
@endpush
