<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EmailVerification
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
        if (auth()->check()) {
            if(auth()->user()->email_verified_at == null && auth()->user()->user_type == 'user') {
                $remember = auth()->user()->id;

                $click_here = __('Frontend.click_here_to_get_email');
                $url = route('send_once_again_email_verification', $remember);
                auth()->logout();
                return redirect()->route('login')->with('error_message_for_login',  __('Frontend.email_not_verified') . "<a href= $url>&nbsp;&nbsp; $click_here </a> ");
            }
        }

        return $next($request);
    }
}