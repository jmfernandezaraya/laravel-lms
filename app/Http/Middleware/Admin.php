<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class Admin
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
        if (auth('schooladmin')->check()) {
            if (auth('schooladmin')->user()->user_type == 'school_admin') {
                return $next($request);
            } else {
                auth('schooladmin')->logout();
            }
        } else if (auth('superadmin')->check()) {
            if (auth('superadmin')->user()->user_type == 'super_admin') {
                return $next($request);
            } else {
                auth('superadmin')->logout();
            }
        }

        return redirect()->route('schoollogin');
    }
}