@extends('layouts.app')

@section('content')
    <div class="row auth-page-container">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <h3 style="margin: 10px 0;">Selamat Datang Kembali</h3>
                    <p class="text-muted small">Silakan login untuk mengakses akun Anda</p>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-md-10 col-md-offset-1">
                                <label for="email" class="control-label">Alamat E-Mail</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                    <input id="email" type="email" class="form-control" name="email"
                                        value="{{ old('email') }}" placeholder="user@example.com" required autofocus>
                                </div>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="col-md-10 col-md-offset-1">
                                <label for="password" class="control-label">Kata Sandi</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input id="password" type="password" class="form-control" name="password"
                                        placeholder="********" required>
                                </div>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Ingat
                                        Saya
                                    </label>
                                    <a class="pull-right small" href="{{ url('/password/reset') }}"
                                        style="margin-top: 2px;">
                                        Lupa Kata Sandi?
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-1">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fa fa-sign-in"></i> Masuk Sekarang
                                </button>
                            </div>
                        </div>

                        <div class="text-center" style="margin-top: 20px;">
                            <p class="text-muted small">Belum punya akun? <a href="{{ url('/register') }}">Daftar di
                                    sini</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
