<?php

namespace App\Http\Controllers\Admin;

use Image;
use Session;

use App\Http\Controllers\Controller;

use App\Models\CourseApplication;
use App\Models\User;

use App\Models\Country;
use App\Models\City;
use App\Models\ChooseAccommodationAge;
use App\Models\ChooseAccommodationUnderAge;
use App\Models\ChooseBranch;
use App\Models\ChooseClassesDay;
use App\Models\ChooseCustodianUnderAge;
use App\Models\ChooseLanguage;
use App\Models\ChooseProgramAge;
use App\Models\ChooseProgramType;
use App\Models\ChooseProgramUnderAge;
use App\Models\ChooseStartDate;
use App\Models\ChooseStudyMode;
use App\Models\ChooseStudyTime;
use App\Models\Course;
use App\Models\CourseAccommodation;
use App\Models\CourseAccommodationUnderAge;
use App\Models\CourseAirport;
use App\Models\CourseCustodian;
use App\Models\CourseMedical;
use App\Models\CourseProgram;
use App\Models\CourseProgramTextBookFee;
use App\Models\CourseProgramUnderAgeFee;
use App\Models\CurrencyExchangeRate;
use App\Models\School;

use App\Services\CourseCreateService;

use Illuminate\Http\Request;

class CourseController extends Controller
{
    function _getChooseFields($courses)
    {
        $choose_fields = [
            'languages' => [],
            'program_types' => [],
            'study_modes' => [],
            'school_names' => [],
            'school_countries' => [],
            'school_cities' => [],
            'branch_names' => [],
            'currencies' => []
        ];
        foreach($courses as $course) {
            if (is_null($course->language)) {
                if (!in_array('-', $choose_fields['languages'])) {
                    array_push($choose_fields['languages'], '-');
                }
            } else {
                if (is_array($course->language)) {
                    $choose_fields['languages'] = array_unique(array_merge($choose_fields['languages'], $course->language));
                } else {
                    if (!in_array($course->language, $choose_fields['languages'])) {
                        array_push($choose_fields['languages'], $course->language);
                    }
                }
            }

            if (is_null($course->program_type)) {
                if (!in_array('-', $choose_fields['program_types'])) {
                    array_push($choose_fields['program_types'], '-');
                }
            } else {
                if (is_array($course->program_type)) {
                    $choose_fields['program_types'] = array_unique(array_merge($choose_fields['program_types'], $course->program_type));
                } else {
                    if (!in_array($course->program_type, $choose_fields['program_types'])) {
                        array_push($choose_fields['program_types'], $course->program_type);
                    }
                }
            }

            if (is_null($course->study_mode)) {
                if (!in_array('-', $choose_fields['study_modes'])) {
                    array_push($choose_fields['study_modes'], '-');
                }
            } else {
                if (is_array($course->study_mode)) {
                    $choose_fields['study_modes'] = array_unique(array_merge($choose_fields['study_modes'], $course->study_mode));
                } else {
                    if (!in_array($course->study_mode, $choose_fields['study_modes'])) {
                        array_push($choose_fields['study_modes'], $course->study_mode);
                    }
                }
            }

            if (is_null($course->school->name)) {
                if (!in_array('-', $choose_fields['school_names'])) {
                    array_push($choose_fields['school_names'], '-');
                }
            } else {
                if (app()->getLocale() == 'en') {
                    if (!in_array($course->school->name->name, $choose_fields['school_names'])) {
                        array_push($choose_fields['school_names'], $course->school->name->name);
                    }
                } else {
                    if (!in_array($course->school->name->name_ar, $choose_fields['school_names'])) {
                        array_push($choose_fields['school_names'], $course->school->name->name_ar);
                    }
                }
            }

            if (is_null($course->school->country)) {
                if (!in_array('-', $choose_fields['school_countries'])) {
                    array_push($choose_fields['school_countries'], '-');
                }
            } else {
                if (app()->getLocale() == 'en') {
                    if (!in_array($course->school->country->name, $choose_fields['school_countries'])) {
                        array_push($choose_fields['school_countries'], $course->school->country->name);
                    }
                } else {
                    if (!in_array($course->school->country->name_ar, $choose_fields['school_countries'])) {
                        array_push($choose_fields['school_countries'], $course->school->country->name_ar);
                    }
                }
            }

            if (is_null($course->school->city)) {
                if (!in_array('-', $choose_fields['school_cities'])) {
                    array_push($choose_fields['school_cities'], '-');
                }
            } else {
                if (app()->getLocale() == 'en') {
                    if (!in_array($course->school->city->name, $choose_fields['school_cities'])) {
                        array_push($choose_fields['school_cities'], $course->school->city->name);
                    }
                } else {
                    if (!in_array($course->school->city->name_ar, $choose_fields['school_cities'])) {
                        array_push($choose_fields['school_cities'], $course->school->city->name_ar);
                    }
                }
            }

            if (is_null($course->branch)) {
                if (!in_array('-', $choose_fields['branch_names'])) {
                    array_push($choose_fields['branch_names'], '-');
                }
            } else {
                if (is_array($course->branch)) {
                    $choose_fields['branch_names'] = array_unique(array_merge($choose_fields['branch_names'], $course->branch));
                } else {
                    if (!in_array($course->branch, $choose_fields['branch_names'])) {
                        array_push($choose_fields['branch_names'], $course->branch);
                    }
                }
            }

            if ($course->getCurrency) {
                $course_currency_name = app()->getLocale() == 'en' ? $course->getCurrency->name : $course->getCurrency->name_ar;
                if (!in_array($course_currency_name, $choose_fields['currencies'])) {
                    array_push($choose_fields['currencies'], $course_currency_name);
                }
            } else {
                if (!in_array('-', $choose_fields['currencies'])) {
                    array_push($choose_fields['currencies'], '-');
                }
            }
        }
        $choose_fields['languages'] = ChooseLanguage::whereIn('unique_id', $choose_fields['languages'])->pluck('name')->toArray();
        $choose_fields['program_types'] = ChooseProgramType::whereIn('unique_id', $choose_fields['program_types'])->pluck('name')->toArray();
        $choose_fields['study_modes'] = ChooseStudyMode::whereIn('unique_id', $choose_fields['study_modes'])->pluck('name')->toArray();

        return $choose_fields;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    function index()
    {
        if (auth('superadmin')->check()) {
            $courses = Course::with('school')->where('deleted', false)->get();
        } else if (auth('schooladmin')->check()) {
            $courses = Course::whereIn('school_id', auth('schooladmin')->user()->school_ids)->with('school')->where('deleted', false)->get();
        }
        $choose_fields = self::_getChooseFields($courses);

        return view('admin.course.index', compact('courses', 'choose_fields'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    function deleted()
    {
        if (auth('superadmin')->check()) {
            $courses = Course::with('school')->where('deleted', true)->get();
        } else if (auth('schooladmin')->check()) {
            $courses = Course::whereIn('school_id', auth('schooladmin')->user()->school_ids)->with('school')->where('deleted', true)->get();
        }
        $choose_fields = self::_getChooseFields($courses);

        return view('admin.course.deleted', compact('courses', 'choose_fields'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    function create()
    {
        $choose_languages = ChooseLanguage::all();
        $choose_study_times = ChooseStudyTime::all();
        $choose_study_modes = ChooseStudyMode::all();
        $choose_classes_days = ChooseClassesDay::all();
        $choose_start_days = ChooseStartDate::all();
        $choose_program_age_ranges = ChooseProgramAge::orderBy('age', 'asc')->get();
        $choose_program_types = ChooseProgramType::all();
        $currencies = CurrencyExchangeRate::all();
        $schools = School::where('is_active', true)->get();
        $choose_branches = [];
        $choose_schools = [];
        foreach ($schools as $school) {
            if (app()->getLocale() == 'en') {
                if ($school->branch_name) {
                    $choose_branches[] = $school->branch_name;
                }
                if ($school->name && $school->name->name) {
                    $choose_schools[] = $school->name->name;
                }
            } else {
                if ($school->branch_name_ar) {
                    $choose_branches[] = $school->branch_name_ar;
                }
                if ($school->name && $school->name->name_ar) {
                    $choose_schools[] = $school->name->name_ar;
                }
            }
        }
        $choose_schools = array_unique($choose_schools);

        \Session::has('program_ids') ? \Session::forget('program_ids') : '';
        \Session::has('accom_ids') ? \Session::forget('accom_ids') : '';
        \Session::has('has_accommodation') ? \Session::forget('has_accommodation') : '';

        return view('admin.course.add', compact('choose_schools', 'choose_languages', 'choose_study_times', 'choose_study_modes',
            'choose_classes_days', 'choose_start_days', 'choose_program_age_ranges', 'choose_program_types', 'choose_branches',
            'currencies'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    function store(Request $request)
    {
        $coursecreate = new CourseCreateService();
        if ($request->has('language')) {
            $coursecreate->createCourseAndProgram($request);
            if ($request->has('accommodation')) {
                Session::put('has_accommodation', $request->accommodation);
            }
        } else if ($request->has('underagefeeincrement')) {
            $coursecreate->createProgramUnderAgeAndTextBook($request);
        } elseif ($request->has('type')) {
            $coursecreate->createAccommodation($request);
        } elseif ($request->has('accomunderageincrement')) {
            $coursecreate->createAccommodationUnderAge($request);
        } elseif ($request->has('airportincrement')) {
            $coursecreate->createOtherServiceFee($request);
        }

        $data['data'] = 'Data Not Saved';
        $data['success'] = 'failed';
        if ($coursecreate->getGetError() == '') {
            $data['data'] = __('Admin/backend.data_saved_successfully');
            $data['success'] = 'success';
        } else {
            $data['errors'] = $coursecreate->getGetError();
        }

        return response()->json($data);
    }

    /**
     * @param $course_id
     * @return \Illuminate\Http\RedirectResponse
     */
    function delete($course_id)
    {
        $db = \DB::transaction(function() use ($course_id) {
            $course = Course::where('unique_id', $course_id)->first();
            $course->deleted = true;
            $course->save();
            return true;
        });
        if ($db) {
            toastr()->success(__('Admin/backend.data_removed_successfully'));
        }
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    function edit($id)
    {
        $choose_languages = ChooseLanguage::all();
        $choose_study_times = ChooseStudyTime::all();
        $choose_classes_days = ChooseClassesDay::all();
        $choose_start_days = ChooseStartDate::all();
        $choose_program_age_ranges = ChooseProgramAge::orderBy('age', 'asc')->get();
        $choose_study_modes = ChooseStudyMode::all();
        $choose_program_types = ChooseProgramType::all();
        $choose_branches = ChooseBranch::all();
        $currencies = CurrencyExchangeRate::all();

        $course = Course::whereUniqueId($id)->with('coursePrograms')->first();
        $schools = School::where('is_active', true)->get();
        $school_branches = [];
        $choose_schools = [];
        foreach ($schools as $school) {
            if (app()->getLocale() == 'en') {
                if ($school->branch_name) {
                    $school_branches[] = $school->branch_name;
                }
                if ($school->name && $school->name->name) {
                    $choose_schools[] = $school->name->name;
                }
            } else {
                if ($school->branch_name_ar) {
                    $school_branches[] = $school->branch_name_ar;
                }
                if ($school->name && $school->name->name_ar) {
                    $choose_schools[] = $school->name->name_ar;
                }
            }
        }
        $choose_schools = array_unique($choose_schools);
        $school = School::find($course->school_id);
        $school_name = '';
        if ($school) {
            if (app()->getLocale() == 'en') {
                if ($school->name && $school->name->name) {
                    $school_name = $school->name->name;
                }
            } else {
                if ($school->name && $school->name->name_ar) {
                    $school_name = $school->name->name_ar;
                }
            }
        }
        $country_ids = [$school->country_id];
        $city_ids = [$school->city_id];
        $same_name_schools = School::where('name_id', $school->name_id)->get();
        foreach ($same_name_schools as $same_name_school) {
            $country_ids[] = $same_name_school->country_id;
            $city_ids[] = $same_name_school->city_id;
        }
        $school_countries = Country::whereIn('id', $country_ids)->get();
        $school_cities = City::whereIn('id', $city_ids)->where('country_id', $course->country_id)->get();

        return view('admin.course.edit', compact('course', 'choose_schools', 'school', 'school_name', 'school_countries', 'school_cities', 'school_branches',
            'choose_languages', 'choose_study_times', 'choose_study_modes', 'choose_classes_days', 'choose_start_days', 'choose_program_age_ranges',
            'choose_program_types', 'choose_branches', 'currencies'));
    }

    /**
     * @param Request $request
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    function update(Request $request, $id = null)
    {
        $coursecreate = new CourseCreateService();
        if ($request->has('language')) {
            $coursecreate->updateCourseAndProgram($request, $id);
        } elseif ($request->has('underagefeeincrement')) {
            $coursecreate->updateProgramUnderAgeAndTextBook($request);
        } elseif ($request->has('type')) {
            $coursecreate->updateAccommodation($request, $id);
        } elseif ($request->has('accomunderageincrement')) {
            $coursecreate->updateAccommodationUnderAge($request, $id);
        } elseif ($request->has('airportincrement')) {
            $coursecreate->updateOtherServiceFee($request, $id);
        }

        $data['data'] = 'Data Not Saved';
        $data['success'] = 'failed';
        if ($coursecreate->getGetError() == '') {
            $data['data'] = __('Admin/backend.data_saved_successfully');
            $data['success'] = 'success';
        } else {
            $data['errors'] = $coursecreate->getGetError();
        }

        return response()->json($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function programSessionSave(Request $request)
    {
        \Session::push('program_cost_save', $request->all());
        $session = \Session::get('program_cost_save');
        
        return response($session);
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
            $course_ids = explode(",", $request_ids);
    
            foreach ($course_ids as $course_id) {
                if ($course_id) {
                    if ($request_action == "clone") {
                        $this->clone($course_id);
                    } else if ($request_action == "play") {
                        $this->play($course_id);
                    } else if ($request_action == "pause") {
                        $this->pause($course_id);
                    } else if ($request_action == "delete") {
                        $this->delete($course_id);
                    } else if ($request_action == "restore") {
                        $this->restore($course_id);
                    } else if ($request_action == "destroy") {
                        $this->destroy($course_id);
                    }
                }
            }
        }
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clone($course_id)
    {
        $coursecreate = new CourseCreateService();
        if ($coursecreate->cloneCourse($course_id)) {
            toastr()->success(__('Admin/backend.data_cloned_successfully'));
        }
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function pause($course_id)
    {
        $db = \DB::transaction(function() use ($course_id) {
            $course = Course::where('unique_id', $course_id)->first();
            if ($course) {
                $course->display = false;
                $course->save();
                return true;
            }
        });
        if ($db) {
            toastr()->success(__('Admin/backend.data_paused_successfully'));
        }
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function play($course_id)
    {
        $db = \DB::transaction(function() use ($course_id) {
            $course = Course::where('unique_id', $course_id)->first();
            if ($course) {
                $course->display = true;
                $course->save();
                return true;
            }
        });
        if ($db) {
            toastr()->success(__('Admin/backend.data_played_successfully'));
        }
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function promotion(Request $request, $course_id)
    {
        $promotion_enable = false;
        $db = \DB::transaction(function() use ($request, $course_id) {
            $course = Course::where('unique_id', '' . $course_id)->first();
            if ($course) {
                $promotion_enable = $course->promotion = ($request->promotion == 1 ? false: true);
                $course->save();
                return true;
            }
        });
        if ($db) {
            if ($promotion_enable) {
                toastr()->success(__('Admin/backend.course_enabled_promotion_successfully'));
            } else {
                toastr()->success(__('Admin/backend.course_disabled_promotion_successfully'));
            }
        }
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleLinkFee(Request $request, $course_id)
    {
        $link_fee_enable = false;
        $db = \DB::transaction(function() use ($request, $course_id) {
            $course = Course::where('unique_id', '' . $course_id)->first();
            if ($course) {
                $link_fee_enable = $course->link_fee_enable = ($request->link_fee == 1 ? false: true);
                $course->save();
                return true;
            }
        });
        if ($db) {
            if ($link_fee_enable) {
                toastr()->success(__('Admin/backend.course_enabled_link_fee_successfully'));
            } else {
                toastr()->success(__('Admin/backend.course_disabled_link_fee_successfully'));
            }
        }
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($course_id)
    {
        $db = \DB::transaction(function() use ($course_id) {
            $course = Course::where('unique_id', $course_id)->first();
            if ($course) {
                $course->deleted = false;
                $course->save();
                return true;
            }
        });
        if ($db) {
            toastr()->success(__('Admin/backend.data_restored_successfully'));
        }
        return back();
    }

    private function viewChooseList($type)
    {
        $title = '';
        $course_chooses = [];
        if ($type == 'language') {
            $title = __('Admin/backend.course_languages');
            $course_chooses = ChooseLanguage::orderBy('unique_id', 'asc')->get();
        } else if ($type == 'study_mode') {
            $title = __('Admin/backend.course_study_modes');
            $course_chooses = ChooseStudyMode::orderBy('unique_id', 'asc')->get();
        } else if ($type == 'program_type') {
            $title = __('Admin/backend.course_program_types');
            $course_chooses = ChooseProgramType::orderBy('unique_id', 'asc')->get();
        } else if ($type == 'branch') {
            $title = __('Admin/backend.course_banches');
            $course_chooses = ChooseBranch::orderBy('unique_id', 'asc')->get();
        } else if ($type == 'study_time') {
            $title = __('Admin/backend.course_study_times');
            $course_chooses = ChooseStudyTime::orderBy('unique_id', 'asc')->get();
        } else if ($type == 'classes_day') {
            $title = __('Admin/backend.course_classes_days');
            $course_chooses = ChooseClassesDay::orderBy('unique_id', 'asc')->get();
        } else if ($type == 'start_date') {
            $title = __('Admin/backend.course_start_dates');
            $course_chooses = ChooseStartDate::orderBy('unique_id', 'asc')->get();
        }
        foreach ($course_chooses as $course_choose) {
            $choose_value_courses = Course::get()->collect()->values()->filter(function($value) use ($type, $course_choose) {
                return in_array($course_choose->unique_id, $value[$type] ?? []);
            })->all();
            if ($choose_value_courses && count($choose_value_courses)) {
                $course_choose->can_delete = false;
            } else {
                $course_choose->can_delete = true;
            }
        }

        return view('admin.course.choose', compact('type', 'title', 'course_chooses'));
    }

    public function viewLanguageList()
    {
        return $this->viewChooseList('language');
    }

    public function viewStudyModeList()
    {
        return $this->viewChooseList('study_mode');
    }

    public function viewProgramTypeList()
    {
        return $this->viewChooseList('program_type');
    }

    public function viewBranchList()
    {
        return $this->viewChooseList('branch');
    }

    public function viewStudyTimeList()
    {
        return $this->viewChooseList('study_time');
    }

    public function viewClassesDayList()
    {
        return $this->viewChooseList('classes_day');
    }

    public function viewStartDateList()
    {
        return $this->viewChooseList('start_date');
    }

    private function viewChooseAgeList($type)
    {
        $title = '';
        $course_choose_ages = [];
        if ($course_choose_age_type == 'program_age') {
            $title = __('Admin/backend.course_program_ages');
            $course_choose_ages = ChooseProgramAge::orderBy('unique_id', 'asc')->get();
            foreach ($course_choose_ages as $course_choose_age) {
                $choose_age_value_courses = CourseProgram::get()->collect()->values()->filter(function($value) use ($course_choose_age) {
                    return in_array($course_choose_age->unique_id, $value['program_age_range'] ?? []);
                })->all();
                if ($choose_age_value_courses && count($choose_age_value_courses)) {
                    $course_choose_age->can_delete = false;
                } else {
                    $course_choose_age->can_delete = true;
                }
            }
        } else if ($course_choose_age_type == 'program_under_age') {
            $title = __('Admin/backend.course_program_under_ages');
            $course_choose_ages = ChooseProgramUnderAge::orderBy('unique_id', 'asc')->get();
            foreach ($course_choose_ages as $course_choose_age) {
                $choose_age_value_courses = CourseProgramUnderAgeFee::get()->collect()->values()->filter(function($value) use ($course_choose_age) {
                    return in_array($course_choose_age->unique_id, $value['under_age'] ?? []);
                })->all();
                if ($choose_age_value_courses && count($choose_age_value_courses)) {
                    $course_choose_age->can_delete = false;
                } else {
                    $course_choose_age->can_delete = true;
                }
            }
        } else if ($course_choose_age_type == 'accommodation_age') {
            $title = __('Admin/backend.accommodation_ages');
            $course_choose_ages = ChooseAccommodationAge::orderBy('unique_id', 'asc')->get();
            foreach ($course_choose_ages as $course_choose_age) {
                $choose_age_value_courses = CourseAccommodation::get()->collect()->values()->filter(function($value) use ($course_choose_age) {
                    return in_array($course_choose_age->unique_id, $value['age_range'] ?? []);
                })->all();
                if ($choose_age_value_courses && count($choose_age_value_courses)) {
                    $course_choose_age->can_delete = false;
                } else {
                    $course_choose_age->can_delete = true;
                }
            }
        } else if ($course_choose_age_type == 'accommodation_under_age') {
            $title = __('Admin/backend.accommodation_under_ages');
            $course_choose_ages = ChooseAccommodationUnderAge::orderBy('unique_id', 'asc')->get();
            foreach ($course_choose_ages as $course_choose_age) {
                $choose_age_value_courses = CourseAccommodationUnderAge::get()->collect()->values()->filter(function($value) use ($course_choose_age) {
                    return in_array($course_choose_age->unique_id, $value['under_age'] ?? []);
                })->all();
                if ($choose_age_value_courses && count($choose_age_value_courses)) {
                    $course_choose_age->can_delete = false;
                } else {
                    $course_choose_age->can_delete = true;
                }
            }
        } else if ($course_choose_age_type == 'custodian_under_age') {
            $title = __('Admin/backend.custodian_under_ages');
            $course_choose_ages = ChooseCustodianUnderAge::orderBy('unique_id', 'asc')->get();
            foreach ($course_choose_ages as $course_choose_age) {
                $choose_age_value_courses = CourseCustodian::get()->collect()->values()->filter(function($value) use ($course_choose_age) {
                    return in_array($course_choose_age->unique_id, $value['age_range'] ?? []);
                })->all();
                if ($choose_age_value_courses && count($choose_age_value_courses)) {
                    $course_choose_age->can_delete = false;
                } else {
                    $course_choose_age->can_delete = true;
                }
            }
        }

        return view('admin.course.choose_age', compact('type', 'title', 'course_choose_ages'));
    }

    public function viewProgramAgeList()
    {
        return $this->viewChooseAgeList('program_age');
    }

    public function viewProgramUnderAgeList()
    {
        return $this->viewChooseAgeList('program_age');
    }

    public function viewAccommodationAgeList()
    {
        return $this->viewChooseAgeList('accommodation_age');
    }

    public function viewAccommodationUnderAgeList()
    {
        return $this->viewChooseAgeList('accommodation_under_age');
    }

    public function viewCustodianUnderAgeList()
    {
        return $this->viewChooseAgeList('custodian_under_age');
    }

    public function updateChooseList(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'name.*' => 'required',
                'name.*' => 'required',
                'course_choose_type.*' => 'required',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        
        $choose_ids = [];

        $course_choose_type = $request->course_choose_type;
        $CourseChoose = '';
        if ($course_choose_type == 'language') {
            $CourseChoose = '\App\Models\ChooseLanguage';
        } else if ($course_choose_type == 'study_mode') {
            $CourseChoose = '\App\Models\ChooseStudyMode';
        } else if ($course_choose_type == 'program_type') {
            $CourseChoose = '\App\Models\ChooseProgramType';
        } else if ($course_choose_type == 'branch') {
            $CourseChoose = '\App\Models\ChooseBranch';
        } else if ($course_choose_type == 'study_time') {
            $CourseChoose = '\App\Models\ChooseStudyTime';
        } else if ($course_choose_type == 'classes_day') {
            $CourseChoose = '\App\Models\ChooseClassesDay';
        } else if ($course_choose_type == 'start_date') {
            $CourseChoose = '\App\Models\ChooseStartDate';
        }

        for ($i = 0; $i <= $request->course_choose_increment; $i++) {
            $course_choose = null;
            if (isset($request->choose_id[$i]) && $request->choose_id[$i]) {
                $course_choose = $CourseChoose::where('unique_id', $request->choose_id[$i])->first();
            }
            if (!$course_choose) {
                $course_choose = new $CourseChoose();
            }
            $course_choose->name = $request->name[$i] ?? null;
            $course_choose->name_ar = $request->name_ar[$i] ?? null;
            $course_choose->save();
            if (!$course_choose->unique_id) {
                $choose_id = $CourseChoose::orderBy('unique_id', 'desc')->first()->unique_id;
            } else {
                $choose_id = $course_choose->unique_id;
            }
            $choose_ids[] = $choose_id;
        }
        $course_chooses = $CourseChoose::all();
        $message_append = '';
        foreach ($course_chooses as $course_choose) {
            if (!in_array($course_choose->unique_id, $choose_ids)) {
                $choose_courses = Course::get()->collect()->values()->filter(function($value) use ($course_choose_type, $course_choose) {
                    return in_array($course_choose->unique_id, $value[$course_choose_type] ?? []);
                })->all();
                if ($choose_courses && count($choose_courses)) {
                    $message_append = $message_append . ($message_append ? ', ' : '') . '"' . (app()->getLocale() == 'en' ? $course_choose->name : $course_choose->name_ar). '"';
                } else {
                    $course_choose->delete();
                }
            }
        }
        
        $data['success'] = true;
        $data['data'] = __('Admin/backend.data_saved_successfully') . ($message_append ? ' ' . $message_append . ' ' . __('Admin/backend.data_can_not_delete') : '');

        return response()->json($data);
    }

    public function updateChooseAgeList(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'age.*' => 'required',
                'age.*' => 'required',
                'course_choose_age_type.*' => 'required',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        
        $course_choose_age_ids = [];

        $course_choose_age_type = $request->course_choose_age_type;
        $CourseChooseAge = '';
        if ($course_choose_age_type == 'program_age') {
            $CourseChooseAge = '\App\Models\ChooseProgramAge';
        } else if ($course_choose_age_type == 'program_under_age') {
            $CourseChooseAge = '\App\Models\ChooseProgramUnderAge';
        } else if ($course_choose_age_type == 'accommodation_age') {
            $CourseChooseAge = '\App\Models\ChooseAccommodationAge';
        } else if ($course_choose_age_type == 'accommodation_under_age') {
            $CourseChooseAge = '\App\Models\ChooseAccommodationUnderAge';
        } else if ($course_choose_age_type == 'custodian_under_age') {
            $CourseChooseAge = '\App\Models\ChooseCustodianUnderAge';
        }

        for ($i = 0; $i <= $request->course_choose_age_increment; $i++) {
            $course_choose_age = null;
            if (isset($request->choose_id[$i]) && $request->choose_id[$i]) {
                $course_choose_age = $CourseChooseAge::where('unique_id', $request->choose_id[$i])->first();
            }
            if (!$course_choose_age) {
                $course_choose_age = new $CourseChooseAge;
            }
            $course_choose_age->age = $request->age[$i] ?? null;
            $course_choose_age->age_ar = $request->age_ar[$i] ?? null;
            $course_choose_age->save();
            if (!$course_choose_age->unique_id) {
                $course_choose_age_id = $CourseChooseAge::orderBy('unique_id', 'desc')->first()->unique_id;
            } else {
                $course_choose_age_id = $course_choose_age->unique_id;
            }
            $course_choose_age_ids[] = $course_choose_age_id;
        }
        $course_choose_ages = $CourseChooseAge::all();
        foreach ($course_choose_ages as $course_choose_age) {
            if (!in_array($course_choose_age->unique_id, $course_choose_age_ids)) {
                $choose_age_courses = [];
                if ($course_choose_age_type == 'program_age') {
                    $choose_age_courses = CourseProgram::get()->collect()->values()->filter(function($value) use ($course_choose_age) {
                        return in_array($course_choose_age->unique_id, $value['program_age_range'] ?? []);
                    })->all();
                } else if ($course_choose_age_type == 'program_under_age') {
                    $choose_age_courses = CourseProgramUnderAgeFee::get()->collect()->values()->filter(function($value) use ($course_choose_age) {
                        return in_array($course_choose_age->unique_id, $value['under_age'] ?? []);
                    })->all();
                } else if ($course_choose_age_type == 'accommodation_age') {
                    $choose_age_courses = CourseAccommodation::get()->collect()->values()->filter(function($value) use ($course_choose_age) {
                        return in_array($course_choose_age->unique_id, $value['age_range'] ?? []);
                    })->all();
                } else if ($course_choose_age_type == 'accommodation_under_age') {
                    $choose_age_courses = CourseAccommodationUnderAge::get()->collect()->values()->filter(function($value) use ($course_choose_age) {
                        return in_array($course_choose_age->unique_id, $value['under_age'] ?? []);
                    })->all();
                } else if ($course_choose_age_type == 'custodian_under_age') {
                    $choose_age_courses = CourseCustodian::get()->collect()->values()->filter(function($value) use ($course_choose_age) {
                        return in_array($course_choose_age->unique_id, $value['age_range'] ?? []);
                    })->all();
                }
                if ($choose_courses && count($choose_courses)) {
                    $message_append = $message_append . ($message_append ? ', ' : '') . '"' . (app()->getLocale() == 'en' ? $course_choose->name : $course_choose->name_ar) . '"';
                } else {
                    $course_choose->delete();
                }
                $course_choose_age->delete();
            }
        }
        
        $data['success'] = true;
        $data['data'] = __('Admin/backend.data_saved_successfully') . ($message_append ? ' ' . $message_append . ' ' . __('Admin/backend.data_can_not_delete') : '');

        return response()->json($data);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $db = \DB::transaction(function() use ($id) {
            $course = Course::where('unique_id', $id)->first();
            if ($course) {
                $course->coursePrograms()->delete();
                $course->accomodations()->delete();
                $course->airports()->delete();
                $course->medicals()->delete();
                $course->custodians()->delete();
                Course::where('unique_id', $id)->delete();
                return true;
            }
        });
        if ($db) {
            toastr()->success(__('Admin/backend.data_removed_successfully'));
        }
        return back();
    }

    public function viewProgramUnderAge()
    {
        $course_id = \Session::get('course_id');
        $course_programs = [];
        $course_programs = CourseProgram::whereIn('unique_id', is_array(\Session::get('program_ids')) ? \Session::get('program_ids') : [])->get();
        $choose_program_under_ages = ChooseProgramUnderAge::orderBy('age', 'asc')->get()->collect()->unique('age')->values()->all();
        $has_accommodation = !\Session::has('has_accommodation') || (\Session::has('has_accommodation') && \Session::get('has_accommodation') == 'yes');

        return view('admin.course.add.program_under_age', compact('course_id', 'course_programs', 'choose_program_under_ages', 'has_accommodation'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function editProgramUnderAge()
    {
        if (!\Session::has('program_ids') && !\Session::has("program_id")) {
            return back();
        }

        if (\Session::get('course_id')) {
            $course_id = \Session::get('course_id');

            $program_under_age_fees = [];
            $program_text_book_fees = [];
            if (\Session::has('program_id')) {
                $course_program_id = \Session::get('program_id');
                $course_programs = CourseProgram::where('course_unique_id', $course_id)->get();
                $program_under_age_fees = CourseProgramUnderAgeFee::where('course_program_id', \Session::get('program_id'))->get();
                $program_text_book_fees = CourseProgramTextBookFee::where('course_program_id', \Session::get('program_id'))->get();
            } else if (\Session::has('program_ids')) {
                $course_programs = CourseProgram::whereIn('unique_id', \Session::get('program_ids'))->get();
                if (!empty($course_programs) && count($course_programs)) {
                    $course_program_id = '' . $course_programs[0]->unique_id;
                    $program_under_age_fees = CourseProgramUnderAgeFee::where('course_program_id', $course_program_id)->get();
                    $program_text_book_fees = CourseProgramTextBookFee::where('course_program_id', $course_program_id)->get();
                }
            }
            if (!empty($course_programs) && count($course_programs)) {
                $choose_program_under_ages = ChooseProgramUnderAge::orderBy('age', 'asc')->get()->collect()->unique('age')->values()->all();
        
                return view('admin.course.edit.program_under_age', compact('course_id', 'course_program_id', 'course_programs', 'program_under_age_fees', 'program_text_book_fees', 'choose_program_under_ages'));
            } else {
                if (auth('superadmin')->check()) {
                    return redirect()->route('superadmin.course.program_under_age');
                } else if (auth('schooladmin')->check()) {
                    return redirect()->route('schooladmin.course.program_under_age');
                }
            }
        } else {
            if (auth('superadmin')->check()) {
                return redirect()->route('superadmin.course.create');
            } else if (auth('schooladmin')->check()) {
                return redirect()->route('schooladmin.course.create');
            }
        }
    }

    public function viewAccommodation()
    {
        $course_id = \Session::get('course_id');
        $accommodation_age_ranges = ChooseAccommodationAge::orderBy('age', 'asc')->get()->collect()->unique('age')->values()->all();

        return view('admin.course.add.accommodation', compact('course_id', 'accommodation_age_ranges'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function editAccommodation()
    {
        \Session::forget('accom_id');
        \Session::forget('accom_ids');

        if (\Session::get('course_id')) {
            $course_id = \Session::get('course_id');
            
            $accomodations = CourseAccommodation::where('course_unique_id', '' . \Session::get('course_id'))->orderBy('order', 'asc')->get();
            if (count($accomodations)) {
                foreach($accomodations as $accom) {
                    \Session::push('accom_ids', '' . $accom->unique_id);
                }
                
                $accommodation_age_ranges = ChooseAccommodationAge::orderBy('age', 'asc')->get()->collect()->unique('age')->values()->all();

                return view('admin.course.edit.accommodation', compact('course_id', 'accomodations', 'accommodation_age_ranges'));
            } else {
                if (auth('superadmin')->check()) {
                    return redirect()->route('superadmin.course.accommodation');
                } else if (auth('schooladmin')->check()) {
                    return redirect()->route('schooladmin.course.accommodation');
                }
            }
        } else {
            if (auth('superadmin')->check()) {
                return redirect()->route('superadmin.course.create');
            } else if (auth('schooladmin')->check()) {
                return redirect()->route('schooladmin.course.create');
            }
        }
    }

    public function viewAccommodationUnderAge()
    {
        $course_id = \Session::get('course_id');
        $accomodations = [];
        if (\Session::get('accom_ids')) {
            $accomodations = CourseAccommodation::whereIn('unique_id', \Session::get('accom_ids'))->get();
        }
        $choose_accomodation_under_ages = ChooseAccommodationUnderAge::orderBy('age', 'asc')->get()->collect()->unique('age')->values()->all();
        return view('admin.course.add.accommodation_under_age', compact('course_id', 'accomodations', 'choose_accomodation_under_ages'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function editAccommodationUnderAge()
    {
        if (!\Session::has('accom_ids') && !\Session::has("accom_id")) {
            return back();
        }

        if (\Session::get('course_id')) {
            $course_id = \Session::get('course_id');

            $accomodation_under_age = null;
            $accomodation_under_ages = [];
            if (\Session::has('accom_id')) {
                $accom_id = \Session::get('accom_id');
                $accomodations = CourseAccommodation::where('course_unique_id', $course_id)->get();
                $accomodation_under_ages = CourseAccommodationUnderAge::where('accom_id', $accomodation_under_age->accom_id)->get();
            } else if (\Session::has('accom_ids')) {
                $accomodations = CourseAccommodation::whereIn('unique_id', \Session::get('accom_ids'))->get();
                if (!empty($accomodations) && count($accomodations)) {
                    $accom_id = '' . $accomodations[0]->unique_id;
                    $accomodation_under_ages = CourseAccommodationUnderAge::where('accom_id', $accom_id)->get();
                }
            }
            if (!empty($accomodations) && count($accomodations)) {
                $choose_accomodation_under_ages = ChooseAccommodationUnderAge::orderBy('age', 'asc')->get()->collect()->unique('age')->values()->all();
        
                return view('admin.course.edit.accommodation_under_age', compact('course_id', 'accom_id', 'accomodations', 'accomodation_under_ages', 'choose_accomodation_under_ages'));
            } else {
                if (auth('superadmin')->check()) {
                    return redirect()->route('superadmin.course.accommodation_under_age');
                } else if (auth('schooladmin')->check()) {
                    return redirect()->route('schooladmin.course.accommodation_under_age');
                }
            }
        } else {
            if (auth('superadmin')->check()) {
                return redirect()->route('superadmin.course.create');
            } else if (auth('schooladmin')->check()) {
                return redirect()->route('schooladmin.course.create');
            }
        }
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function viewOtherService()
    {
        $custodian_under_ages = ChooseCustodianUnderAge::orderBy('age', 'asc')->get()->collect()->unique('age')->values()->all();
        return view('admin.course.add.other_service', compact('custodian_under_ages'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function editOtherService()
    {
        if (\Session::get('course_id')) {
            $course_id = \Session::get('course_id');
            $custodian_under_ages = ChooseCustodianUnderAge::orderBy('age', 'asc')->get()->collect()->unique('age')->values()->all();
            $airports = CourseAirport::with('fees')->where('course_unique_id', $course_id)->get();
            $medicals = CourseMedical::with('fees')->where('course_unique_id', $course_id)->get();
            $custodians = CourseCustodian::where('course_unique_id', $course_id)->get();

            if ((!empty($airports) && count($airports)) || (!empty($medicals) && count($medicals)) || (!empty($custodians) && count($custodians))) {
                return view('admin.course.edit.other_service', compact('course_id', 'custodian_under_ages', 'airports', 'medicals', 'custodians'));
            } else {
                if (auth('superadmin')->check()) {
                    return redirect()->route('superadmin.course.other_service');
                } else if (auth('schooladmin')->check()) {
                    return redirect()->route('schooladmin.course.other_service');
                }
            }
        } else {
            if (auth('superadmin')->check()) {
                return redirect()->route('superadmin.course.index');
            } else if (auth('schooladmin')->check()) {
                return redirect()->route('schooladmin.course.index');
            }
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function fetchProgramUnderAgePage(Request $request)
    {
        \Session::put('program_id', '' . $request->value);

        if (auth('superadmin')->check()) {
            $data['url'] = route('superadmin.course.program_under_age.edit');
        } else if (auth('schooladmin')->check()) {
            $data['url'] = route('schooladmin.course.program_under_age.edit');
        }

        return response($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function fetchAccommodationUnderAgePage(Request $request)
    {
        \Session::put('accom_id', '' . $request->value);

        if (auth('superadmin')->check()) {
            $data['url'] = route('superadmin.course.accomm_under_age.edit');
        } else if (auth('schooladmin')->check()) {
            $data['url'] = route('schooladmin.course.accomm_under_age.edit');
        }

        return response($data);
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
            file_put_contents(public_path('images/course_images/' .$fileName), $interventionImage);
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('public/images/course_images/' . $fileName);
            $msg = 'Image uploaded successfully';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            @header('Content-type: text/html; charset=utf-8');
            return $response;
        }
    }

    public function listForCustomer($customer_id) {
        $course_ids = CourseApplication::where('user_id', $customer_id)->pluck('course_id')->toArray();
        $courses = Course::with('school')->where('deleted', false)->whereIn('unique_id', $course_ids)->get();
        $choose_fields = self::_getChooseFields($courses);

        return view('admin.course.index', compact('courses', 'choose_fields'));
    }
}