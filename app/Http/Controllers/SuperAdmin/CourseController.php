<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\SuperAdmin\CourseProgramTextBookFee;

use App\Models\SuperAdmin\Course;
use App\Models\SuperAdmin\School;
use App\Models\SuperAdmin\CourseAirport;
use App\Models\SuperAdmin\CourseAccommodation;
use App\Models\SuperAdmin\CourseProgram;
use App\Models\SuperAdmin\CourseMedical;
use App\Models\SuperAdmin\CourseProgramUnderAgeFee;
use App\Models\SuperAdmin\CourseAccommodationUnderAge;

use App\Models\SuperAdmin\Choose_Accommodation_Age_Range;
use App\Models\SuperAdmin\Choose_Accommodation_Under_Age;
use App\Models\SuperAdmin\Choose_Branch;
use App\Models\SuperAdmin\Choose_Classes_Day;
use App\Models\SuperAdmin\Choose_Custodian_Under_Age;
use App\Models\SuperAdmin\Choose_Language;
use App\Models\SuperAdmin\Choose_Program_Age_Range;
use App\Models\SuperAdmin\Choose_Program_Type;
use App\Models\SuperAdmin\Choose_Program_Under_Age;
use App\Models\SuperAdmin\Choose_Start_Day;
use App\Models\SuperAdmin\Choose_Study_Mode;
use App\Models\SuperAdmin\Choose_Study_Time;

use App\Models\SuperAdmin\CurrencyExchangeRate;

use App\Services\CourseCreateService;

use Illuminate\Http\Request;

use Session;

class CourseController extends Controller
{
    function _getChooseFields($courses)
    {
        $choose_fields = [
            'languages' => [],
            'program_types' => [],
            'study_modes' => [],
            'school_names' => [],
            'school_cities' => [],
            'school_countries' => [],
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

            if (get_language() == 'en') {
                if ($course->school->name) {
                    if (!in_array($course->school->name, $choose_fields['school_names'])) {
                        array_push($choose_fields['school_names'], $course->school->name);
                    }
                } else {
                    if (!in_array('-', $choose_fields['school_names'])) {
                        array_push($choose_fields['school_names'], '-');
                    }
                }
            } else {
                if ($course->school->name_ar) {
                    if (!in_array($course->school->name_ar, $choose_fields['school_names'])) {
                        array_push($choose_fields['school_names'], $course->school->name_ar);
                    }
                } else {
                    if (!in_array('-', $choose_fields['school_names'])) {
                        array_push($choose_fields['school_names'], '-');
                    }
                }
            }

            if ($course->city) {
                if (!in_array($course->city, $choose_fields['school_cities'])) {
                    array_push($choose_fields['school_cities'], $course->city);
                }
            } else {
                if (!in_array('-', $choose_fields['school_cities'])) {
                    array_push($choose_fields['school_cities'], '-');
                }
            }

            if ($course->country) {
                if (!in_array($course->country, $choose_fields['school_countries'])) {
                    array_push($choose_fields['school_countries'], $course->country);
                }
            } else {
                if (!in_array('-', $choose_fields['school_countries'])) {
                    array_push($choose_fields['school_countries'], '-');
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
                if (!in_array($course->getCurrency->name, $choose_fields['currencies'])) {
                    array_push($choose_fields['currencies'], $course->getCurrency->name);
                }
            } else {
                if (!in_array('-', $choose_fields['currencies'])) {
                    array_push($choose_fields['currencies'], '-');
                }
            }
        }
        $choose_fields['languages'] = Choose_Language::whereIn('unique_id', $choose_fields['languages'])->pluck('name')->toArray();
        $choose_fields['program_types'] = Choose_Program_Type::whereIn('unique_id', $choose_fields['program_types'])->pluck('name')->toArray();
        $choose_fields['study_modes'] = Choose_Study_Mode::whereIn('unique_id', $choose_fields['study_modes'])->pluck('name')->toArray();
        $choose_fields['branch_names'] = Choose_Branch::whereIn('unique_id', $choose_fields['branch_names'])->pluck('name')->toArray();
        
        return $choose_fields;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    function index()
    {
        $courses = Course::with('school')->where('deleted', false)->get();
        $choose_fields = self::_getChooseFields($courses);

        return view('superadmin.courses.index', compact('courses', 'choose_fields'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    function deleted()
    {
        $courses = Course::with('school')->where('deleted', true)->get();
        $choose_fields = self::_getChooseFields($courses);

        return view('superadmin.courses.deleted', compact('courses', 'choose_fields'));
    }

    /**
     * @param Request $r
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    function getSchoolCountryList(Request $r)
    {
        $school = School::find($r->id);
        $country_list = "<option value=''>" . __('SuperAdmin/backend.select_option') . "</option>";
        foreach ($school->getCountries() as $country) {
            if ($country) $country_list .= "<option value='$country'>$country</option>";
        }

        return response($country_list);
    }

    /**
     * @param Request $r
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    function getSchoolCityList(Request $r)
    {
        $school = School::find($r->id);
        $city_list  = "<option value=''>" . __('SuperAdmin/backend.select_option') . "</option>";
        foreach ($school->getCitiesByCountry($r->country) as $city) {
            if ($city) $city_list .= "<option value='$city'>$city</option>";
        }

        return response($city_list);
    }

    /**
     * @param Request $r
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    function getSchoolBranchList(Request $r)
    {
        $school = School::find($r->id);
        $branch_list = "<option value=''>" . __('SuperAdmin/backend.select_option') . "</option>";
        foreach ($school->getBranchesByCountryCity($r->country, $r->city) as $branch) {
            if ($branch) $branch_list .= "<option value='$branch'>$branch</option>";
        }

        return response($branch_list);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    function create()
    {
        $schools = School::all()->unique('name')->values()->all();

        $choose_languages = Choose_Language::all();
        $choose_study_times = Choose_Study_Time::all();
        $choose_study_modes = Choose_Study_Mode::all();
        $choose_classes_days = Choose_Classes_Day::all();
        $choose_start_days = Choose_Start_Day::all();
        $choose_program_age_ranges = Choose_Program_Age_Range::orderBy('age', 'asc')->get();
        $choose_program_types = Choose_Program_Type::all();
        $choose_branches = Choose_Branch::all();
        $currencies = CurrencyExchangeRate::all();

        \Session::has('program_ids') ? \Session::forget('program_ids') : '';
        \Session::has('accom_ids') ? \Session::forget('accom_ids') : '';
        \Session::has('has_accommodation') ? \Session::forget('has_accommodation') : '';

        return view('superadmin.courses.add', compact('schools', 'choose_languages', 'choose_study_times', 'choose_study_modes',
            'choose_classes_days', 'choose_start_days', 'choose_program_age_ranges', 'choose_program_types', 'choose_branches',
            'currencies'));
    }

    /**
     * @param Request $r
     * @return \Illuminate\Http\JsonResponse
     */
    function store(Request $r)
    {
        $coursecreate = new CourseCreateService();
        if ($r->has('language')) {
            $coursecreate->createCourseAndProgram($r);
            if ($r->has('accommodation')) {
                Session::put('has_accommodation', $r->accommodation);
            }
        } else if ($r->has('underagefeeincrement')) {
            $coursecreate->createProgramUnderAgeAndTextBook($r);
        } elseif ($r->has('type')) {
            $coursecreate->createAccommodation($r);
        } elseif ($r->has('accomunderageincrement')) {
            $coursecreate->createAccommodationUnderAge($r);
        } elseif ($r->has('airportincrement')) {
            $coursecreate->createAirportMedicalFee($r);
        }

        $data['data'] = 'Data Not Saved';
        $data['success'] = 'failed';
        if ($coursecreate->getGetError() == '') {
            $data['data'] = 'Data Saved Successfully';
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
            toastr()->success(__('SuperAdmin/backend.data_removed_successfully'));
        }
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    function edit($id)
    {
        $schools = School::all()->unique('name')->values()->all();

        $choose_languages = Choose_Language::all();
        $choose_study_times = Choose_Study_Time::all();
        $choose_classes_days = Choose_Classes_Day::all();
        $choose_start_days = Choose_Start_Day::all();
        $choose_program_age_ranges = Choose_Program_Age_Range::orderBy('age', 'asc')->get();
        $choose_study_modes = Choose_Study_Mode::all();
        $choose_program_types = Choose_Program_Type::all();
        $choose_branches = Choose_Branch::all();
        $currencies = CurrencyExchangeRate::all();

        $course = Course::whereUniqueId($id)->with('coursePrograms')->first();
        $school = School::find($course->school_id);
        $school_countries = $school->getCityCountryState()->getCountry();
        $school_cities = $school->getCitiesByCountry($course->country);
        $school_branches = $school->getBranchesByCountryCity($course->country, $course->city);

        return view('superadmin.courses.edit', compact('course', 'schools', 'school', 'school_countries', 'school_cities', 'school_branches',
            'choose_languages', 'choose_study_times', 'choose_study_modes', 'choose_classes_days', 'choose_start_days', 'choose_program_age_ranges',
            'choose_program_types', 'choose_branches', 'currencies'));
    }

    /**
     * @param Request $r
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    function update(Request $r, $id = null)
    {
        $coursecreate = new CourseCreateService();
        if ($r->has('language')) {
            $coursecreate->updateCourseAndProgram($r, $id);
        } elseif ($r->has('underagefeeincrement')) {
            $coursecreate->updateProgramUnderAgeAndTextBook($r);
        } elseif ($r->has('type')) {
            $coursecreate->updateAccommodation($r, $id);
        } elseif ($r->has('accomunderageincrement')) {
            $coursecreate->updateAccommodationUnderAge($r, $id);
        } elseif ($r->has('airportincrement')) {
            $coursecreate->updateAirportMedicalFee($r, $id);
        }

        $data['data'] = 'Data Not Saved';
        $data['success'] = 'failed';
        if ($coursecreate->getGetError() == '') {
            $data['data'] = 'Data Saved Successfully';
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
    public function bulk(Request $r)
    {
        $request_action = $r->action;
        $request_ids = $r->ids;
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
            toastr()->success(__('SuperAdmin/backend.data_cloned_successfully'));
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
            toastr()->success(__('SuperAdmin/backend.data_paused_successfully'));
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
            toastr()->success(__('SuperAdmin/backend.data_played_successfully'));
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
            toastr()->success(__('SuperAdmin/backend.data_removed_successfully'));
        }
        return back();
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
                Course::where('unique_id', $id)->delete();
                return true;
            }
        });
        if ($db) {
            toastr()->success(__('SuperAdmin/backend.data_removed_successfully'));
        }
        return back();
    }

    public function programUnderAge()
    {
        $course_id = \Session::get('course_id');
        $course_programs = [];
        $course_programs = CourseProgram::whereIn('unique_id', is_array(\Session::get('program_ids')) ? \Session::get('program_ids') : [])->get();
        $choose_program_under_ages = Choose_Program_Under_Age::orderBy('age', 'asc')->get()->collect()->unique('age')->values()->all();
        $has_accommodation = !\Session::has('has_accommodation') || (\Session::has('has_accommodation') && \Session::get('has_accommodation') == 'yes');

        return view('superadmin.courses.add.program_under_age', compact('course_id','course_programs','choose_program_under_ages','has_accommodation'));
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
                $choose_program_under_ages = Choose_Program_Under_Age::orderBy('age', 'asc')->get()->collect()->unique('age')->values()->all();
        
                return view('superadmin.courses.edit.program_under_age', compact('course_id','course_program_id','course_programs','program_under_age_fees','program_text_book_fees','choose_program_under_ages'));
            } else {
                return redirect()->route('superadmin.course.program_under_age');
            }
        } else {
            return redirect()->route('superadmin.course.create');
        }
    }

    public function accommodation()
    {
        $course_id = \Session::get('course_id');
        $custodian_under_ages = Choose_Custodian_Under_Age::orderBy('age', 'asc')->get()->collect()->unique('age')->values()->all();
        $accommodation_age_ranges = Choose_Accommodation_Age_Range::orderBy('age', 'asc')->get()->collect()->unique('age')->values()->all();

        return view('superadmin.courses.add.accommodation', compact('course_id','custodian_under_ages','accommodation_age_ranges'));
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
            
            $accomodations = CourseAccommodation::where('course_unique_id', '' . \Session::get('course_id'))->get();
            if (count($accomodations)) {
                foreach($accomodations as $accom) {
                    \Session::push('accom_ids', '' . $accom->unique_id);
                }
                
                $custodian_under_ages = Choose_Custodian_Under_Age::orderBy('age', 'asc')->get()->collect()->unique('age')->values()->all();
                $accommodation_age_ranges = Choose_Accommodation_Age_Range::orderBy('age', 'asc')->get()->collect()->unique('age')->values()->all();

                return view('superadmin.courses.edit.accommodation', compact('course_id','accomodations','custodian_under_ages','accommodation_age_ranges'));
            } else {
                return redirect()->route('superadmin.course.accommodation');
            }
        } else {
            return redirect()->route('superadmin.course.create');
        }
    }

    public function accommodationUnderAge()
    {
        $course_id = \Session::get('course_id');
        $accomodations = CourseAccommodation::whereIn('unique_id', \Session::get('accom_ids'))->get();
        $choose_accomodation_under_ages = Choose_Accommodation_Under_Age::orderBy('age', 'asc')->get()->collect()->unique('age')->values()->all();
        return view('superadmin.courses.add.accommodation_under_age', compact('course_id','accomodations','choose_accomodation_under_ages'));
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
                $choose_accomodation_under_ages = Choose_Accommodation_Under_Age::orderBy('age', 'asc')->get()->collect()->unique('age')->values()->all();
        
                return view('superadmin.courses.edit.accommodation_under_age', compact('course_id','accom_id','accomodations','accomodation_under_ages','choose_accomodation_under_ages'));
            } else {
                return redirect()->route('superadmin.course.accommodation_under_age');
            }
        } else {
            return redirect()->route('superadmin.course.create');
        }
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function airportMedical()
    {
        return view('superadmin.courses.add.airport_medical');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function editAirportMedical()
    {
        if (\Session::get('course_id')) {
            $course_id = \Session::get('course_id');
            $airports = CourseAirport::with('fees')->where('course_unique_id', $course_id)->get();
            $medicals = CourseMedical::with('fees')->where('course_unique_id', $course_id)->get();

            if (!empty($airports) && count($airports) && !empty($medicals) && count($medicals)) {
                return view('superadmin.courses.edit.airport_medical', compact('course_id','airports','medicals'));
            } else {
                return redirect()->route('superadmin.course.airport_medical');
            }
        } else {
            return redirect()->route('superadmin.course.index');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function fetchProgramUnderAgePage(Request $request)
    {
        \Session::put('program_id', '' . $request->value);

        $data['url'] = route('superadmin.course.program_under_age.edit');

        return response($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function fetchAccommodationUnderAgePage(Request $request)
    {
        \Session::put('accom_id', '' . $request->value);

        $data['url'] = route('superadmin.course.accomm_under_age.edit');

        return response($data);
    }
}