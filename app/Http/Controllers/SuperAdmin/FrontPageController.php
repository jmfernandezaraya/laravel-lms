<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;

use App\Classes\ImageSaverToStorage;

use App\Models\FrontPage;

use Carbon\Carbon;

use Illuminate\Http\Request;

/**
 * Class FrontPageController
 * @package App\Http\Controllers\SuperAdmin
 */
class FrontPageController extends Controller
{
    /**
     * SchoolController constructor.
     */
    private $storeImage;

    public function __construct()
    {
        ini_set('post_max_size', 99999);
        ini_set('max_execution_time', 99999);
        ini_set('upload_max_filesize', 99999);
        ini_set('max_file_uploads', 444);

        $this->storeImage = new ImageSaverToStorage();
    }

    private function getSlug($slug, $id = 0)
    {
        $front_page = FrontPage::where('slug', $slug . ($id ? $id : ''))->first();
        if ($front_page) {
            return $this->getSlug($slug, $id + 1);
        }
        return $slug;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $front_pages = FrontPage::where('slug', '<>', '/')->where('slug', '<>', '/header_footer')->get();

        return view('superadmin.front_page.index', compact('front_pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('superadmin.front_page.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required',
            'title_ar' => 'required',
            'slug' => 'required',
        ];
        $validate = \Validator::make($request->all(), $rules, [
            'title.required' => __('SuperAdmin/backend.errors.title_in_english'),
            'title_ar.required' => __('SuperAdmin/backend.errors.title_in_arabic'),
            'slug.required' => __('SuperAdmin/backend.errors.slug'),
        ]);
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()]);
        }

        try {
            $front_page = new FrontPage;
            $front_page->title = $request->title;
            $front_page->title_ar = $request->title_ar;
            $front_page->slug = $this->getSlug($request->slug);
            $front_page->content = $request->content;
            $front_page->content_ar = $request->content_ar;
            $front_page->display = isset($request->display) ? true : false;
            $front_page->route = isset($request->route) ? true : false;
            $front_page->save();
            
            toastr()->success(__('SuperAdmin/backend.front_page_added_successfully'));

            return back()->with(['message' => __('SuperAdmin/backend.front_page_added_successfully')]);
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
     * @param FrontPage $front_page
     * @return \Illuminate\Http\Response
     */
    public function edit(FrontPage $front_page)
    {
        return view('superadmin.front_page.edit', compact('front_page'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        $front_page = FrontPage::find($id);

        $rules = [
            'title' => 'required',
            'title_ar' => 'required',
            'slug' => 'required',
        ];
        $validate = \Validator::make($request->all(), $rules, [
            'title.required' => __('SuperAdmin/backend.errors.title_in_english'),
            'title_ar.required' => __('SuperAdmin/backend.errors.title_in_arabic'),
            'slug.required' => __('SuperAdmin/backend.errors.slug'),
        ]);
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()]);
        }

        $front_page->title = $request->title;
        $front_page->title_ar = $request->title_ar;
        $front_page->slug = $this->getSlug($request->slug);
        $front_page->content = $request->content;
        $front_page->content_ar = $request->content_ar;
        $front_page->display = isset($request->display) ? true : false;
        $front_page->route = isset($request->route) ? true : false;
        $front_page->save();

        toastr()->success(__('SuperAdmin/backend.front_page_updated_successfully'));

        return back()->with(['message' => __('SuperAdmin/backend.front_page_updated_successfully')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = FrontPage::findorFail($id);
        $deleted = __('SuperAdmin/backend.data_deleted');

        if ($delete->image != '' && $delete->image != null && file_exists($delete->image)) {
            unlink($delete->image);
        }
        $delete->delete();

        toastr()->success(__('SuperAdmin/backend.front_page_deleted_successfully'));

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
            file_put_contents(public_path('images/front_page/' .$fileName), $interventionImage);
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('public/images/front_page/' . $fileName);
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
    public function clone($id)
    {
        $front_page = FrontPage::whereId($id)->first();

        $new_front_page = new FrontPage();
        $new_front_page->title = $front_page->title;
        $new_front_page->title_ar = $front_page->title_ar;
        $new_front_page->slug =  $this->getSlug($front_page->slug);
        $new_front_page->content = $front_page->content;
        $new_front_page->content_ar = $front_page->content_ar;
        $new_front_page->created_at = $front_page->created_at;
        $new_front_page->updated_at = null;
        $new_front_page->save();
        
        toastr()->success(__('SuperAdmin/backend.front_page_cloned_successfully'));
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function pause($id)
    {
        $db = \DB::transaction(function() use ($id) {
            $front_page = FrontPage::where('id', $id)->first();
            if ($front_page) {
                $front_page->display = false;
                $front_page->save();
                return true;
            }
        });
        if ($db) {
            toastr()->success(__('SuperAdmin/backend.front_page_paused_successfully'));
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
            $front_page = FrontPage::where('id', $id)->first();
            if ($front_page) {
                $front_page->display = true;
                $front_page->save();
                return true;
            }
        });
        if ($db) {
            toastr()->success(__('SuperAdmin/backend.front_page_played_successfully'));
        }
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function bulk(Request $request)
    {
        $request_action = $request->action;
        $request_ids = $request->ids;
        if ($request_ids) {
            $front_page_ids = explode(",", $request_ids);
    
            foreach ($front_page_ids as $front_page_id) {
                if ($front_page_id) {
                    if ($request_action == "clone") {
                        $this->clone($front_page_id);
                    } else if ($request_action == "play") {
                        $this->play($front_page_id);
                    } else if ($request_action == "pause") {
                        $this->pause($front_page_id);
                    } else if ($request_action == "destroy") {
                        $this->destroy($front_page_id);
                    }
                }
            }
        }
        return back();
    }
}