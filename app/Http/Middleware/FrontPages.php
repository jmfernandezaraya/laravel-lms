<?php

namespace App\Http\Middleware;

use Closure;

use App\Models\FrontPage;

use Illuminate\Http\Request;

class FrontPages
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
        $request_uri = $request->getRequestUri();
        if ($request_uri[strlen($request_uri) - 1] == '/') {
            $request_uri = substr($request_uri, 0, strlen($request_uri) - 1);
        }
        if ($request_uri && $request_uri[0] == '/') {
            $request_uri = substr($request_uri, 1);
        }

        if ($request_uri != '' && $request_uri != '/') {
            $front_pages = FrontPage::where('slug', '<>', '/')->where('route', false)->where('display', true)->get();
            foreach ($front_pages as $front_page) {
                if ($front_page->slug == $request_uri) {
                    $title = \Session::get('locale') == 'en' ? $front_page->title : $front_page->title_ar;
                    $content = \Session::get('locale') == 'en' ? $front_page->content : $front_page->content_ar;
                    return response()->view('frontend.page', compact('title', 'content'));
                }
            }
        }

        return $next($request);
    }
}