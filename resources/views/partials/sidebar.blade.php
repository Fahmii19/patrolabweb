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
                    <li class="back-btn"><a href="{{ url(' index.html') }}"><img class="img-fluid" src="{{ URL::asset('/template/assets/images/logo/logo-icon.png') }}" alt=""></a>
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6>Patrol ABB</h6>
                        </div>
                    </li>

                    @role('super-admin')
                        <li class="mb-2">
                            <a class="{{ isset($page) && $page == 'dashboard' ? 'active-menu' : '' }} d-block" href="{{ route('admin.dashboard') }}" data-original-title="" title="" id="menu_dashboard"> <i data-feather="bar-chart-2"></i><span>Dashboard </span></a>
                        </li>
                        <li class="sidebar-list mb-2" id="data_master">
                            <a class="sidebar-link sidebar-title" href="#"><i class="menu-icon" data-feather="home"></i><span>Master Data</span></a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ route('user.index') }}" id="user">User</a></li>
                                <li><a href="{{ route('province.index') }}" id="province">Province</a></li>
                                <li><a href="{{ route('wilayah.index') }}" id="region">Region</a></li>
                                <li><a href="{{ route('branch.index') }}" id="branch">Branch</a></li>
                                <li><a href="{{ route('project.index') }}" id="project">Projects</a></li>
                                <li><a href="{{ route('area.index') }}" id="area">Areas</a></li>
                                <li><a href="{{ route('gate.index') }}" id="gate">Gate</a></li>
                                <li><a href="{{ route('aset.index') }}" id="asset">Asset</a></li>
                                <li><a href="{{ route('shift.index') }}" id="shift">Shift</a></li>
                            </ul>
                        </li>
                        <li class="sidebar-list mb-2" id="menu-patrol"><a class="sidebar-link sidebar-title" href="#"><i data-feather="shield"></i><span>Patrol</span></a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ route('schedule.index') }}" id="sub-schedule">Schedule</a></li>
                                <li><a href="{{ route('patrol-area.index') }}" id="sub-patrol-area">Patrol Area</a></li>
                                <li><a href="{{ route('notice-boards.index') }}" id="sub-notice">Notice Boards</a></li>
                            </ul>
                        </li>
                        <li class="sidebar-list mb-2" id="menu-guard"><a class="sidebar-link sidebar-title" href="#"><i data-feather="users"></i><span>Guard Management</span></a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ route('guard.index') }}" id="sub-list-guard">Guard List</a></li>
                                <li><a href="{{ route('pleton.index') }}" id="sub-list-pleton">Pleton List</a></li>
                                <li><a href="{{ route('pleton-patrol-area.index') }}" id="sub-pleton-patrol">Pleton Patrol</a></li>
                            </ul>
                        </li>
                        <li class="sidebar-list mb-2" id="menu-round"><a class="sidebar-link sidebar-title" href="#"><i data-feather="arrow-right-circle"></i><span>Round</span></a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ route('round.create') }}" id="sub-round-create">Add Route</a></li>
                                <li><a href="{{ route('round.index') }}" id="sub-round-list">Route List</a></li>
                                <li><a href="{{ route('round.detail') }}" id="sub-round-detail">Route Detail</a></li>
                            </ul>
                        </li>
                        <li class="sidebar-list mb-2" id="menu-checkpoint"><a class="sidebar-link sidebar-title" href="#"><i data-feather="map-pin"></i><span>Check Point</span></a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ route('check-point.create') }}" id="sub-add-checkpoint">Add Checkpoint</a></li>
                                <li><a href="{{ route('check-point.index') }}" id="sub-list-checkpoint">Checkpoint List</a></li>
                            </ul>
                        </li>
                        <li class="sidebar-list mb-2" id="menu-gate"><a class="sidebar-link sidebar-title" href="#"><i data-feather="truck"></i><span>Gate Access</span></a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ route('incoming-vehicle.index') }}" id="sub_incoming_vehichle">Incoming Vehicle</a></li>
                                <li><a href="{{ route('outcoming-vehicle.index') }}" id="sub-outcoming-vehichle">Outcoming Vehicle</a></li>
                            </ul>
                        </li>
                        <li class="sidebar-list mb-2" id="menu-aset"><a class="sidebar-link sidebar-title" href="#"><span><i data-feather="command"></i>Asset Management</span></a>
                            <ul class="sidebar-submenu">
                                {{-- <li><a href="{{ route('aset-patroli.index') }}" id="patroli_asset">Patroli Asset</a></li> --}}
                                <li><a href="{{ route('aset-location.index') }}" id="location_asset">Location Asset</a></li>
                                <li><a href="{{ route('aset-unsafe-option.index') }}" id="unsafe-option">Unsafe Option</a></li>
                            </ul>
                        </li>
                        <li class="sidebar-list mb-2" id="menu-checkpointaset-client"><a class="sidebar-link sidebar-title" href="#"><i data-feather="check-square"></i><span>Client Asset</span></a>
                            <ul class="sidebar-submenu">
                                {{-- <li><a href="{{ route('checkpoint-aset-client.create') }}" id="sub-checkpoint-aset">Add CheckAset</a></li> --}}
                                <li><a href="{{ route('checkpoint-aset-client.index') }}" id="sub-checkpoint-client-aset-list">Asset CheckPoint</a></li>
                                <li><a href="{{ route('asset-client-detail') }}" id="sub-checkpoint-client-aset-detail">Detail Checkpoint</a></li>
                            </ul>
                        </li>
                        <li class="sidebar-list mb-2" id="menu-checkpointaset-patrol"><a class="sidebar-link sidebar-title" href="#"><i data-feather="check-square"></i><span>Patrol Asset</span></a>
                            <ul class="sidebar-submenu">
                                {{-- <li><a href="{{ route('checkpoint-aset-client.create') }}" id="sub-checkpoint-aset">Add CheckAset</a></li> --}}
                                <li><a href="{{ route('checkpoint-aset-patrol.index') }}" id="sub-checkpoint-patrol-aset-list">Asset CheckPoint</a></li>
                                <li><a href="{{ route('asset-patrol-detail') }}" id="sub-checkpoint-patrol-aset-detail">Detail Checkpoint</a></li>
                            </ul>
                        </li>
                        
                        <li class="sidebar-list mb-2 active" id="menu-ai"><a class="sidebar-link sidebar-title active" href="#"><i data-feather="cpu"></i><span>AI CAPTURE</span></a>
                            <ul class="sidebar-submenu">
                                <li><a href="">Register</a></li>
                                <li><a href="{{ route('ai-master.index') }}" id="sub-data-ai">Master Data</a></li>
                                <li><a href="">Register DPO</a></li>
                            </ul>
                        </li>
                        <li class="sidebar-list mb-2" id="menu-report"><a class="sidebar-link sidebar-title" href="#"><i data-feather="flag"></i><span>Reporting</span></a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ route('self-patrol.create') }}" id="sub-report-self-patrol">Self Patrol</a></li>
                                <li><a href="{{ route('checkpoint-report.index') }}" id="sub-list-checkpoint-report">Checkpoint Report</a></li>
                                <li><a href="{{ route('asset-report.index') }}" id="sub-list-asset-report">Asset Report</a></li>
                                <li><a href="">Shift Patrol Report</a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="{{ isset($page) && $page == 'audit_log' ? 'active-menu' : '' }} d-block" href="{{ route('audit-log.index') }}" id="menu-audit" data-original-title="" title=""> <i data-feather="activity"></i><span>Audit Log </span></a>
                        </li>
                    @endrole

                    @role('admin-area')
                        <li class="mb-2">
                            <a class="{{ isset($page) && $page == 'dashboard' ? 'active-menu' : '' }} d-block" href="{{ route('admin-area.dashboard') }}" data-original-title="" title="" id="menu_dashboard"> <i data-feather="bar-chart-2"></i><span>Dashboard </span></a>
                        </li>
                        <li class="sidebar-list mb-2" id="data_master">
                            <a class="sidebar-link sidebar-title" href="#"><i class="menu-icon" data-feather="home"></i><span>Master Data</span></a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ route('area.index') }}" id="area">Areas</a></li>
                                <li><a href="{{ route('branch.index') }}" id="branch">Branch</a></li>
                                <li><a href="{{ route('project.index') }}" id="project">Projects</a></li>
                            </ul>
                        </li>
                    @endrole

                    @role('user')
                        <li class="sidebar-list mb-2" id="menu-guard">
                            <a class="sidebar-link sidebar-title" href="#"><i data-feather="layers"></i><span>Guard Management</span></a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ route('guard.index') }}" id="sub-list-guard">Guard List</a></li>
                                <li><a href="{{ route('pleton.index') }}" id="sub-list-pleton">Pleton List</a></li>
                            </ul>
                        </li>
                    @endrole
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
