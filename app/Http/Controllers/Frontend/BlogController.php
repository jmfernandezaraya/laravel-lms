<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;

class BlogController extends Controller
{
    public function index(){
        $blogs = Blog::all();
        $data['language'] = (string)get_language();
        $blogrecents = Blog::latest()->take(4)->get();
        return view('frontend.blog.index',$data, compact('blogs','blogrecents'));
    }

    public function show($id){
        $blog = Blog::findorFail($id);
        return view('frontend.blog.detail', compact('blog'));
    }

    /*
    *@param value
    *
    *@return search result
    * */
    public function search($value)
    {
        $blog = Blog::where('title_en', 'LIKE', '%' . $value .'%')
            ->orWhere('title_ar', 'LIKE', '%' . $value .'%')
            ->orWhere('description_en', 'LIKE', '%' . $value .'%')
            ->orWhere('description_ar', 'LIKE', '%' . $value .'%')->get();
        $default = Blog::latest()->take(4)->get();
        return response()->json(['result' => view('frontend.blog.search', compact('blog','default'))->render()]);
    }
}