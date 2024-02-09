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
            <div class="card-body">
                <div class="table-responsive">
                    <table id="mytable" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th style="max-width: 40px;">No</th>
                                <th>Guard</th>
                                <th>Pleton</th>
                                <th>Koordinat</th>
                                <th>Deskripsi</th>
                                <th>Kondisi</th>
                                <th>Gambar</th>
                                <th>Reported at</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection

@push('js')
<script>
    $('#mytable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('self-patrol.datatable') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'No' },
            { data: 'guard', name: 'Nama Guard' },
            { data: 'pleton', name: 'Nama Pleton' },
            { data: 'coordinat', name: 'Titik Koordinat Lokasi' },
            { data: 'description', name: 'Deskripsi Laporan' },
            { data: 'condition', name: 'Kondisi Lokasi' },
            { 
                data: 'image', 
                name: 'Foto Laporan',
                orderable: false,
                searchable: false, 
            },
            { data: 'reported_at', name: 'Tanggal dan Waktu Laporan' },
        ],
        rowCallback: function(row, data) {
            // Set the cursor style to pointer
            $(row).css('cursor', 'pointer');
            // Attach a click event handler to each row
            $(row).on('click', function() {
                // Handle the row click event
                location.href = `{{ route('self-patrol.show', ':id') }}`.replace(':id', data.id);
            });
        }
    });
    active_menu("#menu-report", "#sub-report-self-patrol")
</script>
@endpush