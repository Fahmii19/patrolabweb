@extends('layouts.admin')
@section('content')
    @component('components.dashboard.headpage')
        @slot('title')
            {{ $title }}
        @endslot
        @slot('bread')
            <li class="breadcrumb-item">Reporting</li>
            <li class="breadcrumb-item">{{ $title }}</li>
        @endslot
    @endcomponent
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="card">
            <div class="card-body p-3">
                <div class="d-flex justify-content-end">
                    <button onclick="window.history.back()" class="btn btn-warning text-dark">
                        << Kembali
                    </button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-5">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <p class="mb-0 text-muted">Guard</p>
                                    <p class="fs-6">{{ $report->data_guard->name }}</p>
                                </div>
                                <div class="mb-3">
                                    <p class="mb-0 text-muted">Location</p>
                                    <p class="fs-6">{{ $report->accidental_location }}</p>
                                </div>
                                <div class="mb-3">
                                    <p class="mb-0 text-muted">Coordinat</p>
                                    <p class="fs-6"> {{ $report->accidental_long_lat_log }} </p>
                                </div>
                                <div class="mb-3">
                                    <p class="mb-0 text-muted">Patrol Time</p>
                                    <p class="fs-6">
                                        {{ $report->shift_start_time_log }} - {{ $report->shift_end_time_log }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <p class="mb-0 text-muted">Pleton</p>
                                    <p class="fs-6">{{ $report->pleton->name }}</p>
                                </div>
                                <div class="mb-3">
                                    <p class="mb-0 text-muted">Location Condition</p>
                                    <p class="fs-6">{{ $report->location_condition_log }}</p>
                                </div>
                                <div class="mb-3">
                                    <p class="mb-0 text-muted">Description</p>
                                    <p class="fs-6">{{ $report->description }}</p>
                                </div>
                                <div class="mb-3">
                                    <p class="mb-0 text-muted">Asset Condition</p>
                                    <p class="fs-6">{{ $report->asset_unsafe_option_log }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-7">
                <div class="card">
                    <div class="card-body">
                        <p class="fs-6">Gambar Report</p>
                        <div class="row g-2">
                        @foreach(explode(',', $report->images) as $index => $image)
                            @php $imageUrl = $image ? check_img_path($image) : asset('gambar/no-image.png'); @endphp
                            <div class="col-12 col-sm-6 col-xl-4">
                                <span class="btn p-0" data-bs-toggle="modal" data-bs-target="#imageModal{{ $index }}">
                                    <img src="{{ $imageUrl }}" class="img-fluid img-rounded" alt="{{ $image }}">
                                </span>
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @foreach(explode(',', $report->images) as $index => $image)
            <div class="modal fade" id="imageModal{{ $index }}" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content">
                        <div class="modal-body text-center">
                            <img src="{{ check_img_path($image) }}" alt="{{ $image }}" class="img-fluid">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"  data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@push('js')
    <script>
        active_menu("#menu-report", "#sub-report-self-patrol")
    </script>
@endpush