@extends('layouts.app')

@section('content')
    <div class="row auth-page-container">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <h3 style="margin: 10px 0;">Buat Akun Baru</h3>
                    <p class="text-muted small">Bergabunglah dengan komunitas perpustakaan kami</p>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <div class="col-md-10 col-md-offset-1">
                                <label for="name" class="control-label">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input id="name" type="text" class="form-control" name="name"
                                        value="{{ old('name') }}" placeholder="Contoh: Budi Santoso" required autofocus>
                                </div>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-md-10 col-md-offset-1">
                                <label for="email" class="control-label">Alamat E-Mail</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                    <input id="email" type="email" class="form-control" name="email"
                                        value="{{ old('email') }}" placeholder="user@example.com" required>
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
                                        placeholder="Minimal 6 karakter" required>
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
                                <label for="password-confirm" class="control-label">Konfirmasi Kata Sandi</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-shield"></i></span>
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" placeholder="Ulangi kata sandi" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-1">
                            {!! NoCaptcha::display() !!}
                            </div>
                        </div>

                        <div class="form-group" style="margin-top: 30px;">
                            <div class="col-md-10 col-md-offset-1">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fa fa-user-plus"></i> Daftar Sekarang
                                </button>
                            </div>
                        </div>

                        <div class="text-center" style="margin-top: 20px;">
                            <p class="text-muted small">Sudah punya akun? <a href="{{ url('/login') }}">Login di sini</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
