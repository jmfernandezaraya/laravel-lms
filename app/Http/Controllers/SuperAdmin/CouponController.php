<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\SuperAdmin\ChooseLanguage;
use App\Models\SuperAdmin\ChooseProgramType;
use App\Models\SuperAdmin\ChooseStudyMode;
use App\Models\SuperAdmin\Coupon;
use App\Models\SuperAdmin\CouponUsage;
use App\Models\SuperAdmin\Course;
use App\Models\SuperAdmin\School;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Exception\NotReadableException;

/**
 * Class CouponController
 * @package App\Http\Controllers\SuperAdmin
 */
class CouponController extends Controller
{    
    function _getCourseChooseFields($courses)
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = Coupon::all();

        return view('superadmin.coupon.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $affiliates = User::where('user_type', 'affiliate')->get();
        
        $courses = Course::with('school')->where('deleted', false)->get();
        $choose_fields = self::_getCourseChooseFields($courses);

        return view('superadmin.coupon.add', compact('affiliates', 'courses', 'choose_fields'));
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
            'name' => 'required',
            'code' => 'required',
            'discount' => 'required',
            'type' => 'required',
            'number_of_weeks' => 'sometimes',
            'start_date' => 'sometimes',
            'end_date' => 'sometimes',
            'affiliate_id' => 'sometimes',
        ];
        $validator = \Validator::make($request->all(), $rules, [
            'name.required' => __('Admin/backend.errors.coupon_name_required'),
            'code.required' => __('Admin/backend.errors.coupon_code_required'),
            'discount.required' => __('Admin/backend.errors.coupon_discount_required'),
            'type.required' => __('Admin/backend.errors.coupon_type_required'),
            'number_of_weeks.required' => __('Admin/backend.errors.number_of_weeks_required'),
            'start_date.required' => __('Admin/backend.errors.start_date_required'),
            'end_date.required' => __('Admin/backend.errors.end_date_required'),
            'affiliate_id.required' => __('Admin/backend.errors.affiliate_required'),
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $coupon = new Coupon($validator->validated());
        $coupon_id = (new Controller())->my_unique_id();
        $exist_coupon = Coupon::where('unique_id', $coupon_id)->get();
        while (count($exist_coupon)) {
            (new Controller())->my_unique_id(1);
            $coupon_id = (new Controller())->my_unique_id();
            $exist_coupon = Coupon::where('unique_id', $coupon_id)->get();
        }
        $coupon->unique_id = $coupon_id;
        $coupon->course_unique_ids = explode(",", $request->course_unique_ids);
        $coupon->save();

        toastr()->success(__('Admin/backend.data_saved_successfully'));

        return redirect()->route('superadmin.coupon.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $coupon = Coupon::where('unique_id', $id)->first();
        $affiliates = User::where('user_type', 'affiliate')->get();
        
        $courses = Course::with('school')->where('deleted', false)->get();
        $choose_fields = self::_getCourseChooseFields($courses);

        return view('superadmin.coupon.edit', compact('coupon', 'affiliates', 'courses', 'choose_fields'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'code' => 'required',
            'discount' => 'required',
            'type' => 'required',
            'number_of_weeks' => 'sometimes',
            'start_date' => 'sometimes',
            'end_date' => 'sometimes',
            'affiliate_id' => 'sometimes',
        ];
        $validator = \Validator::make($request->all(), $rules, [
            'name.required' => __('Admin/backend.errors.coupon_name_required'),
            'code.required' => __('Admin/backend.errors.coupon_code_required'),
            'discount.required' => __('Admin/backend.errors.coupon_discount_required'),
            'type.required' => __('Admin/backend.errors.coupon_type_required'),
            'number_of_weeks.required' => __('Admin/backend.errors.number_of_weeks_required'),
            'start_date.required' => __('Admin/backend.errors.start_date_required'),
            'end_date.required' => __('Admin/backend.errors.end_date_required'),
            'affiliate_id.required' => __('Admin/backend.errors.affiliate_required'),
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $coupon = Coupon::where('unique_id', $id)->first();
        $coupon->fill($validator->validated());
        $coupon->course_unique_ids = explode(",", $request->course_unique_ids);
        $coupon->save();

        toastr()->success(__('Admin/backend.data_updated_successfully'));

        return redirect()->route('superadmin.coupon.index');
    }

    /**
     * @param Request $request
     * @param $unique_id
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function usage($unique_id)
    {
        $coupon_usages = CouponUsage::where('coupon_id', $unique_id)->get();

        return view('superadmin.coupon.usage', compact('coupon_usages'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($unique_id)
    {
        $coupon = Coupon::where('unique_id', $unique_id)->first();

        $coupon->delete();
        toastr()->success(__('Admin/backend.data_deleted_successfully'));

        return redirect()->route('superadmin.coupon.index');
    }
}