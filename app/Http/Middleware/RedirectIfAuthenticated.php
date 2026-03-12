<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {

            $user = Auth::user();

            // mapping role ke halaman
            $redirectMap = [
                'admin' => '/admin/dashboard',
                'user' => '/user/home',
                'librarian' => '/librarian/dashboard',
                'editor' => '/editor/dashboard',
            ];

            foreach ($user->roles as $role) {
                if (isset($redirectMap[$role->name])) {
                    return redirect($redirectMap[$role->name]);
                }
            }

            // fallback jika role tidak ada di mapping
            return redirect('/');
        }

        return $next($request);
    }
}
