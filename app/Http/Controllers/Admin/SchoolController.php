<?php

namespace App\Http\Controllers\Admin;

use Image;
use Storage;
use Session;

use App\Http\Controllers\Controller;

use App\Models\CourseApplication;
use App\Models\Country;
use App\Models\City;
use App\Models\School;
use App\Models\SchoolName;
use App\Models\ChooseNationality;
use App\Models\SchoolNationality;

use App\Classes\ImageSaverToStorage;

use App\Http\Requests\SuperAdmin\AddSchoolRequest;

use Illuminate\Http\Request;

/**
 * Class SchoolController
 * @package App\Http\Controllers\SuperAdmin
 */
class SchoolController extends Controller
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

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $choose_fields = [
            'names' => [],
            'countries' => [],
            'cities' => [],
        ];
        if (auth('superadmin')->check()) {
            $schools = School::with('name', 'country', 'city')->get();
        } else if (auth('schooladmin')->check()) {
            $schools = School::whereIn('id', auth('schooladmin')->user()->school_ids)->with('name', 'country', 'city')->get();
        }
        foreach($schools as $school) {
            if (is_null($school->name)) {
                if (!in_array('-', $choose_fields['names'])) {
                    array_push($choose_fields['names'], '-');
                }
            } else {
                if (app()->getLocale() == 'en') {
                    if (!in_array($school->name->name, $choose_fields['names'])) {
                        array_push($choose_fields['names'], $school->name->name);
                    }
                } else {
                    if (!in_array($school->name->name_ar, $choose_fields['names'])) {
                        array_push($choose_fields['names'], $school->name->name_ar);
                    }
                }
            }
            if (is_null($school->country)) {
                if (!in_array('-', $choose_fields['countries'])) {
                    array_push($choose_fields['countries'], '-');
                }
            } else {
                if (app()->getLocale() == 'en') {
                    if (!in_array($school->country->name, $choose_fields['countries'])) {
                        array_push($choose_fields['countries'], $school->country->name);
                    }
                } else {
                    if (!in_array($school->country->name_ar, $choose_fields['countries'])) {
                        array_push($choose_fields['countries'], $school->country->name_ar);
                    }
                }
            }
            if (is_null($school->city)) {
                if (!in_array('-', $choose_fields['cities'])) {
                    array_push($choose_fields['cities'], '-');
                }
            } else {
                if (app()->getLocale() == 'en') {
                    if (!in_array($school->city->name, $choose_fields['cities'])) {
                        array_push($choose_fields['cities'], $school->city->name);
                    }
                } else {
                    if (!in_array($school->city->name_ar, $choose_fields['cities'])) {
                        array_push($choose_fields['cities'], $school->city->name_ar);
                    }
                }
            }
        }

        return view('admin.school.index', compact('schools', 'choose_fields'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $countries = Country::with('cities')->orderBy('id', 'asc')->get();
        $choose_nationalities = ChooseNationality::all();
        $school_names = SchoolName::all();

        return view('admin.school.add', compact('countries', 'choose_nationalities', 'school_names'));
    }

    /**
     * @param AddSchoolRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AddSchoolRequest $request)
    {
        try {
            $save_to = $request->validated();

            unset($save_to['multiple_photos']);
            unset($save_to['logo']);
            unset($save_to['logos']);
            unset($save_to['nationality_increment']);
            unset($save_to['nationality']);
            unset($save_to['nationality_mix']);
            unset($save_to['name_id']);
            
            $school_name = null;
            if (app()->getLocale() =='en') {
                $school_name = SchoolName::where('name', $request->name_id)->first();
            } else {
                $school_name = SchoolName::where('name_ar', $request->name_id)->first();
            }
            $save_to['name_id'] = $school_name ? $school_name->id : 0;

            ini_set('max_execution_time', 400000);
            ini_set('post_max_size', 5000000);
            $input = $request->except('_token', 'en', 'nationality_increment', 'nationality_id', 'nationality', 'nationality_mix');
            if ($request->has('multiple_photos')) {
                $input['multiple_photos'] = [];
                foreach ($request->multiple_photos as $multiple_photo) {
                    $this->storeImage->setPath('school_images');
                    $this->storeImage->setImage($multiple_photo);
                    $input['multiple_photos'][] = $this->storeImage->saveImage();
                }
            }
            if ($request->has('logos')) {
                $input['logos'] = [];
                foreach ($request->logos as $logo) {
                    $this->storeImage->setPath('school_images');
                    $this->storeImage->setImage($logo);
                    $input['logos'][] = $this->storeImage->saveImage();
                }
            }
            if ($request->has('logo')) {
                $this->storeImage->setPath('school_images');
                $this->storeImage->setImage($request->logo);
                $input['logo'] = $this->storeImage->saveImage();
            }
            if ($request->has("video_url")) {
                $input['video'] = $request->video_url;
            }

            $school = new School();
            if ($save_to['address']) {
                if ($save_to['address'][0] == '"') {
                    $save_to['address'] = substr($save_to['address'], 1);
                }
                if ($save_to['address'][strlen($save_to['address']) - 1] == '"') {
                    $save_to['address'] = substr($save_to['address'], 0, strlen($save_to['address']) - 1);
                }
            }
            $school->fill($save_to + $input)->save();

            if (isset($request->nationality_increment)) {
                for ($count = 0; $count <= (int)$request->nationality_increment; $count++) {
                    if (isset($request->nationality[$count]) && $request->nationality[$count] && isset($request->nationality_mix[$count]) && $request->nationality_mix[$count]) {
                        $school_nationality = new SchoolNationality();
                        $school_nationality->school_id = $school->id;
                        $school_nationality->nationality_id = $request->nationality[$count];
                        $school_nationality->mix = $request->nationality_mix[$count];
                        $school_nationality->save();
                    }
                }
            }

            $data['success'] = true;
            $data['data'] = "Data Saved";
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['catch_error'] = $e->getMessage();
            $data['line_code'] = $e->getCode();
        }

        return response()->json($data);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $school = School::find($id);
        $countries = Country::with('cities')->orderBy('id', 'asc')->get();
        $choose_nationalities = ChooseNationality::all();
        $school_names = SchoolName::all();

        return view('admin.school.edit', compact('school', 'countries', 'choose_nationalities', 'school_names'));
    }

    /**
     * @param AddSchoolRequest $r
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update(AddSchoolRequest $request, $id)
    {
        ini_set('max_execution_time', 400000);
        ini_set('post_max_size', 5000000);

        $school = School::whereId($id)->first();
        $input = $request->except('_token', 'en', 'nationality_increment', 'nationality_id', 'nationality', 'nationality_mix');

        if ($request->has('multiple_photos')) {
            $input['multiple_photos'] = [];
            foreach ($request->multiple_photos as $multiple_photo) {
                $this->storeImage->setImage($multiple_photo);
                $this->storeImage->setPath('school_images');
                $input['multiple_photos'][] = $this->storeImage->saveImage();
            }
        }
        if ($request->has('logos')) {
            $input['logos'] = [];
            foreach ($request->file('logos') as $logo) {
                $this->storeImage->setImage($logo);
                $this->storeImage->setPath('school_images');
                $input['logos'][] = $this->storeImage->saveImage();
            }
        }
        if ($request->has('logo')) {
            $logo = $request->file('logo');
            $this->storeImage->setPath('school_images');
            $this->storeImage->setImage($logo);
            $input['logo'] = $this->storeImage->saveImage();
        }
        $save_to = $request->validated();

        unset($save_to['logo']);
        unset($save_to['logos']);
        unset($save_to['multiple_photos']);
        unset($save_to['video_url']);
        unset($save_to['nationality_increment']);
        unset($save_to['nationality']);
        unset($save_to['nationality_mix']);
            
        $school_name = null;
        if (app()->getLocale() =='en') {
            $school_name = SchoolName::where('name', $request->name_id)->first();
        } else {
            $school_name = SchoolName::where('name_ar', $request->name_id)->first();
        }
        $save_to['name_id'] = $school_name ? $school_name->id : 0;

        $input['video'] = $request->video_url;
        if ($save_to['address']) {
            if ($save_to['address'][0] == '"') {
                $save_to['address'] = substr($save_to['address'], 1);
            }
            if ($save_to['address'][strlen($save_to['address']) - 1] == '"') {
                $save_to['address'] = substr($save_to['address'], 0, strlen($save_to['address']) - 1);
            }
        }
        $school->fill($save_to + $input)->save();
        
        $school_nationality_ids = [];
        if (isset($request->nationality_increment)) {
            for ($count = 0; $count <= (int)$request->nationality_increment; $count++) {
                $school_nationality = null;
                if (isset($request->nationality_id[$count]) && $request->nationality_id[$count]) {
                    $school_nationality = SchoolNationality::where('id', $request->nationality_id[$count])->first();
                }
                if (!$school_nationality) {
                    $school_nationality = new SchoolNationality();
                    $school_nationality->school_id = $school->id;
                }
                if (isset($request->nationality[$count]) && $request->nationality[$count] && isset($request->nationality_mix[$count]) && $request->nationality_mix[$count]) {
                    $school_nationality->nationality_id = $request->nationality[$count];
                    $school_nationality->mix = $request->nationality_mix[$count];
                    $school_nationality->save();
                    if (!$school_nationality->id) {
                        $school_nationality_ids[] = SchoolNationality::orderBy('id')->last()->id;
                    } else {
                        $school_nationality_ids[] = $school_nationality->id;
                    }
                }
            }
        }
        $school_nationalities = SchoolNationality::where('id', $school->id)->get();
        foreach ($school_nationalities as $school_nationality) {
            if (!in_array($school_nationality->unique_id, $school_nationality_ids)) {
                $school_nationality->delete();
            }
        }

        $data['success'] = true;
        $data['data'] = __('Admin/backend.data_saved_successfully');
        return response($data);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clone($id)
    {
        $school = School::whereId($id)->first();

        $new_school = new School();
        $new_school->name_id = $school->name_id;
        $new_school->country_id = $school->country_id;
        $new_school->city_id = $school->city_id;
        $new_school->email = $school->email;
        $new_school->contact = $school->contact;
        $new_school->emergency_number = $school->emergency_number;
        $new_school->branch_name = $school->branch_name;
        $new_school->branch_name_ar = $school->branch_name_ar;
        $new_school->logo = $school->logo;
        $new_school->video = $school->video;
        $new_school->multiple_photos = $school->multiple_photos;
        $new_school->capacity = $school->capacity;
        $new_school->facilities = $school->facilities;
        $new_school->facilities_ar = $school->facilities_ar;
        $new_school->class_size = $school->class_size;
        $new_school->class_size_ar = $school->class_size_ar;
        $new_school->opened = $school->opened;
        $new_school->opening_hours = $school->opening_hours;
        $new_school->opening_hours_ar = $school->opening_hours_ar;
        $new_school->number_of_classrooms = $school->number_of_classrooms;
        $new_school->about = $school->about;
        $new_school->about_ar = $school->about_ar;
        $new_school->logos = $school->logos;
        $new_school->address = $school->address;
        $new_school->video_url = $school->video_url;
        $new_school->viewed_count = 0;
        $new_school->website_link = $school->website_link;
        $new_school->is_active = $school->is_active;
        $new_school->created_at = $school->created_at;
        $new_school->updated_at = null;
        $new_school->save();
        
        toastr()->success(__('Admin/backend.school_cloned_successfully'));
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function pause($id)
    {
        $db = \DB::transaction(function() use ($id) {
            $school = School::where('id', $id)->first();
            if ($school) {
                $school->is_active = false;
                $school->save();
                return true;
            }
        });
        if ($db) {
            toastr()->success(__('Admin/backend.school_paused_successfully'));
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
            $school = School::where('id', $id)->first();
            if ($school) {
                $school->is_active = true;
                $school->save();
                return true;
            }
        });
        if ($db) {
            toastr()->success(__('Admin/backend.school_played_successfully'));
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
            $school_ids = explode(",", $request_ids);
    
            foreach ($school_ids as $school_id) {
                if ($school_id) {
                    if ($request_action == "clone") {
                        $this->clone($school_id);
                    } else if ($request_action == "play") {
                        $this->play($school_id);
                    } else if ($request_action == "pause") {
                        $this->pause($school_id);
                    } else if ($request_action == "destroy") {
                        $this->destroy($school_id);
                    }
                }
            }
        }
        return back();
    }

    /**
     * @param $id
     * @return bool|\Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $school_ids = CourseApplication::pluck('school_id')->toArray();

        if (in_array($id, $school_ids)) {
            toastr()->error(__('Admin/backend.customer_registered_with_this_school'));
            return back();
        } else {
            $delete = School::find($id)->delete();

            if ($delete) {
                toastr()->success(__('Admin/backend.school_deleted_successfully'));
                return back();
            }
            return true;
        }
    }

    /**
     * @param Request $r
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    function getCountryList(Request $request)
    {
        $language = app()->getLocale();
        $schools = School::where('is_active', true)->whereHas('name', function($query) use ($request, $language)
            { $language =='en' ? $query->where('name', $request->school_name) : $query->where('name_ar', $request->school_name); })->get();
        $country_ids = [];
        foreach ($schools as $school) {
            if (!in_array($school->country_id, $country_ids)) {
                $country_ids[] = $school->country_id;
            }
        }
        $countries = Country::whereIn('id', $country_ids)->orderBy('id', 'asc')->get();
        $country_list = "";
        if ($request->empty_value == 'true') $country_list .= "<option value=''>" . __('Admin/backend.select_option') . "</option>";
        foreach ($countries as $country) {
            if ($country) $country_list .= "<option value='$country->id'>" . (app()->getLocale() == 'en' ? $country->name : $country->name_ar)."</option>";
        }

        return response($country_list);
    }

    /**
     * @param Request $r
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    function getCityList(Request $request)
    {
        $language = app()->getLocale();
        if (isset($request->school_name)) {
            $city_ids = [];
            $schools = School::where('is_active', true)->whereHas('name', function($query) use ($request, $language)
                { $language =='en' ? $query->where('name', $request->school_name) : $query->where('name_ar', $request->school_name); })->get();
            foreach ($schools as $school) {
                if (is_array($request->country_ids)) {
                    if (in_array($school->country_id, $request->country_ids)) {
                        $city_ids[] = $school->city_id;
                    }
                } else {
                    if ($school->country_id == $request->country_ids) {
                        $city_ids[] = $school->city_id;
                    }
                }
            }
            $cities = City::whereIn('id', $city_ids)->get();
        } else {
            $cities = City::where('country_id', $request->country_ids)->get();
        }
        $city_list = "";
        if ($request->empty_value == 'true') $city_list .= "<option value=''>" . __('Admin/backend.select_option') . "</option>";
        foreach ($cities as $city) {
            if ($city) $city_list .= "<option value='$city->id'>".(app()->getLocale() == 'en' ? $city->name : $city->name_ar)."</option>";
        }

        return response($city_list);
    }

    /**
     * @param Request $r
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    function getCityByCountryList(Request $request)
    {
        $country = Country::with('cities')->where('id', $request->id)->first();
        $city_list = "";
        if ($request->empty_value == 'true') $city_list .= "<option value=''>" . __('Admin/backend.select_option') . "</option>";
        foreach ($country->cities as $city) {
            if ($city) $city_list .= "<option value='$city->id'>".(app()->getLocale() == 'en' ? $city->name : $city->name_ar)."</option>";
        }

        return response($city_list);
    }

    /**
     * @param Request $r
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    function getBranchList(Request $request)
    {
        $language = app()->getLocale();
        $schools = School::where('is_active', true)->whereHas('name', function($query) use ($request, $language)
            { $language =='en' ? $query->where('name', $request->school_name) : $query->where('name_ar', $request->school_name); })->get();
        $branch_names = [];
        foreach ($schools as $school) {
            $country_city_flag = true;
            if (is_array($request->country_ids)) {
                if (!in_array($school->country_id, $request->country_ids)) {
                    $country_city_flag = false;
                }
            } else {
                if ($school->country_id != $request->country_ids) {
                    $country_city_flag = false;
                }
            }
            if (is_array($request->city_ids)) {
                if (!in_array($school->city_id, $request->city_ids)) {
                    $country_city_flag = false;
                }
            } else {
                if ($school->city_id != $request->city_ids) {
                    $country_city_flag = false;
                }
            }
            if ($country_city_flag) {
                if (app()->getLocale() == 'en' && $school->branch_name) {
                    $branch_names[] = $school->branch_name;
                } else if (app()->getLocale() != 'en' && $school->branch_name_ar) {
                    $branch_names[] = $school->branch_name_ar;
                }
            }
        }

        $branch_list = "";
        if ($request->empty_value == 'true') $branch_list .= "<option value=''>" . __('Admin/backend.select_option') . "</option>";
        foreach ($branch_names as $branch_name) {
            $branch_list .= "<option value='$branch_name'>$branch_name</option>";
        }

        return response($branch_list);
    }

    public function viewCountryCityList()
    {
        $countries = Country::with('cities')->orderBy('id', 'asc')->get();
        
        return view('admin.school.country_city', compact('countries'));
    }

    public function updateCoutryCityList(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'name.*' => 'required',
                'name_ar.*' => 'required',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        
        $country_ids = [];
        for ($i = 0; $i <= $request->country_increment; $i++) {
            $country = null;
            if (isset($request->country_id[$i]) && $request->country_id[$i]) {
                $country = Country::where('id', $request->country_id[$i])->first();
            }
            if (!$country) {
                $country = new Country();
            }
            $country->name = $request->name[$i] ?? null;
            $country->name_ar = $request->name_ar[$i] ?? null;
            $country->save();
            if (!$country->id) {
                $country_id = Country::orderBy('id')->last()->id;
            } else {
                $country_id = $country->id;
            }
            $country_ids[] = $country_id;

            $city_ids = [];
            for ($j = 0; $j <= $request->city_increment[$i]; $j++) {
                if ($request->city_name[$i][$j] && $request->city_name_ar[$i][$j]) {
                    $city = null;
                    if (isset($request->city_id[$i][$j]) && $request->city_id[$i][$j]) {
                        $city = City::where('id', $request->city_id[$i][$j])->first();
                    }
                    if (!$city) {
                        $city = new City();
                    }
                    $city->country_id = $country_id;
                    $city->name = $request->city_name[$i][$j] ?? null;
                    $city->name_ar = $request->city_name_ar[$i][$j] ?? null;
                    $city->save();
                    if (!$city->id) {
                        $city_ids[] = City::orderBy('id')->last()->id;
                    } else {
                        $city_ids[] = $city->id;
                    }
                }
            }
            $cities = City::where('country_id', $country_id)->get();
            foreach ($cities as $city) {
                if (!in_array($city->id, $city_ids)) {
                    $city->delete();
                }
            }
        }
        $countries = Country::all();
        foreach ($countries as $country) {
            if (!in_array($country->id, $country_ids)) {
                $country->delete();
            }
        }        
        
        $data['success'] = true;
        $data['data'] = __('Admin/backend.data_saved_successfully');

        return response()->json($data);
    }

    public function viewNameList()
    {
        $school_names = SchoolName::orderBy('id', 'asc')->get();
        
        return view('admin.school.name', compact('school_names'));
    }

    public function updateNameList(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'name.*' => 'required',
                'name_ar.*' => 'required',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        
        $school_name_ids = [];
        for ($i = 0; $i <= $request->school_name_increment; $i++) {
            $school_name = null;
            if (isset($request->school_name_id[$i]) && $request->school_name_id[$i]) {
                $school_name = SchoolName::where('id', $request->school_name_id[$i])->first();
            }
            if (!$school_name) {
                $school_name = new SchoolName();
            }
            $school_name->name = $request->name[$i] ?? null;
            $school_name->name_ar = $request->name_ar[$i] ?? null;
            $school_name->save();
            if (!$school_name->id) {
                $school_name_id = SchoolName::orderBy('id')->last()->id;
            } else {
                $school_name_id = $school_name->id;
            }
            $school_name_ids[] = $school_name_id;
        }
        $school_names = SchoolName::all();
        foreach ($school_names as $school_name) {
            if (!in_array($school_name->id, $school_name_ids)) {
                $school_name->delete();
            }
        }
        
        $data['success'] = true;
        $data['data'] = __('Admin/backend.data_saved_successfully');

        return response()->json($data);
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

            $interventionImage = Image::make($originName)->resize(150, 150, function($constrained){

              $constrained->aspectRatio();
            })->encode('webp');
            file_put_contents(public_path('images/school_images/' .$fileName), $interventionImage);
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('public/images/school_images/' . $fileName);
            $msg = 'Image uploaded successfully';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            @header('Content-type: text/html; charset=utf-8');
            return $response;
        }
    }

    public function viewNationality()
    {
        $nationalities = ChooseNationality::all();
        
        return view('admin.school.nationality', compact('nationalities'));
    }

    public function updateNationality(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'name.*' => 'required',
                'name_ar.*' => 'required',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        
        $choose_nationality_unique_ids = [];
        for ($i = 0; $i <= $request->nationality_increment; $i++) {
            $choose_nationality = null;
            if (isset($request->nationality_unique_id[$i]) && $request->nationality_unique_id[$i]) {
                $choose_nationality = ChooseNationality::where('unique_id', $request->nationality_unique_id[$i])->first();
            }
            if (!$choose_nationality) {
                $choose_nationality = new ChooseNationality();                
                $choose_nationality->unique_id = (new Controller())->my_unique_id(1);
            }
            $choose_nationality->name = $request->name[$i] ?? null;
            $choose_nationality->name_ar = $request->name_ar[$i] ?? null;
            $choose_nationality->save();
            $choose_nationality_unique_ids[] = $choose_nationality->unique_id;
        }
        $choose_nationalities = ChooseNationality::all();
        foreach ($choose_nationalities as $choose_nationality) {
            if (!in_array($choose_nationality->unique_id, $choose_nationality_unique_ids)) {
                $choose_nationality->delete();
            }
        }
        
        $data['success'] = true;
        $data['data'] = __('Admin/backend.data_saved_successfully');

        return response()->json($data);
    }
}