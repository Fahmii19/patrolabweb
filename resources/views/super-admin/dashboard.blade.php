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
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"> <i data-feather="home"></i></a></li>
                    <li class="breadcrumb-item">Wilayah</li>
                    <li class="breadcrumb-item">{{ $title }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="col-xl-12 xl-100 chart_data_left box-col-12">
        <div class="card">
            <div class="card-body p-0">
                <div class="row m-0 chart-main">
                    <div class="col-xl-3 col-md-6 col-sm-6 p-0 box-col-6">
                        <div class="media align-items-center">
                            <div class="hospital-small-chart">
                                <div class="small-bar">
                                    <div class="small-chart flot-chart-container">
                                        <div class="chartist-tooltip" style="top: -31.8px; left: 32px;"><span class="chartist-tooltip-value">200</span></div>
                                        <svg xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%" height="100%" class="ct-chart-bar" style="width: 100%; height: 100%;">
                                            <g class="ct-grids"></g>
                                            <g>
                                                <g class="ct-series ct-series-a">
                                                    <line x1="13.571428571428571" x2="13.571428571428571" y1="69" y2="58.2" class="ct-bar" ct:value="400" style="stroke-width: 3px"></line>
                                                    <line x1="20.714285714285715" x2="20.714285714285715" y1="69" y2="44.7" class="ct-bar" ct:value="900" style="stroke-width: 3px"></line>
                                                    <line x1="27.857142857142858" x2="27.857142857142858" y1="69" y2="47.4" class="ct-bar" ct:value="800" style="stroke-width: 3px"></line>
                                                    <line x1="35" x2="35" y1="69" y2="42" class="ct-bar" ct:value="1000" style="stroke-width: 3px"></line>
                                                    <line x1="42.14285714285714" x2="42.14285714285714" y1="69" y2="50.1" class="ct-bar" ct:value="700" style="stroke-width: 3px"></line>
                                                    <line x1="49.285714285714285" x2="49.285714285714285" y1="69" y2="36.6" class="ct-bar" ct:value="1200" style="stroke-width: 3px"></line>
                                                    <line x1="56.42857142857143" x2="56.42857142857143" y1="69" y2="60.9" class="ct-bar" ct:value="300" style="stroke-width: 3px"></line>
                                                </g>
                                                <g class="ct-series ct-series-b">
                                                    <line x1="13.571428571428571" x2="13.571428571428571" y1="58.2" y2="31.200000000000003" class="ct-bar" ct:value="1000" style="stroke-width: 3px"></line>
                                                    <line x1="20.714285714285715" x2="20.714285714285715" y1="44.7" y2="31.200000000000003" class="ct-bar" ct:value="500" style="stroke-width: 3px"></line>
                                                    <line x1="27.857142857142858" x2="27.857142857142858" y1="47.4" y2="31.199999999999996" class="ct-bar" ct:value="600" style="stroke-width: 3px"></line>
                                                    <line x1="35" x2="35" y1="42" y2="31.200000000000003" class="ct-bar" ct:value="400" style="stroke-width: 3px"></line>
                                                    <line x1="42.14285714285714" x2="42.14285714285714" y1="50.1" y2="31.200000000000003" class="ct-bar" ct:value="700" style="stroke-width: 3px"></line>
                                                    <line x1="49.285714285714285" x2="49.285714285714285" y1="36.6" y2="31.200000000000003" class="ct-bar" ct:value="200" style="stroke-width: 3px"></line>
                                                    <line x1="56.42857142857143" x2="56.42857142857143" y1="60.9" y2="31.199999999999996" class="ct-bar" ct:value="1100" style="stroke-width: 3px"></line>
                                                </g>
                                            </g>
                                            <g class="ct-labels"></g>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="media-body">
                                <div class="right-chart-content">
                                    <h4>100</h4><b>Total Guard </b>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-sm-6 p-0 box-col-6">
                        <div class="media align-items-center">
                            <div class="hospital-small-chart">
                                <div class="small-bar">
                                    <div class="small-chart1 flot-chart-container">
                                        <div class="chartist-tooltip"></div><svg xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%" height="100%" class="ct-chart-bar" style="width: 100%; height: 100%;">
                                            <g class="ct-grids"></g>
                                            <g>
                                                <g class="ct-series ct-series-a">
                                                    <line x1="13.571428571428571" x2="13.571428571428571" y1="69" y2="58.2" class="ct-bar" ct:value="400" style="stroke-width: 3px"></line>
                                                    <line x1="20.714285714285715" x2="20.714285714285715" y1="69" y2="52.8" class="ct-bar" ct:value="600" style="stroke-width: 3px"></line>
                                                    <line x1="27.857142857142858" x2="27.857142857142858" y1="69" y2="44.7" class="ct-bar" ct:value="900" style="stroke-width: 3px"></line>
                                                    <line x1="35" x2="35" y1="69" y2="47.4" class="ct-bar" ct:value="800" style="stroke-width: 3px"></line>
                                                    <line x1="42.14285714285714" x2="42.14285714285714" y1="69" y2="42" class="ct-bar" ct:value="1000" style="stroke-width: 3px"></line>
                                                    <line x1="49.285714285714285" x2="49.285714285714285" y1="69" y2="36.6" class="ct-bar" ct:value="1200" style="stroke-width: 3px"></line>
                                                    <line x1="56.42857142857143" x2="56.42857142857143" y1="69" y2="55.5" class="ct-bar" ct:value="500" style="stroke-width: 3px"></line>
                                                </g>
                                                <g class="ct-series ct-series-b">
                                                    <line x1="13.571428571428571" x2="13.571428571428571" y1="58.2" y2="31.200000000000003" class="ct-bar" ct:value="1000" style="stroke-width: 3px"></line>
                                                    <line x1="20.714285714285715" x2="20.714285714285715" y1="52.8" y2="31.199999999999996" class="ct-bar" ct:value="800" style="stroke-width: 3px"></line>
                                                    <line x1="27.857142857142858" x2="27.857142857142858" y1="44.7" y2="31.200000000000003" class="ct-bar" ct:value="500" style="stroke-width: 3px"></line>
                                                    <line x1="35" x2="35" y1="47.4" y2="31.199999999999996" class="ct-bar" ct:value="600" style="stroke-width: 3px"></line>
                                                    <line x1="42.14285714285714" x2="42.14285714285714" y1="42" y2="31.200000000000003" class="ct-bar" ct:value="400" style="stroke-width: 3px"></line>
                                                    <line x1="49.285714285714285" x2="49.285714285714285" y1="36.6" y2="31.200000000000003" class="ct-bar" ct:value="200" style="stroke-width: 3px"></line>
                                                    <line x1="56.42857142857143" x2="56.42857142857143" y1="55.5" y2="31.200000000000003" class="ct-bar" ct:value="900" style="stroke-width: 3px"></line>
                                                </g>
                                            </g>
                                            <g class="ct-labels"></g>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="media-body">
                                <div class="right-chart-content">
                                    <h4>60</h4><b>Round</b>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-sm-6 p-0 box-col-6">
                        <div class="media align-items-center">
                            <div class="hospital-small-chart">
                                <div class="small-bar">
                                    <div class="small-chart2 flot-chart-container">
                                        <div class="chartist-tooltip" style="top: -16.8px; left: 10.2667px;"><span class="chartist-tooltip-value">800</span></div><svg xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%" height="100%" class="ct-chart-bar" style="width: 100%; height: 100%;">
                                            <g class="ct-grids"></g>
                                            <g>
                                                <g class="ct-series ct-series-a">
                                                    <line x1="13.571428571428571" x2="13.571428571428571" y1="69" y2="39.3" class="ct-bar" ct:value="1100" style="stroke-width: 3px"></line>
                                                    <line x1="20.714285714285715" x2="20.714285714285715" y1="69" y2="44.7" class="ct-bar" ct:value="900" style="stroke-width: 3px"></line>
                                                    <line x1="27.857142857142858" x2="27.857142857142858" y1="69" y2="52.8" class="ct-bar" ct:value="600" style="stroke-width: 3px"></line>
                                                    <line x1="35" x2="35" y1="69" y2="42" class="ct-bar" ct:value="1000" style="stroke-width: 3px"></line>
                                                    <line x1="42.14285714285714" x2="42.14285714285714" y1="69" y2="50.1" class="ct-bar" ct:value="700" style="stroke-width: 3px"></line>
                                                    <line x1="49.285714285714285" x2="49.285714285714285" y1="69" y2="36.6" class="ct-bar" ct:value="1200" style="stroke-width: 3px"></line>
                                                    <line x1="56.42857142857143" x2="56.42857142857143" y1="69" y2="60.9" class="ct-bar" ct:value="300" style="stroke-width: 3px"></line>
                                                </g>
                                                <g class="ct-series ct-series-b">
                                                    <line x1="13.571428571428571" x2="13.571428571428571" y1="39.3" y2="31.199999999999996" class="ct-bar" ct:value="300" style="stroke-width: 3px"></line>
                                                    <line x1="20.714285714285715" x2="20.714285714285715" y1="44.7" y2="31.200000000000003" class="ct-bar" ct:value="500" style="stroke-width: 3px"></line>
                                                    <line x1="27.857142857142858" x2="27.857142857142858" y1="52.8" y2="31.199999999999996" class="ct-bar" ct:value="800" style="stroke-width: 3px"></line>
                                                    <line x1="35" x2="35" y1="42" y2="31.200000000000003" class="ct-bar" ct:value="400" style="stroke-width: 3px"></line>
                                                    <line x1="42.14285714285714" x2="42.14285714285714" y1="50.1" y2="31.200000000000003" class="ct-bar" ct:value="700" style="stroke-width: 3px"></line>
                                                    <line x1="49.285714285714285" x2="49.285714285714285" y1="36.6" y2="31.200000000000003" class="ct-bar" ct:value="200" style="stroke-width: 3px"></line>
                                                    <line x1="56.42857142857143" x2="56.42857142857143" y1="60.9" y2="31.199999999999996" class="ct-bar" ct:value="1100" style="stroke-width: 3px"></line>
                                                </g>
                                            </g>
                                            <g class="ct-labels"></g>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="media-body">
                                <div class="right-chart-content">
                                    <h4>100</h4><b>Check Point</b>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-sm-6 p-0 box-col-6">
                        <div class="media border-none align-items-center">
                            <div class="hospital-small-chart">
                                <div class="small-bar">
                                    <div class="small-chart3 flot-chart-container">
                                        <div class="chartist-tooltip"></div><svg xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%" height="100%" class="ct-chart-bar" style="width: 100%; height: 100%;">
                                            <g class="ct-grids"></g>
                                            <g>
                                                <g class="ct-series ct-series-a">
                                                    <line x1="13.571428571428571" x2="13.571428571428571" y1="69" y2="58.2" class="ct-bar" ct:value="400" style="stroke-width: 3px"></line>
                                                    <line x1="20.714285714285715" x2="20.714285714285715" y1="69" y2="52.8" class="ct-bar" ct:value="600" style="stroke-width: 3px"></line>
                                                    <line x1="27.857142857142858" x2="27.857142857142858" y1="69" y2="47.4" class="ct-bar" ct:value="800" style="stroke-width: 3px"></line>
                                                    <line x1="35" x2="35" y1="69" y2="42" class="ct-bar" ct:value="1000" style="stroke-width: 3px"></line>
                                                    <line x1="42.14285714285714" x2="42.14285714285714" y1="69" y2="50.1" class="ct-bar" ct:value="700" style="stroke-width: 3px"></line>
                                                    <line x1="49.285714285714285" x2="49.285714285714285" y1="69" y2="39.3" class="ct-bar" ct:value="1100" style="stroke-width: 3px"></line>
                                                    <line x1="56.42857142857143" x2="56.42857142857143" y1="69" y2="60.9" class="ct-bar" ct:value="300" style="stroke-width: 3px"></line>
                                                </g>
                                                <g class="ct-series ct-series-b">
                                                    <line x1="13.571428571428571" x2="13.571428571428571" y1="58.2" y2="31.200000000000003" class="ct-bar" ct:value="1000" style="stroke-width: 3px"></line>
                                                    <line x1="20.714285714285715" x2="20.714285714285715" y1="52.8" y2="39.3" class="ct-bar" ct:value="500" style="stroke-width: 3px"></line>
                                                    <line x1="27.857142857142858" x2="27.857142857142858" y1="47.4" y2="31.199999999999996" class="ct-bar" ct:value="600" style="stroke-width: 3px"></line>
                                                    <line x1="35" x2="35" y1="42" y2="33.9" class="ct-bar" ct:value="300" style="stroke-width: 3px"></line>
                                                    <line x1="42.14285714285714" x2="42.14285714285714" y1="50.1" y2="31.200000000000003" class="ct-bar" ct:value="700" style="stroke-width: 3px"></line>
                                                    <line x1="49.285714285714285" x2="49.285714285714285" y1="39.3" y2="33.9" class="ct-bar" ct:value="200" style="stroke-width: 3px"></line>
                                                    <line x1="56.42857142857143" x2="56.42857142857143" y1="60.9" y2="31.199999999999996" class="ct-bar" ct:value="1100" style="stroke-width: 3px"></line>
                                                </g>
                                            </g>
                                            <g class="ct-labels"></g>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="media-body">
                                <div class="right-chart-content">
                                    <h4>101</h4><b>Montly Missed</b>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table id="#mytable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Round Name</th>
                        <th>Check Point</th>
                        <th>Scanned at</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<div id="actionbase" class="d-none">
    <div class="d-flex">
        <a class="btn btn-warning me-2">Edit</a>
        <form method="post">
            @csrf
            @method('delete')
            <button onclick="hapus_data(event)" class="btn btn-danger me-2" type="button">Hapus</button>
        </form>
    </div>
</div>
<!-- Container-fluid Ends-->
@push('js')
<script>
    $('#mytable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('wilayah.datatable') }}",
        columns: [{
                data: 'DT_RowIndex',
                name: 'No'
            },
            {
                data: 'kode',
                name: 'Kode Wilayah'
            },
            {
                data: 'nama',
                name: 'Nama Wilayah'
            },
            {
                name: "Action",
                render: function(data, type, row) {
                    let html = $('#actionbase').clone()
                    html = html.find('.d-flex')
                    html.find('a').attr('href', row.action.editurl)
                    let form = html.find('form').attr('action', row.action.deleteurl)
                        .attr('id', 'delete_form' + row.id)
                    form.find('button').attr('form-id', '#delete_form' + row.id)
                    return html.html()
                }
            }
        ]
    });
    menu_active("#menu_dashboard")
</script>
<div class="d-flex">
    <a class="btn btn-warning me-2">Edit</a>
    <button class="btn btn-danger me-2">Hapus</button>
</div>
@endpush

@endsection