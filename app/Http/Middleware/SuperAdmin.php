<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
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
        if(config('app.env') == 'local') {
            $user = User::whereUserType('super_admin')->first();
            if(auth('schooladmin')->check()){
                auth('schooladmin')->logout();

            }
            auth('superadmin')->login($user);
            return $next($request);
        }

        if(auth('superadmin')->check() && auth('superadmin')->user()->isSuperAdmin()){
            return $next($request);
        }

        return redirect()->route('superlogin');
    }
}