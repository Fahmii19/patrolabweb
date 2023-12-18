@extends('layouts.admin')
@section('content')
    @component('components.dashboard.headpage')
        @slot('title')
            {{ $title }}
        @endslot
        @slot('bread')
            <li class="breadcrumb-item">Master Data</li>
            <li class="breadcrumb-item">{{ $title }}</li>
        @endslot
    @endcomponent
<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-lg-end mb-3">
                <a class="btn btn-success" href="{{ route('shift.create') }}">Tambah Shift</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="my_table">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-nowrap" style="width:50px">No</th>
                            <th class="text-nowrap">Nama Shift</th>
                            <th class="text-nowrap">Mulai</th>
                            <th class="text-nowrap">Selesai</th>
                            <th class="text-nowrap" style="width: 100px">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($shift as $item)
                        <tr>
                            <td class="text-nowrap">{{ $loop->iteration }}</td>
                            <td class="text-nowrap">{{ $item->name }}</td>
                            <td class="text-nowrap">{{ $item->start_time }}</td>
                            <td class="text-nowrap">{{ $item->end_time }}</td>
                            <td class="text-nowrap">
                                <div class="d-flex">
                                    <a href="{{ route('shift.edit',$item->id) }}" class="btn btn-warning me-2 text-dark">Edit</a>
                                    <form action="{{ route('shift.destroy',$item->id) }}" method="post" id="delete_form{{ $item->id }}">
                                        @csrf
                                        @method('delete')
                                        <button type="button" class="btn btn-danger" onclick="hapus_data(event)" form-id="#delete_form{{ $item->id }}">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    active_menu("#data_master", "#shift")
</script>
@endpush

@endsection