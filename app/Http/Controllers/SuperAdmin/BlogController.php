<?php

namespace App\Http\Controllers\SuperAdmin;

use Image;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\BlogRequest;

use App\Models\Blog;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

use Intervention\Image\Exception\NotReadableException;

/**
 * Class BlogController
 * @package App\Http\Controllers\SuperAdmin
 */
class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::all();

        return view('superadmin.blog.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('superadmin.blog.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogRequest $request)
    {
        $rules = [
            'title_en' => 'required',
            'title_ar' => 'required',
            'description_ar' => 'required',
            'description_en' => 'required',
        ];
        $validate = Validator::make($request->all(), $rules, [
            'title_ar.required' => __('SuperAdmin/backend.errors.blog_title_in_arabic'),
            'title_en.required' => __('SuperAdmin/backend.errors.blog_title_in_english'),
            'description_en.required' => __('SuperAdmin/backend.errors.description_en_required'),
            'description_ar.required' => __('SuperAdmin/backend.errors.description_ar_required'),
        ]);
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()]);
        }

        try {
            $blog = new Blog;
            $blog->title_en = $request->title_en;
            $blog->title_ar = $request->title_ar;
            $blog->description_ar = $request->description_ar;
            $blog->description_en = $request->description_en;
            $blog->display = true;
            $blog->save();
            
            toastr()->success(__('SuperAdmin/backend.data_saved_successfully'));

            return redirect()->route('superadmin.blog.index');
        } catch (NotReadableException $e) {
            $exception = __('SuperAdmin/backend.errors.image_required');
            return response()->json(['catch_error' => $exception]);
        } catch (\Exception $e) {
            return response()->json(['catch_error' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Blog $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        return view('superadmin.blog.edit', compact('blog'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        $blog = Blog::find($id);

        $rules = [
            'title_en' => 'required',
            'title_ar' => 'required',
            'description_ar' => 'required',
            'description_en' => 'required',
        ];
        $validate = Validator::make($request->all(), $rules, [
            'title_ar.required' => __('SuperAdmin/backend.errors.blog_title_in_arabic'),
            'title_en.required' => __('SuperAdmin/backend.errors.blog_title_in_english'),
            'description_en.required' => __('SuperAdmin/backend.errors.description_en_required'),
            'description_ar.required' => __('SuperAdmin/backend.errors.description_ar_required'),
        ]);
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()]);
        }
        $save = $validate->validated();

        $blog->fill($save)->save();
        $saved = __('SuperAdmin/backend.data_saved_successfully');
        return response()->json(['data' => $saved]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Blog::findorFail($id);
        $deleted = __('SuperAdmin/backend.data_deleted_successfully');

        if ($delete->image != '' && $delete->image != null && file_exists($delete->image)) {
            unlink($delete->image);
        }
        $delete->delete();
        return back()->with(['message' => $deleted]);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload');
            $fulloriginName = $originName->getClientOriginalName();
            $fileName = pathinfo($fulloriginName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . 'webp';
            $interventionImage = Image::make($originName)->resize(150, 150, function($constrained) {
                $constrained->aspectRatio();
            })->encode('webp');
            file_put_contents(public_path('images/blog_images/' .$fileName), $interventionImage);
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('public/images/blog_images/' . $fileName);
            $msg = 'Image uploaded successfully';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            @header('Content-type: text/html; charset=utf-8');
            return $response;
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function pause($id)
    {
        $db = \DB::transaction(function() use ($id) {
            $blog = Blog::where('id', $id)->first();
            if ($blog) {
                $blog->display = false;
                $blog->save();
                return true;
            }
        });
        if ($db) {
            toastr()->success(__('SuperAdmin/backend.data_paused_successfully'));
        }
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function play($id)
    {
        $db = \DB::transaction(function() use ($id) {
            $blog = Blog::where('id', $id)->first();
            if ($blog) {
                $blog->display = true;
                $blog->save();
                return true;
            }
        });
        if ($db) {
            toastr()->success(__('SuperAdmin/backend.data_played_successfully'));
        }
        return back();
    }
}