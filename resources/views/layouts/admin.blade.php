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
                                <input class="demo-input Typeahead-input form-control-plaintext w-100" type="text"
                                    placeholder="Search Cuba .." name="q" title="" autofocus>
                                <div class="spinner-border Typeahead-spinner" role="status"><span
                                        class="sr-only">Loading...</span></div><i class="close-search"
                                    data-feather="x"></i>
                            </div>
                            <div class="Typeahead-menu"></div>
                        </div>
                    </div>
                </form>
                <div class="header-logo-wrapper col-auto p-0">
                    <div class="logo-wrapper">
                        <a href="{{ url('/') }}">
                            <img class="img-fluid" src="{{ URL::asset('/template/assets/images/logo/logo.png') }}" alt="">
                        </a>
                    </div>
                    
                    <div class="toggle-sidebar">
                        <i class="status_toggle middle sidebar-toggle" data-feather="align-center"></i>
                    </div>
                </div>
                <div class="left-header col horizontal-wrapper ps-0">
                    <ul class="horizontal-menu">

                    </ul>
                </div>
                <div class="nav-right col-8 pull-right right-header p-0">
                    <ul class="nav-menus me-0">
                        <li class="language-nav">
                            <div class="translate_wrapper">
                                <div class="current_lang">
                                    <div class="lang"><i class="flag-icon flag-icon-id"></i><span class="lang-txt">ID
                                        </span></div>
                                </div>
                                <div class="more_lang">
                                    <div class="lang selected" data-value="en"><i
                                            class="flag-icon flag-icon-us"></i><span class="lang-txt">English<span>
                                                (US)</span></span></div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="mode"><i class="fa fa-moon-o"></i></div>
                        </li>
                        <li class="maximize">
                            <a class="text-dark" href="{{ url('#!') }}" onclick="javascript:toggleFullScreen()">
                                <i data-feather="maximize"></i>
                            </a>
                        </li>
                        <li class="profile-nav onhover-dropdown p-0 me-0">
                            <div class="media profile-media">
                                <img class="b-r-10" src="{{ URL::asset('/template/assets/images/dashboard/profile.jpg') }}" alt="">
                                <div class="media-body"><span>{{ auth()->user()->name }}</span>
                                    <p class="mb-0 font-roboto">{{ auth()->user()->getRoleNames()[0] }} 
                                        <i class="middle fa fa-angle-down"></i>
                                    </p>
                                </div>
                            </div>
                            <ul class="profile-dropdown onhover-show-div">
                                <li><a href="{{ url('#') }}"><i data-feather="user"></i><span>Account
                                        </span></a></li>
                                <li><a href="{{ url('#') }}"><i
                                            data-feather="settings"></i><span>Settings</span></a></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST"
                                        onclick="logout('#form_logout')" id="form_logout">
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
                        <div class="ProfileCard-avatar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay m-0"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg>
                        </div>
                        <div class="ProfileCard-details">
                            <div class="ProfileCard-realName">test</div>
                        </div>
                    </div>
                </script>
                <script class="empty-template" type="text/x-handlebars-template">
                    <div class="EmptyMessage">Your search turned up 0 results. This most likely means the backend is down, yikes!</div>
                </script>
            </div>
        </div>
        <!-- Page Header Ends -->

        <!-- Page Body Start-->
        <div class="page-body-wrapper">
            @include('partials.sidebar')
            
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
