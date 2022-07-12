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
        if ($request->isMethod('post')) {
            if (\Session::has('course_details')) {
                \Session::put('course_details_old', \Session::get('course_details'));
            }
            \Session::put('course_details', $request->all());
        }
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}