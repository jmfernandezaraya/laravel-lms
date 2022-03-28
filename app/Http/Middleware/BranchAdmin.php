<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class BranchAdmin
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
            $user = User::whereUserType('branch_admin')->first();

            auth('branch_admin')->login($user);
            return $next($request);
        } elseif(config('app.env') == 'production') {
            $user = User::whereUserType('branch_admin')->first();
            auth('branch_admin')->login($user);

            return $next($request);
        }
        if(auth('branch_admin')->check() && auth('branch_admin')->user()->isBranchAdmin()){
            return $next($request);
        }

        return redirect()->route('branchlogin');
    }
}