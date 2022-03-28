<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class SchoolAdmin
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
        if(config('app.env') == 'local'){
            $user = User::whereUserType('school_admin')->first();
            if(auth('superadmin')->check()){
                auth('superadmin')->logout();
            }
            auth('schooladmin')->login($user);

            return $next($request);
        }
       
        if(auth('schooladmin')->check() && auth('schooladmin')->user()->isSchoolAdmin()){
            return $next($request);
        }

        return redirect()->route('schoollogin');
    }
}