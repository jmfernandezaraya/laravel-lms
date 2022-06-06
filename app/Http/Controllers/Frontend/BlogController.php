<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::where('display', true)->latest()->get();
        return view('frontend.blog.index', compact('blogs'));
    }

    public function show($id)
    {
        $blog = Blog::findorFail($id);
        return view('frontend.blog.detail', compact('blog'));
    }

    /*
    * @param value
    *
    * @return search result
    * */
    public function search($value)
    {
        $blogs = Blog::where('display', true)->where(function($query) use ($value) {
            $query->where('title_en', 'LIKE', '%' . $value .'%')
            ->orWhere('title_ar', 'LIKE', '%' . $value .'%')
            ->orWhere('description_en', 'LIKE', '%' . $value .'%')
            ->orWhere('description_ar', 'LIKE', '%' . $value .'%');
        })->get();

        return response()->json(['result' => view('frontend.blog.search', compact('blogs'))->render()]);
    }
}