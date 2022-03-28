<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PaymentAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $session)
    {
        if (auth()->check()) {
            return $next($request);
        } else {
            $request->session()->put($session, $request->all());
            return redirect()->route('login');
        }
    }
}