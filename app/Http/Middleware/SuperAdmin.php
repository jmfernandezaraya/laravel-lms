<?php

namespace App\Http\Middleware;

use Closure;

use App\Models\User;
use Illuminate\Http\Request;

class SuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (config('app.env') == 'local') {
            $user = User::whereUserType('super_admin')->first();
            if (auth('schooladmin')->check()) {
                auth('schooladmin')->logout();
            }
            auth('superadmin')->login($user);
            return $next($request);
        }

        if (auth('superadmin')->check()) {
            if (auth('superadmin')->user()->user_type == 'super_admin') {
                return $next($request);
            } else {
                auth('superadmin')->logout();
            }
        }

        return redirect()->route('superlogin');
    }
}