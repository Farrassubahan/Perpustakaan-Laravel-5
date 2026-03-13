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
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    @yield('styles')
</head>
{{-- {!! NoCaptcha::renderJs() !!} --}}


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
                                <li class="{{ Route::is('admin.dashboard') ? 'active' : '' }}">
                                    <a href="{{ route('admin.dashboard') }}">
                                        <i class="fa fa-th-large"></i> Dashboard
                                    </a>
                                </li>
                                <li class="{{ Route::is('admin.books.*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.books.index') }}">
                                        <i class="fa fa-book"></i> Kelola Buku
                                    </a>
                                </li>
                                <li class="{{ Route::is('admin.categories.*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.categories.index') }}">
                                        <i class="fa fa-tags"></i> Kategori
                                    </a>
                                </li>
                            @endrole


                            {{-- MENU USER --}}
                            @role('user')
                                <li class="{{ Route::is('user.home') ? 'active' : '' }}">
                                    <a href="{{ route('user.home') }}">
                                        <i class="fa fa-home"></i> Beranda
                                    </a>
                                </li>

                                <li class="{{ Route::is('user.books.myloans*') ? 'active' : '' }}">
                                    <a href="{{ route('user.books.myloans') }}">
                                        <i class="fa fa-bookmark"></i> Pinjaman Saya
                                    </a>
                                </li>
                            @endrole
                        @endif

                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        @if (Auth::guest())
                            <li class="{{ Request::is('login') ? 'active' : '' }}">
                                <a href="{{ url('/login') }}">Login</a>
                            </li>
                            <li class="{{ Request::is('register') ? 'active' : '' }}">
                                <a href="{{ url('/register') }}" class="btn btnnavbar-btn">Daftar</a>
                            </li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random&color=fff&size=32"
                                        class="img-circle" style="width:24px; margin-top:-5px; margin-right:5px;">
                                    {{ Auth::user()->name }} <span class="caret"></span>
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
        <div class="container pt-5" style="min-height: 80vh;">
            @yield('content')
        </div>

        <footer class="mt-5 mb-5">
            <div class="container text-center">
                <hr style="border-top: 1px solid var(--border-color);">
                <p class="text-muted">
                    &copy; {{ date('Y') }} {{ config('app.name', 'L Farpus') }} &bull; Sistem Manajemen
                    Perpustakaan
                </p>
                <p class="small text-muted">Modernizing the way you manage and discover books.</p>
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
