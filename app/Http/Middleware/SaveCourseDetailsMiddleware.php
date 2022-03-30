<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SaveCourseDetailsMiddleware
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
        \Session::put('request', $request->all());
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
