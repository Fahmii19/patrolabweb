<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Cuba admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Cuba admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="{{ URL::asset("/template/assets/images/favicon.png") }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ URL::asset("/template/assets/images/favicon.png") }}" type="image/x-icon">
    <title>{{ $title }}</title>
    <!-- Google font-->
    @include('partials.header')
</head>

<body>
    <!-- login page start-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-5"><img class="bg-img-cover bg-center" src="{{ URL::asset("/template/assets/images/login/3.jpg") }}" alt="looginpage"></div>
            <div class="col-xl-7 p-0">
                <div class="login-card">
                    <div>
                        <div><a class="logo text-center" href="{{ url("index.html") }}"><img class="img-fluid for-light" src="{{ URL::asset("/template/assets/images/logo/login.png") }}" alt="looginpage"><img class="img-fluid for-dark" src="{{ URL::asset("/template/assets/images/logo/logo_dark.png") }}" alt="looginpage"></a></div>
                        <div class="login-main">
                            <form class="theme-form" action="{{ route('login') }}" method="POST">
                                @csrf
                                <h4>SISTEM PATROL PT.ABB</h4>
                                <p>masukkan email dan password untuk login</p>
                                <div class="form-group">
                                    <label class="col-form-label">Email</label>
                                    <input class="form-control" type="email" name="email" required="" placeholder="test@adonara.com">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Password</label>
                                    <div class="form-input position-relative">
                                        <input class="form-control" type="password" id="password" name="password" required="" placeholder="*********">
                                        <div class="show-hide" onclick="togle_password('#password')"><span class="show"> </span></div>
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <div class="checkbox p-0">
                                        <input id="checkbox1" name="remember" type="checkbox">
                                        <label class="text-muted" for="checkbox1">Remember password</label>
                                    </div>
                                    <button class="btn btn-primary btn-block w-100" type="submit">Masuk</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- latest jquery-->
        <!-- latest jquery-->
        <script src="{{ URL::asset("/template/assets/js/jquery-3.5.1.min.js") }}"></script>
        <!-- Bootstrap js-->
        <script src="{{ URL::asset("/template/assets/js/bootstrap/bootstrap.bundle.min.js") }}"></script>
        <!-- feather icon js-->
        <script src="{{ URL::asset("/template/assets/js/icons/feather-icon/feather.min.js") }}"></script>
        <script src="{{ URL::asset("/template/assets/js/icons/feather-icon/feather-icon.js") }}"></script>
        <!-- scrollbar js-->
        <!-- Sidebar jquery-->
        <script src="{{ URL::asset("/template/assets/js/config.js") }}"></script>
        <!-- Plugins JS start-->
        <!-- Plugins JS Ends-->
        <!-- Theme js-->
        <script src="{{ URL::asset("/template/assets/js/script.js") }}"></script>

        <script>
            function togle_password(id) {
                let input = $(id)
                if (input.attr('type') == 'password') {
                    input.attr('type', 'text')
                } else {
                    input.attr('type', 'password')
                }

            }
        </script>
    </div>
</body>

</html>