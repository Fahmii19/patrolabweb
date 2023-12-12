@php
$page = 'dashboard';
@endphp
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
                    <li class="breadcrumb-item"><a href="{{ route('admin-area.dashboard') }}"> <i data-feather="home"></i></a></li>
                    <li class="breadcrumb-item">{{ $title }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid starts-->
<div class="container-fluid">
    
</div>
@push('js')
<script>
    
    menu_active("#menu_dashboard")
</script>
@endpush

@endsection