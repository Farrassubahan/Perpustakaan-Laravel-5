<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected function redirectTo()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return '/admin/dashboard';
        }

        if ($user->hasRole('user')) {
            return '/user/home';
        }

        return '/';
    }

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => 'required|captcha'
        ]);
    }

    protected function authenticated(Request $request, $user)
    {
        $user->last_login_at = Carbon::now();
        $user->is_online = true;
        $user->save();
    }

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function logout(Request $request)
    {
        if (auth()->check()) {
            $user = auth()->user();
            $user->is_online = false;
            $user->save();
        }

        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/');
    }
}
