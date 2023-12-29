@extends('layouts.admin')
@section('content')
    @component('components.dashboard.headpage')
        @slot('title')
            {{ $title }}
        @endslot
        @slot('bread')
            <li class="breadcrumb-item">Aduit Log</li>
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
                                <th class="text-nowrap" style="width:50px">No</th>
                                <th class="text-nowrap">Subject</th>
                                <th class="text-nowrap">Role Causer</th>
                                <th class="text-nowrap">Activity</th>
                                <th class="text-nowrap">Datetime</th>
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
        // Konfigurasi DataTables
        $('#mytable').addClass('w-100').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('audit-log.datatable') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'No',
                },
                {
                    data: 'subject',
                    name: 'Subject Name'
                },
                {
                    data: 'role',
                    name: 'Role Subject'
                },
                {
                    data: 'activity',
                    name: 'Activity'
                },
                {
                    data: 'datetime',
                    name: 'Datetime'
                }
            ]
        });

        active_menu("#menu-audit");
    </script>
@endpush