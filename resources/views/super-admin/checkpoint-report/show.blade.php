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
                                    <p class="mb-0 text-muted">Created By</p>
                                    <p class="fs-6">{{ $report->user->name }}</p>
                                </div>
                                <div class="mb-3">
                                    <p class="mb-0 text-muted">Pleton</p>
                                    <p class="fs-6">{{ $report->pleton->name }}</p>
                                </div>
                                <div class="mb-3">
                                    <p class="mb-0 text-muted">Business Date</p>
                                    <p class="fs-6">{{ $report->business_date }}</p>
                                </div>
                                <div class="mb-3">
                                    <p class="mb-0 text-muted">Patrol Time</p>
                                    <p class="fs-6">
                                        {{ $report->shift_start_time_log }} - {{ $report->shift_end_time_log }}
                                    </p>
                                </div>
                                <div class="mb-3">
                                    <p class="mb-0 text-muted">Location</p>
                                    <p class="fs-6">
                                        {{ $report->checkpoint_location_log }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <p class="mb-0 text-muted">Area</p>
                                    <p class="fs-6">{{ $report->checkpoint->round->patrol_area->area->name }}</p>
                                </div>
                                <div class="mb-3">
                                    <p class="mb-0 text-muted">Patrol Area</p>
                                    <p class="fs-6">{{ $report->checkpoint->round->patrol_area->name }}</p>
                                </div>
                                <div class="mb-3">
                                    <p class="mb-0 text-muted">Round</p>
                                    <p class="fs-6">{{ $report->checkpoint->round->name }}</p>
                                </div>
                                <div class="mb-3">
                                    <p class="mb-0 text-muted">Checkpoint</p>
                                    <p class="fs-6">{{ $report->checkpoint_name_log }}</p>
                                </div>
                                <div class="mb-3">
                                    <p class="mb-0 text-muted">Coordinat</p>
                                    <p class="fs-6">
                                        {{ $report->checkpoint_location_long_lat_log }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-7">
                <div class="card">
                    <div class="card-body">
                        <p class="fs-6">Daftar Asset pada Checkpoint</p>
                        @if ($report->asset_patrol_checkpoint_log->count() > 0)
                            @foreach ($report->asset_patrol_checkpoint_log as $item)
                                <div class="accordion-item">
                                    <div class="accordion-header" id="headingAsset{{ $item->id }}">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $item->id }}" aria-expanded="false" aria-controls="collapse{{ $item->id }}">
                                            {{ $item->asset_code_log . ' - ' . $item->asset_name_log }}
                                            @if ($item->status == 'SAFE')
                                                <span class="ms-2 badge badge-success">{{ $item->status }}</span>
                                            @else
                                                <span class="ms-2 badge badge-danger">{{ $item->status }}</span>
                                            @endif
                                        </button>
                                    </div>
                                    <div id="collapse{{ $item->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $item->id }}">
                                        <div class="accordion-body">
                                            <div class="row gx-1 gy-3">
                                                <div class="col-12 col-sm-3 col-md-5 col-xl-3">
                                                    <p class="mb-0 text-muted">Status</p>
                                                    <p class="fs-6">
                                                        {{ $item->asset_unsafe_option_id ? $item->asset_unsafe_option->option_condition : '-' }}
                                                    </p>
                                                </div>
                                                <div class="col-12 col-sm-9 col-md-7 col-xl-9">
                                                    <p class="mb-0 text-muted">Description</p>
                                                    <p class="fs-6">
                                                        {{ $item->unsafe_description ?? '-' }}
                                                    </p>
                                                </div>
                                                @foreach(explode(',', $item->unsafe_images) as $index => $image)
                                                    @php $imageUrl = $image ? check_img_path($image) : asset('gambar/no-image.png'); @endphp
                                                    <div class="col-12 col-sm-6 col-xl-4">
                                                        <span class="btn p-0" data-bs-toggle="modal" data-bs-target="#assetImageModal{{ $index }}">
                                                            <img src="{{ $imageUrl }}" class="img-fluid img-rounded" alt="{{ $image }}">
                                                        </span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>Tidak ada asset</p>                            
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @foreach(explode(',', $item->unsafe_images) as $index => $image)
            <div class="modal fade" id="assetImageModal{{ $index }}" tabindex="-1" role="dialog" aria-labelledby="assetImageModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content">
                        <div class="modal-body">
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
        active_menu("#menu-report", "#sub-list-checkpoint-report")
    </script>
@endpush