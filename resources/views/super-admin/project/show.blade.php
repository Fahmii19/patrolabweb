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
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"> <i data-feather="home"></i></a>
                    </li>
                    <li class="breadcrumb-item">Project</li>
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
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h3>Nama Project : {{ $project_model->name }}</h3>
                        <p><strong>Region: </strong>{{ $project_model->data_wilayah->nama ?? 'N/A' }}</p>
                        <p><strong>Branch: </strong>{{ $project_model->data_branch->name ?? 'N/A' }}</p>
                        <p><strong>Address: </strong>{{ $project_model->address }}</p>
                        <p><strong>Created At: </strong>{{ $project_model->created_at->format('m/d/Y H:i:s') }}</p>
                        <p><strong>Status: </strong>{{ $project_model->status }}</p>
                        <!-- Add more fields as necessary -->

                        <a href="{{ route('project-model.index') }}" class="btn btn-primary">Back to List</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@push('js')
<script>
    active_menu("#data_master", "#project")

</script>


@endpush
@endsection
