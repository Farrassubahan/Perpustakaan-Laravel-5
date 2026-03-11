<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Mobile Responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'L Farpus') }}</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <!-- Custom Style -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">

</head>

<body>

    <div id="app">

        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">

                <!-- Brand and toggle -->
                <div class="navbar-header">

                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#main-navbar">

                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>

                    </button>

                    <a class="navbar-brand" href="{{ url('/home') }}">
                        {{ config('app.name', 'L Farpus') }}
                    </a>

                </div>

                <!-- Navbar Menu -->
                <div class="collapse navbar-collapse" id="main-navbar">

                    <!-- LEFT MENU -->
                    <ul class="nav navbar-nav">

                        <li class="active">
                            <a href="{{ url('/') }}">
                                <span class="glyphicon glyphicon-home fa fa-home"></span>
                                Beranda
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <span class="glyphicon glyphicon-book fa fa-book"></span>
                                Buku
                            </a>
                        </li>

                    </ul>


                    <!-- RIGHT MENU -->
                    <ul class="nav navbar-nav navbar-right">

                        @if (Auth::guest())
                            <li>
                                <a href="{{ url('/login') }}">
                                    <span class="glyphicon glyphicon-log-in"></span>
                                    Login
                                </a>
                            </li>

                            <li>
                                <a href="{{ url('/register') }}">
                                    <span class="glyphicon glyphicon-user"></span>
                                    Daftar
                                </a>
                            </li>
                        @else
                            <li class="dropdown">

                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                                    <span class="glyphicon glyphicon-user"></span>
                                    {{ Auth::user()->name }}
                                    <span class="caret"></span>

                                </a>

                                <ul class="dropdown-menu">

                                    <li>
                                        <a href="{{ url('/logout') }}"
                                            onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">

                                            <span class="glyphicon glyphicon-log-out"></span>
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                            style="display:none">

                                            {{ csrf_field() }}

                                        </form>

                                    </li>

                                </ul>

                            </li>
                        @endif

                    </ul>

                </div>

            </div>
        </nav>

        <!-- CONTENT -->
        <div class="container" style="margin-top:80px">

            @yield('content')

        </div>

        <footer class="navbar navbar-inverse navbar-static-bottom">
            <div class="container text-center">
                <p class="navbar-text">
                    © {{ date('Y') }} {{ config('app.name', 'L Farpus') }} — Sistem Perpustakaan
                </p>
            </div>
        </footer>


    </div>


    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">\
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>

</body>

</html>
