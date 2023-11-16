<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ URL::asset('/template/assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ URL::asset('/template/assets/images/favicon.png') }}" type="image/x-icon">
    <title>Patroli ABB - {{ $title }}</title>
    @include('partials.header')
</head>

<body onload="startTime()">
    <div class="loader-wrapper">
        <div class="loader-index"><span></span></div>
        <svg>
            <defs></defs>
            <filter id="goo">
                <fegaussianblur in="SourceGraphic" stddeviation="11" result="blur"></fegaussianblur>
                <fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo">
                </fecolormatrix>
            </filter>
        </svg>
    </div>
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <!-- Page Header Start-->
        <div class="page-header">
            <div class="header-wrapper row m-0">
                <form class="form-inline search-full col" action="#" method="get">
                    <div class="form-group w-100">
                        <div class="Typeahead Typeahead--twitterUsers">
                            <div class="u-posRelative">
                                <input class="demo-input Typeahead-input form-control-plaintext w-100" type="text" placeholder="Search Cuba .." name="q" title="" autofocus>
                                <div class="spinner-border Typeahead-spinner" role="status"><span class="sr-only">Loading...</span></div><i class="close-search" data-feather="x"></i>
                            </div>
                            <div class="Typeahead-menu"></div>
                        </div>
                    </div>
                </form>
                <div class="header-logo-wrapper col-auto p-0">
                    <div class="logo-wrapper"><a href="{{ url('index.html') }}"><img class="img-fluid" src="{{ URL::asset('/template/assets/images/logo/logo.png') }}" alt=""></a>
                    </div>
                    <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="align-center"></i></div>
                </div>
                <div class="left-header col horizontal-wrapper ps-0">
                    <ul class="horizontal-menu">

                    </ul>
                </div>
                <div class="nav-right col-8 pull-right right-header p-0">
                    <ul class="nav-menus">
                        <li class="language-nav">
                            <div class="translate_wrapper">
                                <div class="current_lang">
                                    <div class="lang"><i class="flag-icon flag-icon-id"></i><span class="lang-txt">ID </span></div>
                                </div>
                                <div class="more_lang">
                                    <div class="lang selected" data-value="en"><i class="flag-icon flag-icon-us"></i><span class="lang-txt">English<span>
                                                (US)</span></span></div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="mode"><i class="fa fa-moon-o"></i></div>
                        </li>
                        <li class="maximize"><a class="text-dark" href="{{ url('#!') }}" onclick="javascript:toggleFullScreen()"><i data-feather="maximize"></i></a></li>
                        <li class="profile-nav onhover-dropdown p-0 me-0">
                            <div class="media profile-media"><img class="b-r-10" src="{{ URL::asset('/template/assets/images/dashboard/profile.jpg') }}" alt="">
                                <div class="media-body"><span>{{ auth()->user()->name }}</span>
                                    <p class="mb-0 font-roboto">{{ auth()->user()->getRoleNames()[0] }} <i class="middle fa fa-angle-down"></i></p>
                                </div>
                            </div>
                            <ul class="profile-dropdown onhover-show-div">
                                <li><a href="{{ url('#') }}"><i data-feather="user"></i><span>Account
                                        </span></a></li>
                                <li><a href="{{ url('#') }}"><i data-feather="settings"></i><span>Settings</span></a></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" onclick="logout('#form_logout')" id="form_logout">
                                        @csrf
                                        <i data-feather="log-in"> </i><span>Logout</span>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <script class="result-template" type="text/x-handlebars-template">
                    <div class="ProfileCard u-cf">                        
            <div class="ProfileCard-avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay m-0"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg></div>
            <div class="ProfileCard-details">
            <div class="ProfileCard-realName">test</div>
            </div>
            </div>
          </script>
                <script class="empty-template" type="text/x-handlebars-template"><div class="EmptyMessage">Your search turned up 0 results. This most likely means the backend is down, yikes!</div></script>
            </div>
        </div>
        <!-- Page Header Ends                              -->
        <!-- Page Body Start-->
        <div class="page-body-wrapper">
            <!-- Page Sidebar Start-->
            <div class="sidebar-wrapper">
                <div>
                    <div class="logo-wrapper"><a href="{{ url('index.html') }}"><img class="img-fluid for-light" src="{{ URL::asset('/template/assets/images/logo/logo.png') }}" alt=""><img class="img-fluid for-dark" src="{{ URL::asset('/template/assets/images/logo/logo_dark.png') }}" alt=""></a>
                        <div class="back-btn"><i class="fa fa-angle-left"></i></div>
                        <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
                    </div>
                    <div class="logo-icon-wrapper"><a href="{{ url('index.html') }}"><img class="img-fluid" src="{{ URL::asset('/template/assets/images/logo/logo-icon.png') }}" alt=""></a></div>
                    <nav class="sidebar-main">
                        <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
                        <div id="sidebar-menu">
                            <ul class="sidebar-links" id="simple-bar">
                                <li class="back-btn"><a href="{{ url(' index.html') }}"><img class="img-fluid" src="{{ URL::asset(' /template/assets/images/logo/logo-icon.png') }}" alt=""></a>
                                    <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                                </li>
                                <li class="sidebar-main-title">
                                    <div>
                                        <h6>Patrol ABB</h6>
                                    </div>
                                </li>
                                <li><a class="{{ isset($page) && $page == 'dashboard' ? 'active-menu' : '' }} d-block" href="{{ route('admin.dashboard') }}" data-original-title="" title="" id="menu_dashboard"> <i data-feather="bar-chart-2"></i><span>Dashboard </span></a></li>
                                </li>
                                <li class="sidebar-list" id="data_master">
                                    <a class="sidebar-link sidebar-title" href="#"><i class="menu-icon" data-feather="home"></i><span>Master Data</span></a>
                                    <ul class="sidebar-submenu">
                                        <li><a href="{{ route('user.index') }}" id="user">User</a></li>
                                        <li><a href="{{ route('aset.index') }}" id="asset">Asset</a></li>
                                        <li><a href="{{ route('area.index') }}" id="area">Areas</a></li>
                                        <li><a href="{{ route('project-model.index') }}" id="project">Projects</a></li>
                                        <li><a href="{{ route('wilayah.index') }}" id="wilayah">Region</a></li>
                                        <li><a href="{{ route('hak-akses.index') }}" id="hak_akses">Permission</a></li>
                                        <li><a href="{{ route('shift.index') }}" id="shift">Shift</a></li>
                                    </ul>
                                </li>
                                <li class="sidebar-list" id="menu-patrol"><a class="sidebar-link sidebar-title" href="#"><i data-feather="shield"></i><span>Patrol</span></a>
                                    <ul class="sidebar-submenu">
                                        <li><a href="" id="sub-schedule">Schedule</a></li>
                                        <li><a href="{{ route('atensi.index') }}" id="sub-notice">Notice Boards</a></li>
                                    </ul>
                                </li>
                                <li class="sidebar-list" id="menu_aset"><a class="sidebar-link sidebar-title" href="#"><i data-feather="truck"></i><span>Asset Management</span></a>
                                    <ul class="sidebar-submenu">
                                        <li><a href="{{ route('aset-patroli.index') }}" id="patroli_asset">Patroli Asset</a></li>
                                        <li><a href="{{ route('aset-location.index') }}" id="location_asset">Location Asset</a></li>
                                    </ul>
                                </li>
                                <li class="sidebar-list" id="menu-gate"><a class="sidebar-link sidebar-title" href="#"><i data-feather="command"></i><span>Gate Access</span></a>
                                    <ul class="sidebar-submenu">
                                        <li><a href="{{ route('incoming-vehicle.index') }}" id="sub_incoming_vehichle">Incoming Vehicle</a></li>
                                        <li><a href="{{ route('outcoming-vehicle.index') }}" id="sub-outcoming-vehichle">Outcoming Vehicle</a></li>
                                    </ul>
                                </li>
                                <li class="sidebar-list" id="menu-guard"><a class="sidebar-link sidebar-title" href="#"><i data-feather="layers"></i><span>Guard Management</span></a>
                                    <ul class="sidebar-submenu">
                                        <li><a href="{{ route('guard.index') }}" id="sub-list-guard">Guard List</a></li>
                                        <li><a href="{{ route('pleton.index') }}">Pleton List</a></li>
                                    </ul>
                                </li>
                                <li class="sidebar-list" id="menu-checkpoint"><a class="sidebar-link sidebar-title" href="#"><i data-feather="map-pin"></i><span>Check Point</span></a>
                                    <ul class="sidebar-submenu">
                                        <li><a href="{{ route('check-point.create') }}" id="sub-add-checkpoint">Add Checkpoint</a></li>
                                        <li><a href="{{ route('check-point.index') }}" id="sub-list-checkpoint">Checkpoint List</a></li>
                                    </ul>
                                </li>
                                <li class="sidebar-list" id="menu-checkpointaset"><a class="sidebar-link sidebar-title" href="#"><i data-feather="check-square"></i><span>Client Asset</span></a>
                                    <ul class="sidebar-submenu">
                                        <li><a href="{{ route('checkpoint-aset.create') }}" id="sub-checkpoint-aset">Add CheckAset</a></li>
                                        <li><a href="{{ route('checkpoint-aset.index') }}" id="sub-checkpoint-aset-list">Asset CheckPoint</a></li>
                                    </ul>
                                </li>
                                <li class="sidebar-list" id="menu-round"><a class="sidebar-link sidebar-title" href="#"><i data-feather="arrow-right-circle"></i><span>Round</span></a>
                                    <ul class="sidebar-submenu">
                                        <li><a href="{{ route('round.create') }}" id="sub-round-create">Add Route</a></li>
                                        <li><a href="{{ route('round.index') }}" id="sub-round-list">Route List</a></li>
                                    </ul>
                                </li>
                                <li class="sidebar-list active" id="menu-ai"><a class="sidebar-link sidebar-title active" href="#"><i data-feather="cpu"></i><span>AI CAPTURE</span></a>
                                    <ul class="sidebar-submenu">
                                        <li><a href="">Register</a></li>
                                        <li><a href="{{ route('ai-master.index') }}" id="sub-data-ai">Master Data</a></li>
                                        <li><a href="">Register DPO</a></li>
                                    </ul>
                                </li>
                                <li class="sidebar-list" id="menu-report"><a class="sidebar-link sidebar-title" href="#"><i data-feather="flag"></i><span>Reporting</span></a>
                                    <ul class="sidebar-submenu">
                                        <li><a href="{{ route('checkpoint-report.index') }}">Checkpoint Report</a></li>
                                        <li><a href="">Shift Patrol Report</a></li>
                                        <li><a href="{{ route('self-patrol.index') }}" id="sub-report-self-patrol">Self Patrol</a></li>
                                        <li><a href="">Asset Report</a></li>
                                    </ul>
                                </li>
                                <li><a class="{{ isset($page) && $page == 'audit_log' ? 'active-menu' : '' }} d-block" href="{{ route('audit-log.index') }}" id="menu-audit" data-original-title="" title=""> <i data-feather="activity"></i><span>Audit Log </span></a></li>
                            </ul>
                        </div>
                        <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
                    </nav>
                </div>
            </div>
            <!-- Page Sidebar Ends-->
            <div class="page-body">
                <!-- Container-fluid starts-->
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- Container-fluid Ends-->
            </div>
            <!-- footer start-->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 footer-copyright text-center">
                            <p class="mb-0">Copyright 2023 © {{ env('APP_NAME') }} </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    @include('partials.footer')
</body>

</html>