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
                    <p>Nama Guard: {{ $guard->name }}</p>
                    <p>Badge Number: {{ $guard->badge_number }}</p>
                    <p>Email: {{ $guard->email }}</p>
                    <p>Gender: {{ $guard->gender }}</p>
                    <p>Date of Birth: {{ $guard->dob ? $guard->dob->format('d M Y') : 'N/A' }}</p>
                    <p>Phone (WhatsApp): {{ $guard->wa }}</p>
                    <p>Pleton: {{ $guard->pleton->name ?? 'N/A' }}</p> <!-- Displaying Pleton -->
                    <p>Shift: {{ $guard->shift->name ?? 'N/A' }}</p> <!-- Displaying Shift -->
                    <!-- Include other fields as necessary -->
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
