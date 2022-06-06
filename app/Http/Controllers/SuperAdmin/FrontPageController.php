<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;

use App\Classes\ImageSaverToStorage;

use App\Models\FrontPage;
use App\Models\Country;

use App\Models\SuperAdmin\Course;
use App\Models\SuperAdmin\CourseProgram;
use App\Models\SuperAdmin\School;

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

    public function viewHomePage(Request $request)
    {
        $content = null;
        $front_page = FrontPage::where('slug', '/')->first();
        if ($front_page) {
            $content = unserialize($front_page->content);
        }

        $now = Carbon::now()->format('Y-m-d');
        $course_ids = array_unique(CourseProgram::where('discount_per_week', '<>', ' -')->where('discount_per_week', '<>', ' %')
            ->where(function($query) use ($now) {
                $query->where(function($sub_query) use ($now) {
                    $sub_query->where('discount_start_date', '<=', $now)->where('discount_end_date', '>=', $now);
                })->orWhere(function($sub_query) use ($now) {
                    $sub_query->whereNotNull('x_week_selected')->where('x_week_start_date', '<=', $now)->where('x_week_end_date', '>=', $now);
                });
            })->pluck('course_unique_id')->toArray());
        $school_ids = array_unique(Course::whereIn('unique_id', $course_ids)->where('display', true)->where('deleted', false)->pluck('school_id')->toArray());
        $schools = School::whereIn('id', $school_ids)->where('is_active', true)->get();
        
        $countries = Country::with('cities')->get();
        
        return view('superadmin.front_page.home', compact('front_page', 'content', 'schools', 'countries'));
    }

    public function updateHomePage(Request $request)
    {
        $front_page = FrontPage::where('slug', '/')->first();
        if (!$front_page) {
            $front_page = new FrontPage;
            $front_page->title = __('Frontend.home_page');
            $front_page->title_ar = __('Frontend.home_page');
            $front_page->slug = '/';
            $front_page_content = [];
        } else {
            $front_page_content = unserialize($front_page->content);
        }
        $content = [
            'heros' => [],
            'school_promotions' => [],
            'popular_countries' => [],
        ];
        for ($hero_index = 0; $hero_index <= $request->heroincretment; $hero_index++) {
            if (isset($request->hero_background[$hero_index]) && $request->hero_background[$hero_index]) {
                $this->storeImage->setImage($request->hero_background[$hero_index]);
                $this->storeImage->setPath('front_page');
            }
            $content['heros'][] = [
                'title' => $request->hero_title[$hero_index],
                'title_ar' => $request->hero_title_ar[$hero_index],
                'text' => $request->hero_text[$hero_index],
                'text_ar' => $request->hero_text_ar[$hero_index],
                'background' => isset($request->hero_background[$hero_index]) && $request->hero_background[$hero_index] ? $this->storeImage->saveImage() : 
                    (isset($front_page_content['heros']) && isset($front_page_content['heros'][$hero_index]) ? $front_page_content['heros'][$hero_index]['background'] : ''),
            ];
        }
        for ($school_index = 0; $school_index < count($request->school_id); $school_index++) {
            if ($request->school_id[$school_index]) {
                $content['school_promotions'][] = $request->school_id[$school_index];
            }
        }
        $popular_country_index = 0;
        for ($country_index = 0; $country_index < count($request->country_id); $country_index++) {
            if ($request->country_id[$country_index]) {
                if (isset($request->country_logo[$country_index]) && $request->country_logo[$country_index]) {
                    $this->storeImage->setImage($request->country_logo[$country_index]);
                    $this->storeImage->setPath('front_page');
                }

                $content['popular_countries'][] = [
                    'id' => $request->country_id[$country_index],
                    'logo' => isset($request->country_logo[$country_index]) && $request->country_logo[$country_index] ? $this->storeImage->saveImage() : 
                        (isset($front_page_content['popular_countries']) && isset($front_page_content['popular_countries'][$popular_country_index]) ? $front_page_content['popular_countries'][$popular_country_index]['logo'] : ''),
                ];
                $popular_country_index = $popular_country_index + 1;
            }
        }
        $front_page->content = serialize($content);
        $front_page->save();

        toastr()->success(__('SuperAdmin/backend.data_saved'));
        return back();
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $front_pages = FrontPage::where('slug', '<>', '/')->get();

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
            'content' => 'required',
            'content_ar' => 'required',
        ];
        $validate = \Validator::make($request->all(), $rules, [
            'title.required' => __('SuperAdmin/backend.errors.title_in_english'),
            'title_ar.required' => __('SuperAdmin/backend.errors.title_in_arabic'),
            'slug.required' => __('SuperAdmin/backend.errors.slug'),
            'content.required' => __('SuperAdmin/backend.errors.content_in_english'),
            'content_ar.required' => __('SuperAdmin/backend.errors.content_in_arabic'),
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
            $front_page->display = true;
            $front_page->save();
            
            return redirect(route('superadmin.front_page.index'));
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
            'content' => 'required',
            'content_ar' => 'required',
        ];
        $validate = \Validator::make($request->all(), $rules, [
            'title.required' => __('SuperAdmin/backend.errors.title_in_english'),
            'title_ar.required' => __('SuperAdmin/backend.errors.title_in_arabic'),
            'slug.required' => __('SuperAdmin/backend.errors.slug'),
            'content.required' => __('SuperAdmin/backend.errors.content_in_english'),
            'content_ar.required' => __('SuperAdmin/backend.errors.content_in_arabic'),
        ]);
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()]);
        }

        $front_page->title = $request->title;
        $front_page->title_ar = $request->title_ar;
        $front_page->slug = $this->getSlug($request->slug);
        $front_page->content = $request->content;
        $front_page->content_ar = $request->content_ar;
        $front_page->save();
        $saved = __('SuperAdmin/backend.data_saved');
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