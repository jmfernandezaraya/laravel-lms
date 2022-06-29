<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;

use App\Classes\ImageSaverToStorage;

use App\Models\Country;
use App\Models\FrontPage;
use App\Models\Setting;
use App\Models\SuperAdmin\Course;
use App\Models\SuperAdmin\CourseProgram;
use App\Models\SuperAdmin\School;

use Carbon\Carbon;

use Illuminate\Http\Request;

/**
 * Class SettingController
 * @package App\Http\Controllers\SuperAdmin
 */
class SettingController extends Controller
{
    /**
     * SettingController constructor.
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
            file_put_contents(public_path('images/setting/' .$fileName), $interventionImage);
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('public/images/setting/' . $fileName);
            $msg = 'Image uploaded successfully';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            @header('Content-type: text/html; charset=utf-8');
            return $response;
        }
    }

    public function viewHomePage(Request $request)
    {
        $setting_value = null;
        $home_page = Setting::where('setting_key', 'home_page')->first();
        if ($home_page) {
            $setting_value = unserialize($home_page->setting_value);
        }

        $now = Carbon::now()->format('Y-m-d');
        // $course_ids = array_unique(CourseProgram::where('discount_per_week', '<>', ' -')->where('discount_per_week', '<>', ' %')
        //     ->where(function($query) use ($now) {
        //         $query->where(function($sub_query) use ($now) {
        //             $sub_query->where('discount_start_date', '<=', $now)->where('discount_end_date', '>=', $now);
        //         })->orWhere(function($sub_query) use ($now) {
        //             $sub_query->whereNotNull('x_week_selected')->where('x_week_start_date', '<=', $now)->where('x_week_end_date', '>=', $now);
        //         });
        //     })->pluck('course_unique_id')->toArray());
        $school_ids = array_unique(Course::where('promotion', true)->where('display', true)->where('deleted', false)->pluck('school_id')->toArray());
        $schools = School::whereIn('id', $school_ids)->where('is_active', true)->get();
        
        $countries = Country::with('cities')->get();
        
        return view('superadmin.setting.home_page', compact('setting_value', 'schools', 'countries'));
    }

    public function updateHomePage(Request $request)
    {
        $home_page = Setting::where('setting_key', 'home_page')->first();
        if (!$home_page) {
            $home_page = new Setting;
            $home_page->setting_key = 'home_page';
            $home_page_setting_value = [];
        } else {
            $home_page_setting_value = unserialize($home_page->setting_value);
        }
        $setting_value = [
            'heros' => [],
            'school_promotions' => [],
            'popular_countries' => [],
        ];
        for ($hero_index = 0; $hero_index <= $request->heroincretment; $hero_index++) {
            if (isset($request->hero_background[$hero_index]) && $request->hero_background[$hero_index]) {
                $this->storeImage->setImage($request->hero_background[$hero_index]);
                $this->storeImage->setPath('front_page');
            }
            $setting_value['heros'][] = [
                'title' => $request->hero_title[$hero_index],
                'title_ar' => $request->hero_title_ar[$hero_index],
                'text' => $request->hero_text[$hero_index],
                'text_ar' => $request->hero_text_ar[$hero_index],
                'background' => isset($request->hero_background[$hero_index]) && $request->hero_background[$hero_index] ? $this->storeImage->saveImage() : 
                    (isset($home_page_setting_value['heros']) && isset($home_page_setting_value['heros'][$hero_index]) ? $home_page_setting_value['heros'][$hero_index]['background'] : ''),
            ];
        }
        for ($school_index = 0; $school_index < count($request->school_id); $school_index++) {
            if ($request->school_id[$school_index]) {
                $setting_value['school_promotions'][] = $request->school_id[$school_index];
            }
        }
        $popular_country_index = 0;
        for ($country_index = 0; $country_index < count($request->country_id); $country_index++) {
            if ($request->country_id[$country_index]) {
                if (isset($request->country_logo[$country_index]) && $request->country_logo[$country_index]) {
                    $this->storeImage->setImage($request->country_logo[$country_index]);
                    $this->storeImage->setPath('front_page');
                }

                $setting_value['popular_countries'][] = [
                    'id' => $request->country_id[$country_index],
                    'logo' => isset($request->country_logo[$country_index]) && $request->country_logo[$country_index] ? $this->storeImage->saveImage() : 
                        (isset($home_page_setting_value['popular_countries']) && isset($home_page_setting_value['popular_countries'][$popular_country_index]) ? $home_page_setting_value['popular_countries'][$popular_country_index]['logo'] : ''),
                ];
                $popular_country_index = $popular_country_index + 1;
            }
        }
        $home_page->setting_value = serialize($setting_value);
        $home_page->save();

        return response()->json(['success' => 'success', 'message' => __('Admin/backend.data_saved_successfully'), 'reload' => true]);
    }

    public function viewHeaderFooter(Request $request)
    {
        $setting_value = null;
        $header_footer = Setting::where('setting_key', 'header_footer')->first();
        if ($header_footer) {
            $setting_value = unserialize($header_footer->setting_value);
        }

        $front_pages = FrontPage::all();
        
        return view('superadmin.setting.header_footer', compact('setting_value', 'setting_value', 'front_pages'));
    }

    public function updateHeaderFooter(Request $request)
    {
        $header_footer = Setting::where('setting_key', 'header_footer')->first();
        if (!$header_footer) {
            $header_footer = new Setting;
            $header_footer->setting_key = 'header_footer';
            $header_footer_setting_value = [];
        } else {
            $header_footer_setting_value = unserialize($header_footer->setting_value);
        }
        $setting_value = [
            'header' => [
                'logo' => '',
                'menu' => []
            ],
            'footer' => [
                'logo' => '',
                'description' => '',
                'description_ar' => '',
                'copyright' => '',
                'copyright_ar' => '',
                'credits' => '',
                'credits_ar' => '',                
                'menu' => []
            ],
        ];

        if (isset($request->header_logo) && $request->header_logo) {
            $this->storeImage->setImage($request->header_logo);
            $this->storeImage->setPath('setting');
        }
        $setting_value['header']['logo'] = isset($request->header_logo) && $request->header_logo ? $this->storeImage->saveImage() : 
            (isset($header_footer_setting_value['header']['logo']) ? $header_footer_setting_value['header']['logo'] : '');
        for ($header_menu_index = 0; $header_menu_index <= $request->headermenuincrement; $header_menu_index++) {
            if (isset($request->header_menu_type[$header_menu_index]) && $request->header_menu_type[$header_menu_index]) {
                if ($request->header_menu_page[$header_menu_index] || $request->header_menu_label[$header_menu_index] || $request->header_menu_label_ar[$header_menu_index]) {
                    $header_menu = [
                        'type' => $request->header_menu_type[$header_menu_index],
                        'page' => $request->header_menu_page[$header_menu_index],
                        'label' => $request->header_menu_label[$header_menu_index],
                        'label_ar' => $request->header_menu_label_ar[$header_menu_index],
                        'sub_menu' => [],
                    ];
                    if (isset($request->headermenusubincrement[$header_menu_index])) {
                        for ($header_menu_sub_index = 0; $header_menu_sub_index <= $request->headermenusubincrement[$header_menu_index]; $header_menu_sub_index++) {
                            if (isset($request->header_menu_sub_type[$header_menu_index][$header_menu_sub_index]) && $request->header_menu_sub_type[$header_menu_index][$header_menu_sub_index]) {
                                if ($request->header_menu_sub_page[$header_menu_index][$header_menu_sub_index] || $request->header_menu_sub_label[$header_menu_index][$header_menu_sub_index] || $request->header_menu_sub_label_ar[$header_menu_index][$header_menu_sub_index]) {
                                    $header_menu['sub_menu'][] = [
                                        'type' => $request->header_menu_sub_type[$header_menu_index][$header_menu_sub_index],
                                        'page' => $request->header_menu_sub_page[$header_menu_index][$header_menu_sub_index],
                                        'label' => $request->header_menu_sub_label[$header_menu_index][$header_menu_sub_index],
                                        'label_ar' => $request->header_menu_sub_label_ar[$header_menu_index][$header_menu_sub_index],
                                        'sub_menu' => [],
                                    ];
                                }
                            }
                        }
                    }
                    $setting_value['header']['menu'][] = $header_menu;
                }
            }
        }

        if (isset($request->footer_logo) && $request->footer_logo) {
            $this->storeImage->setImage($request->footer_logo);
            $this->storeImage->setPath('setting');
        }
        $setting_value['footer']['logo'] = isset($request->footer_logo) && $request->footer_logo ? $this->storeImage->saveImage() : 
            (isset($header_footer_setting_value['footer']['logo']) ? $header_footer_setting_value['footer']['logo'] : '');
        $setting_value['footer']['description'] = isset($request->footer_description) ? $request->footer_description : '';
        $setting_value['footer']['description_ar'] = isset($request->footer_description_ar) ? $request->footer_description_ar : '';
        $setting_value['footer']['copyright'] = isset($request->footer_copyright) ? $request->footer_copyright : '';
        $setting_value['footer']['copyright_ar'] = isset($request->footer_copyright_ar) ? $request->footer_copyright_ar : '';
        $setting_value['footer']['credits'] = isset($request->footer_credits) ? $request->footer_credits : '';
        $setting_value['footer']['credits_ar'] = isset($request->footer_credits_ar) ? $request->footer_credits_ar : '';
        for ($footer_menu_section_index = 0; $footer_menu_section_index <= $request->footermenusectionincrement; $footer_menu_section_index++) {
            if (isset($request->footermenuincrement[$footer_menu_section_index]) && $request->footermenuincrement[$footer_menu_section_index]) {
                $footer_menu_section = [
                    'title' => $request->footer_menu_title[$footer_menu_section_index],
                    'title_ar' => $request->footer_menu_title_ar[$footer_menu_section_index],
                    'menu' => [],
                ];
                for ($footer_menu_index = 0; $footer_menu_index <= $request->footermenuincrement[$footer_menu_section_index]; $footer_menu_index++) {
                    if (isset($request->footer_menu_type[$footer_menu_section_index][$footer_menu_index]) && $request->footer_menu_type[$footer_menu_section_index][$footer_menu_index]) {
                        $footer_menu = [
                            'type' => $request->footer_menu_type[$footer_menu_section_index][$footer_menu_index],
                            'page' => $request->footer_menu_page[$footer_menu_section_index][$footer_menu_index],
                            'label' => $request->footer_menu_label[$footer_menu_section_index][$footer_menu_index],
                            'label_ar' => $request->footer_menu_label_ar[$footer_menu_section_index][$footer_menu_index],
                            'sub_menu' => [],
                        ];
                        if (isset($request->footersubmenuincrement[$footer_menu_section_index][$footer_menu_index])) {
                            for ($footer_menu_sub_index = 0; $footer_menu_sub_index <= $request->footersubmenuincrement[$footer_menu_index]; $footer_menu_sub_index++) {
                                if (isset($request->footer_menu_sub_type[$footer_menu_section_index][$footer_menu_index][$footer_menu_sub_index]) && $request->footer_menu_sub_type[$footer_menu_section_index][$footer_menu_index][$footer_menu_sub_index]) {
                                    $footer_menu['sub_menu'][] = [
                                        'type' => $request->footer_menu_sub_type[$footer_menu_section_index][$footer_menu_index][$footer_menu_sub_index],
                                        'page' => $request->footer_menu_sub_page[$footer_menu_section_index][$footer_menu_index][$footer_menu_sub_index],
                                        'label' => $request->footer_menu_sub_label[$footer_menu_section_index][$footer_menu_index][$footer_menu_sub_index],
                                        'label_ar' => $request->footer_menu_sub_label_ar[$footer_menu_section_index][$footer_menu_index][$footer_menu_sub_index],
                                        'sub_menu' => [],
                                    ];
                                }
                            }
                        }
                        $footer_menu_section['menu'][] = $footer_menu;
                    }
                }
                $setting_value['footer']['menu'][] = $footer_menu_section;
            }
        }
        
        $header_footer->setting_value = serialize($setting_value);
        $header_footer->save();

        return response()->json(['success' => 'success', 'message' => __('Admin/backend.data_saved_successfully'), 'reload' => true]);
    }
    
    public function viewSite(Request $request)
    {
        $setting_value = null;
        $site = Setting::where('setting_key', 'site')->first();
        if ($site) {
            $setting_value = unserialize($site->setting_value);
        }

        $front_pages = FrontPage::all();
        
        return view('superadmin.setting.site', compact('setting_value', 'setting_value', 'front_pages'));
    }

    public function updateSite(Request $request)
    {
        $site = Setting::where('setting_key', 'site')->first();
        if (!$site) {
            $site = new Setting;
            $site->setting_key = 'site';
            $site_setting_value = [];
        } else {
            $site_setting_value = unserialize($site->setting_value);
        }
        $setting_value = [
            'email' => $request->email,
            'phone' => $request->phone,
            'newsletter' => [
                'title' => $request->newsletter_title,
                'title_ar' => $request->newsletter_title_ar,
                'description' => $request->newsletter_description,
                'description_ar' => $request->newsletter_description_ar,
            ],
            'social' => [
                'twitter' => '',
                'facebook' => '',
                'instagram' => '',
                'snapchat' => '',
                'youtube' => '',
                'tiktok' => '',
                'pinterest' => '',
                'skype' => '',
                'linkedin' => '',
            ],
            'course_reservation_links' => [
                'registration_conditions' => '',
                'terms_and_conditions' => '',
                'private_policy' => '',
            ]
        ];
        

        if (isset($request->social_twitter)) {
            $setting_value['social']['twitter'] = $request->social_twitter;
        }
        if (isset($request->social_facebook)) {
            $setting_value['social']['facebook'] = $request->social_facebook;
        }
        if (isset($request->social_instagram)) {
            $setting_value['social']['instagram'] = $request->social_instagram;
        }
        if (isset($request->social_snapchat)) {
            $setting_value['social']['snapchat'] = $request->social_snapchat;
        }
        if (isset($request->social_youtube)) {
            $setting_value['social']['youtube'] = $request->social_youtube;
        }
        if (isset($request->social_tiktok)) {
            $setting_value['social']['tiktok'] = $request->social_tiktok;
        }
        if (isset($request->social_pinterest)) {
            $setting_value['social']['pinterest'] = $request->social_pinterest;
        }
        if (isset($request->social_skype)) {
            $setting_value['social']['skype'] = $request->social_skype;
        }
        if (isset($request->social_linkedin)) {
            $setting_value['social']['linkedin'] = $request->social_linkedin;
        }
        
        if (isset($request->course_reservation_registration_conditions)) {
            $setting_value['course_reservation_links']['registration_conditions'] = $request->course_reservation_registration_conditions;
        }
        
        if (isset($request->course_reservation_terms_and_conditions)) {
            $setting_value['course_reservation_links']['terms_and_conditions'] = $request->course_reservation_terms_and_conditions;
        }
        
        if (isset($request->course_reservation_private_policy)) {
            $setting_value['course_reservation_links']['private_policy'] = $request->course_reservation_private_policy;
        }

        $site->setting_value = serialize($setting_value);
        $site->save();

        return response()->json(['success' => 'success', 'message' => __('Admin/backend.data_saved_successfully'), 'reload' => true]);
    }
}