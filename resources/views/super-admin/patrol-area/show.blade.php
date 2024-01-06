@extends('layouts.admin')
    @section('content')
        @component('components.dashboard.headpage')
            @slot('title')
                {{ $title }}
            @endslot
            @slot('bread')
                <li class="breadcrumb-item">Patrol</li>
                <li class="breadcrumb-item">{{ $title }}</li>
            @endslot
        @endcomponent
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-end">
                    <button onclick="window.location.href='{{ route('patrol-area.index') }}'" class="btn btn-warning text-dark">
                        << Kembali
                    </button>
                </div>
                <p class="fs-6"> Patrol Area Detail</p>
            </div>
        </div>
    </div>
@endsection

<!-- Container-fluid Ends-->
@push('js')
<script>
    active_menu("#menu-patrol", "#sub-patrol-area")
</script>
@endpush