<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'L Farpus') }}</title>

    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">

    <!-- Bootstrap Core -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <!-- Custom Modern Style -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <link rel="stylesheet" href="{{ asset('css/dataTables.min.css') }}">

    @yield('styles')
</head>

<body>

    <div id="app">

        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#main-navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <i class="fa fa-book"></i> {{ config('app.name', 'L Farpus') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="main-navbar">
                    <ul class="nav navbar-nav">

                        @if (!Auth::guest())
                            {{-- MENU ADMIN --}}
                            @role('admin')
                                <li class="{{ Request::is('admin/dashboard') ? 'active' : '' }}">
                                    <a href="{{ route('admin.dashboard') }}">
                                        <i class="fa fa-dashboard"></i> Dashboard
                                    </a>
                                </li>
                                <li class="{{ Request::is('admin/books*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.books.index') }}">
                                        <i class="fa fa-book"></i> Kelola Buku
                                    </a>
                                </li>
                                <li class="{{ Request::is('admin/categories*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.categories.index') }}">
                                        <i class="fa fa-tags"></i> Kelola Buku
                                    </a>
                                </li>
                            @endrole


                            {{-- MENU USER --}}
                            @role('user')
                                <li class="{{ Request::is('user.home') ? 'active' : '' }}">
                                    <a href="{{ route('user.home') }}">
                                        <i class="fa fa-home"></i> Beranda
                                    </a>
                                </li>

                                <li>
                                    <a href="#">
                                        <i class="fa fa-book"></i> Buku
                                    </a>
                                </li>
                            @endrole
                        @endif

                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        @if (Auth::guest())
                            <li class="{{ Request::is('login') ? 'active' : '' }}">
                                <a href="{{ url('/login') }}">
                                    <i class="fa fa-sign-in"></i> Login
                                </a>
                            </li>
                            <li class="{{ Request::is('register') ? 'active' : '' }}">
                                <a href="{{ url('/register') }}">
                                    <i class="fa fa-user-plus"></i> Daftar
                                </a>
                            </li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-user-circle"></i> {{ Auth::user()->name }} <span
                                        class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ url('/logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fa fa-sign-out"></i> Logout
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
        <div class="container" style="margin-top:100px; min-height: 80vh;">
            @yield('content')
        </div>

        <footer class="footer">
            <div class="container text-center">
                <hr>
                <p class="text-muted">
                    &copy; {{ date('Y') }} {{ config('app.name', 'L Farpus') }} &mdash; Sistem Manajemen
                    Perpustakaan
                </p>
                <p class="small text-muted">Aplikasi Perpustakaan Modern dan Profesional</p>
            </div>
        </footer>

    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/datatables.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script> --}}

    @yield('scripts')

</body>

</html>
